<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;
use Auth;

class BirthdayMail extends Mailable
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
        $subject = 'Quote';
        $name = 'Company Name';
        $company = Utility::companyInfo();
        if(!empty($company)){

            $address = $company->email;
            $subject = $company->name.' Info';
            $name = $company->name;
        }
        if (array_key_exists('subject', $this->data)) {
            $subject = $this->data['subject'];
        }

        $message = $this->view('mail_views.birthday');/*
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)*/
        $message->subject($subject);


        $message->with([ 'message' => $this->data ]);
        return $message;
    }
}
