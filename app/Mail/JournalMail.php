<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;

class JournalMail extends Mailable
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
        $subject = 'Info';
        $name = 'Company Name';
        $company = Utility::companyInfo();
        if(!empty($company)){

            $address = $company->email;
            $subject = $company->name.' Notifications';
            $name = $company->name;
        }

        $message = $this->view('mail_views.finance_transactions');
        $message->replyTo($this->data['fromEmail'], $name);

        $message->subject($subject);

        if(isset($this->data['copy'])){
            $mailCopy = explode(',',$this->data['copy']);
            foreach($mailCopy as $copy){
                $message->cc($copy);
            }
        }

        $message->with([ 'message' => $this->data,'itemComponents' => $this->data['journalData'],
         'itemDetail' => $this->data['journal'], 'currencyCode' => $this->data['currency'] ]);

        return $message;
    }
}
