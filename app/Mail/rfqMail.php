<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;
use Auth;
use Illuminate\Support\Facades\Log;

class rfqMail extends Mailable
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
            $subject = $company->name.' Notifications';
            $name = $company->name;
        }

        $message = $this->view('mail_views.rfq');
        $message->replyTo($this->data['fromEmail'], $name);

        $message->subject($subject);
       
        if(count($this->data['attachment']) > 0){
            foreach($this->data['attachment'] as $file){
                $message->attach($file);
            }
        }

        if(isset($this->data['copy'])){
            $mailCopy = explode(',',$this->data['copy']);
            foreach($mailCopy as $copy){
                $message->cc($copy);
            }
        }

        $message->with([ 'message' => $this->data,'itemComponents' => $this->data['rfqData'],
         'itemDetail' => $this->data['rfq'], 'rfqUrl' => $this->data['rfqUrl'] ]);
        return $message;
    }
}
