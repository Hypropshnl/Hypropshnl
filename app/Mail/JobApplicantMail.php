<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;
use Auth;

class PoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'info@company.com';
        $subject = 'Purchase Order';
        $name = 'Company Name';
        $company = Utility::companyInfo();
        if(!empty($company)){

            $address = $company->email;
            $subject = $company->name.' Info';
            $name = $company->name;
        }

        $message = $this->view('mail_views.job_applicant');
            $message->replyTo($this->data['fromEmail'], $name);

            $message->subject($subject);
        
        $file = $this->data['attachment'];
        $message->attach($file->getRealPath(), array(
            'as' => $file->getClientOriginalName(), // If you want you can chnage original name to custom name
            'mime' => $file->getMimeType())
        );

        if(isset($this->data['copy'])){
            $mailCopy = explode(',',$this->data['copy']);
            foreach($mailCopy as $copy){
                $message->cc($copy);
            }
        }

            $message->with([ 'message' => $this->data ]);
        return $message;
    }
}
