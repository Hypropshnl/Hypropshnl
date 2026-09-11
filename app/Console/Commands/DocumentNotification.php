<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\Documents;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Hash;
use Illuminate\Support\Facades\Auth;

class DocumentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DocumentNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification to all users about document content';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $document = Documents::specialColumns('cron_status',Utility::ZERO);
        DB::transaction(function() use($document){

            //LOOP THROUGH EACH document TIEM
            if($document->count()){
                foreach($document as $oldData){
                    if(!empty(json_decode($oldData->departments)) || !empty (json_decode($oldData->accessible_users))){
                        $activeUsers = User::massDataMassOrCondition('dept_id',json_decode($oldData->departments), 'id', json_decode($oldData->accessible_users));
                
                        foreach ($activeUsers as $userData){
                            $userEmail = $userData->email;

                            $mailContent = [];

                            $messageBody = "Hello $userData->firstname, a document with the title ucfirst($oldData->doc_name) have been
                            created by ".Auth::user()->firstname." ".Auth::user()->lastname.", please visit the Document management System in the portal for access";

                            if($oldData->updated_at > $oldData->created_at){
                                $messageBody = "Hello $userData->firstname, the document(s) attached to $oldData->doc_name have been updated by ".Auth::user()->firstname.
                                " ".Auth::user()->lastname.", please visit the Document management System in the portal for access";
                            }
                        

                            $mailContent['subject'] = 'Document Control Notification';
                            $mailContent['message'] = $messageBody;
                            $mailContent['fromEmail'] = Auth::user()->email;
                            Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                        }

        
                                            
                        if($userData->cron_status == Utility::ZERO){
                            //UPDATE TABLE OF LEAVE WHERE APPROVAL OCCURS
                            Documents::defaultUpdate('id', $userData->id,['cron_status' => Utility::STATUS_ACTIVE]);
                        }
                    }
    
                }
            }
    

        });

    }
}
