<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VendorQuoteProposalMail extends Mailable
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
        $subject = 'Quote Proposal';
        $name = 'Company Name';
        $company = Utility::companyInfo();
        if(!empty($company)){

            $address = $company->email;
            $subject = $company->name.' Notifications';
            $name = $company->name;
        }

        $message = $this->view('mail_views.vendor_quote_proposal');
        $message->replyTo(Auth::user()->email, $name);

        $message->subject($subject);
        $message->cc(Auth::user()->email);

        $message->with([ 'message' => $this->data,'itemComponents' => $this->data['quoteData'],
         'itemDetail' => $this->data['quote'], 'quoteResponseUrl' => $this->data['quoteResponseUrl'],
        'comment' => $this->data['comment'] ]);
        return $message;
    }
}
