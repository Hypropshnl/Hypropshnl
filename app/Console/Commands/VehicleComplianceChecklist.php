<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\model\VehicleComplianceChecklist as ModelVehicleComplianceChecklist;
use Illuminate\Console\Command;
use Carbon\Carbon;

class VehicleComplianceChecklist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:VehicleComplianceChecklist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail notifications to drivers and fleet managers when vehicle is due for compliance';

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
        $checklist = ModelVehicleComplianceChecklist::getAllData();
        foreach ($checklist as $data){

            //MESSAGE BODY AND CONTENT TO PUSH OUT TO CONCERNED USERS
            $mailContent = [];
            $messageBody = "Hello, $data->name audit date is $data->next_audit_date,
             please ensure your team is ready for audit ";

            $mailContent['message'] = $messageBody;

            $today = date('Y-m-d');
            $currMonth = date('n');
            $currYear = date('Y');
            $nextYear = $currYear + 1;
            //CHECK MAIL NOTIFICATION DATE IF TODAY SEND OUT MAIL
            if(!empty($data->next_audit_date)){
                $dateTime1 = date("Y-m-d", strtotime(Carbon::parse($data->next_audit_date)->subDays(2)));
                $dateTime2 = date("Y-m-d", strtotime(Carbon::parse($data->next_audit_date)->subDays(1)));

                if($today == $data->next_audit_date || $dateTime1 == $today || $dateTime2 == $today){
                    $mailArray = explode(',', $data->prompt_emails);
                    foreach($mailArray as $mail){
                        Notify::GeneralMail('mail_views.general', $mailContent, $mail);
                    }
                    
                    if($data->next_audit_date == $today){
                        $newNextDate = $nextYear.'-'.$currMonth.'-'.date('d');
                        $payLoad = ['next_audit_date'=> $newNextDate, 'last_audit_date' => $data->next_audit_date];
                        VehicleComplianceChecklist::defaultUpdate('id',$data->reminder_id,$payLoad);
                    }
                    
                }
            }

        }

    }
}
