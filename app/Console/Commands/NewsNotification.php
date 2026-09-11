<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\LeaveLog;
use App\model\News;
use App\model\TempUsers;
use App\model\VendorCustomer;
use App\model\VendorJobCategory;
use App\model\VendorsPool;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Hash;
use Illuminate\Support\Facades\Auth;

class NewsNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:NewsNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification to all users about news content';

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
        $news = News::specialColumns('cron_status',Utility::ZERO);
        DB::transaction(function() use($news){

            //LOOP THROUGH EACH NEWS TIEM
            if($news->count()){
                foreach($news as $new){
                    $activeUsers = User::specialColumns('active_status',Utility::STATUS_ACTIVE);
                    foreach ($activeUsers as $userData){
                        $userEmail = $userData->email;

                        $mailContent = [];

                        $messageBody = "Hello '.$userData->firstname.', a new information with title ".ucfirst($new->title)." have been
                    created, please visit the portal to read";

                        $mailContent['message'] = $messageBody;
                        $mailContent['fromEmail'] = Auth::user()->email;
                        Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                    }

    
                                        
                    if($userData->cron_status == Utility::ZERO){
                        //UPDATE TABLE OF LEAVE WHERE APPROVAL OCCURS
                        News::defaultUpdate('id', $userData->id,['cron_status' => Utility::STATUS_ACTIVE]);
                    }
    
                }
            }
    

        });

    }
}
