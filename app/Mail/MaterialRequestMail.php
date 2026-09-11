<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;
use Auth;
use Illuminate\Support\Facades\Log;

class MaterialRequestMail extends Mailable
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
        $subject = 'RFQ (Request for Quote)';
        $name = 'Company Name';
        $company = Utility::companyInfo();
        if(!empty($company)){

            $address = $company->email;
            $subject = $company->name.' MATERIAL REQUEST NOTIFICATION';
            $name = $company->name;
        }

        $message = $this->view('mail_views.material_request');
        $message->replyTo($this->data['fromEmail'], $name);

        $message->subject($subject);
       
        if(isset($this->data['copy'])){
            $mailCopy = explode(',',$this->data['copy']);
            foreach($mailCopy as $copy){
                $message->cc($copy);
            }
        }

        $message->with([ 'message' => $this->data,'itemComponents' => $this->data['mrData'], 'itemDetail' => $this->data['mr'] ]);
        return $message;
    }
}
