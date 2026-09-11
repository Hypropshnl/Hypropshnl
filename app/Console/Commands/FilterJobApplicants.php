<?php
// app/Console/Commands/FilterApplicants.php
namespace App\Console\Commands;

use App\Helpers\Utility;
use App\model\JobApplicants;
use App\Models\Jobs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;

class FilterJobApplicants extends Command
{
    protected $signature = 'ats:filter-applicants';
    protected $description = 'Process pending applicants and filter based on job keywords';
    
    public function handle()
    {
        $this->info('Starting applicant filtering process...');
        
        // Get pending applicants
        $applicants = JobApplicants::where('cron_status', Utility::ZERO)
            ->whereNull('cv_content')
            ->get();
        
        if ($applicants->isEmpty()) {
            $this->info('No pending applicants to process.');
            return;
        }
        
        foreach ($applicants as $applicant) {
            $this->processApplicant($applicant);
        }
        
        $this->info('Filtering process completed!');
    }
    
    protected function processApplicant(JobApplicants $applicant)
    {
        try {
            // Extract text from CV
            $cvText = $this->extractCVContent($applicant->cv_file);
            
            if (empty($cvText)) {
                $this->error("Failed to extract content from CV: {$applicant->cv_file}");
                $applicant->cron_status = Utility::STATUS_ACTIVE; // Mark as processed to avoid reprocessing
                $applicant->match_score = 0;
                $applicant->save();
                return;
            }
            
            // Store extracted content
            $applicant->cv_content = $cvText;
            
            // Get job keywords
            $job = $applicant->job;
            $keywords = $job->getKeywordsArray();
            if (empty($keywords)) {
                $this->info("Job {$job->title} has no keywords defined.");
                $applicant->match_score = 0;
                $applicant->cron_status = Utility::STATUS_ACTIVE; // Mark as processed
                $applicant->save();
                return;
            }
            
            // Calculate match score based on keyword weights
            $matchScore = $this->calculateMatchScore($cvText, $keywords);
            $applicant->match_score = $matchScore;
            
            // Decision logic based on match score
            $threshold = !empty($job->weighted_score) ? $job->weighted_score : 50; // 50% threshold
            if ($matchScore >= $threshold) {
                
                $this->info("Applicant {$applicant->name} APPROVED with score: {$matchScore}%");
            } else {
                $this->info("Applicant {$applicant->name} REJECTED with score: {$matchScore}%");
                
                // Delete CV file if rejected
                if($job->action_taken === Utility::STATUS_ACTIVE && !empty($applicant->cv_file) && file_exists(Utility::FILE_URL($applicant->cv_file))) {
                    unlink(Utility::FILE_URL($applicant->cv_file));
                    $this->info("CV file deleted for rejected applicant: {$applicant->name}");
                }
            }
            $applicant->cron_status = Utility::STATUS_ACTIVE; // Processed
            $applicant->save();
            
        } catch (\Exception $e) {
            $this->error("Error processing applicant {$applicant->id}: " . $e->getMessage());
        }
    }
    
    protected function extractCVContent($filePath)
    {
        $fullPath = Utility::FILE_URL($filePath);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        $content = '';
        
        switch (strtolower($extension)) {
            case 'txt':
                $content = file_get_contents($fullPath);
                break;
                
            case 'pdf':
                $content = $this->extractPDFContent($fullPath);
                break;
                
            case 'doc':
            case 'docx':
                $content = $this->extractWordContent($fullPath);
                break;
                
            default:
                $this->error("Unsupported file type: {$extension}");
        }
        
        return strtolower($content);
    }
    
    protected function extractPDFContent($filePath)
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            return $pdf->getText();
        } catch (\Exception $e) {
            $this->error("PDF parsing error: " . $e->getMessage());
            return '';
        }
    }
    
    protected function extractWordContent($filePath)
    {
        try {
            $phpWord = IOFactory::load($filePath);
            $text = '';
            
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . ' ';
                    }
                }
            }
            
            return $text;
        } catch (\Exception $e) {
            $this->error("Word parsing error: " . $e->getMessage());
            return '';
        }
    }
    
    protected function calculateMatchScore($text, $keywords)
    {
        if (empty($keywords)) {
            return 0;
        }
        
        $textWords = str_word_count($text, 1);
        $matchedKeywords = [];
        $totalScore = 0;
        $maxPossibleScore = 0;

        foreach ($keywords as $index => $keyword) {

            // Weight based on position in keyword list (earlier keywords have higher weight)
            $weight = count($keywords) - $index;

            // Calculate maximum possible score (if all keywords found at least once)
            $maxPossibleScore += $weight;

            $keyword = strtolower(trim($keyword));
            if (empty($keyword)) continue;
            
            // Count occurrences of keyword in text
            $occurrences = substr_count($text, $keyword);
            
            // if ($occurrences > 0) {
            //     $matchedKeywords[$keyword] = $occurrences;
            //     $score = $occurrences * $weight;
            //     $totalScore += $score;
            // }

            if ($occurrences > 0) {
                $matchedKeywords[$keyword] = $occurrences;
                $score = $weight;
                $totalScore += $score;
            }
        }
        
               
        $percentage = $maxPossibleScore > 0
            ? ($totalScore / $maxPossibleScore) * 100
            : 0;
        
        $this->info("Matched keywords: " . implode(', ', array_keys($matchedKeywords)));
        
        return round($percentage,2);
    }
}