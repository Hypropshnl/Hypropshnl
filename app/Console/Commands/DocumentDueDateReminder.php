<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\DocumentFiles;
use App\model\Documents;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DocumentDueDateReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DocumentDueDateReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send due-date reminder emails for documents and document files';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $documents = Documents::where('status', Utility::STATUS_ACTIVE)
            ->whereNotNull('due_date')
            ->whereDate('due_date', $today)
            ->get();

        foreach ($documents as $document) {
            $this->sendReminder($document, 'document');
        }

        $documentFiles = DocumentFiles::where('status', Utility::STATUS_ACTIVE)
            ->whereNotNull('due_date')
            ->whereDate('due_date', $today)
            ->get();

        foreach ($documentFiles as $documentFile) {
            $this->sendReminder($documentFile, 'document_file');
        }
    }

    private function sendReminder($record, $type)
    {
        $departments = $type === 'document' ? json_decode($record->departments, true) : json_decode($record->document->departments, true);
        $accessibleUsers = $type === 'document' ? json_decode($record->accessible_users, true) : json_decode($record->document->accessible_users, true);

        $recipients = User::where('status', Utility::STATUS_ACTIVE)
            ->where('active_status', Utility::STATUS_ACTIVE)
            ->where(function ($query) use ($departments, $accessibleUsers) {
                $query->whereIn('dept_id', $departments ?: [])
                    ->orWhereIn('id', $accessibleUsers ?: []);
            })
            ->get();

        if ($recipients->isEmpty()) {
            return;
        }

        $name = $type === 'document' ? $record->doc_name : ($record->document->doc_name ?? 'Document');
        $dateLabel = $record->due_date;

        $subject = 'Document Due Date Reminder';
        $message = "Hello, this is a reminder that the document '{$name}' is due today {$dateLabel} for update, please visit the Document management System in the portal for review.";
        
        foreach ($recipients as $user) {
            if (empty($user->email)) {
                continue;
            }

            $mailContent = [
                'subject' => $subject,
                'message' => $message,
            ];

            Notify::GeneralMail('mail_views.general', $mailContent, $user->email);
        }
    }
}
