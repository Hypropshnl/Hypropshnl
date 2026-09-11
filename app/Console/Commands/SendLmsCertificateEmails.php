<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\Mail\GeneralMail;
use App\model\LMSManualCertification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendLmsCertificateEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendLmsCertificateEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send LMS manual certificate download emails for pending manual certification records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $certificates = LMSManualCertification::where('mail_status', 0)->get();

        foreach ($certificates as $certificate) {
            $recipient = $this->resolveRecipient($certificate);

            if (empty($recipient['email'])) {
                Log::warning('LMS manual certificate email skipped because recipient has no email.', [
                    'certification_id' => $certificate->id,
                ]);
                continue;
            }

            $uid = $certificate->uid;
            $uuid = $certificate->uuid;
            if (empty($uid)) {
                $uid = Utility::generateUID('lms_manual_certification');
                $certificate->uid = $uid;
                $certificate->save();
            }

            $certificateUrl = url('/lms_mnl_certification/certificate/' . $uuid);
            $courseTitle = optional($certificate->offlineCourse)->title ?: optional($certificate->offlineCourse)->name ?: 'your course';
            $userName = $recipient['name'] ?: 'Learner';

            $mailPayload = [
                'subject' => 'Your Certificate is Ready',
                'message' => $this->buildMessage($userName, $courseTitle, $certificateUrl),
            ];


            try {
                Notify::GeneralMail('mail_views.general', $mailPayload, $recipient['email']);

                $certificate->mail_status = 1;
                $certificate->save();

                $this->info('Sent certificate email to '.$recipient['email'].' for certificate id '.$certificate->id);
            } catch (\Exception $e) {
                Log::error('Failed to send LMS manual certificate email.', [
                    'certification_id' => $certificate->id,
                    'email' => $recipient['email'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return 0;
    }

    /**
     * Resolve recipient email and display name from certificate record.
     *
     * @param  LMSManualCertification  $certificate
     * @return array
     */
    protected function resolveRecipient(LMSManualCertification $certificate)
    {
        if (!empty($certificate->user_id) && $certificate->userData && !empty($certificate->userData->email)) {
            $user = $certificate->userData;
            return [
                'email' => $user->email,
                'name' => trim($user->firstname.' '.$user->othername.' '.$user->lastname),
            ];
        }

        if (!empty($certificate->temp_user) && $certificate->tempUserData && !empty($certificate->tempUserData->email)) {
            $user = $certificate->tempUserData;
            return [
                'email' => $user->email,
                'name' => trim($user->firstname.' '.$user->othername.' '.$user->lastname),
            ];
        }

        return ['email' => null, 'name' => null];
    }

    /**
     * Build the HTML email message.
     *
     * @param  string  $name
     * @param  string  $courseTitle
     * @param  string  $certificateUrl
     * @return string
     */
    protected function buildMessage($name, $courseTitle, $certificateUrl)
    {
        return '<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">'
            .'<div style="max-width: 680px; margin: 0 auto; padding: 24px; background: #f9fafc; border-radius: 14px; border: 1px solid #e1e7ef;">'
            .'<h2 style="margin-top: 0; color: #1f3b73;">Congratulations, '.htmlspecialchars($name).'</h2>'
            .'<p style="font-size: 16px; color: #4a5568;">You have successfully completed <strong>'.htmlspecialchars($courseTitle).'</strong>.</p>'
            .'<p style="font-size: 16px; color: #4a5568;">Your certificate is now ready. Use the link below to view and download your certificate.</p>'
            .'<div style="margin: 30px 0; text-align: center;">'
            .'<a href="'.htmlspecialchars($certificateUrl).'" style="display: inline-block; padding: 14px 28px; color: #ffffff; background-color: #1f3b73; text-decoration: none; border-radius: 8px; font-weight: bold;">Download Certificate</a>'
            .'</div>'
            .'<p style="font-size: 15px; color: #667085;">If the button does not work, copy and paste the following URL into your browser:</p>'
            .'<p style="word-break: break-all; font-size: 14px; color: #1a202c;">'.htmlspecialchars($certificateUrl).'</p>'
            .'<div style="margin-top: 24px; padding: 20px; background: #ffffff; border: 1px solid #dde7f0; border-radius: 10px;">'
            .'<p style="margin: 0; font-size: 15px; color: #4a5568;"><strong>Note:</strong> Keep this link safe and share it only with authorized personnel.</p>'
            .'</div>'
            .'<p style="font-size: 15px; color: #4a5568; margin-top: 24px;">Thank you for learning with us.</p>'
            .'<p style="font-size: 15px; color: #4a5568;">Best regards,<br>Training Team</p>'
            .'</div>'
            .'</div>';
    }
}
