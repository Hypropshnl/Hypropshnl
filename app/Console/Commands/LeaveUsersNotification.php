<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\LeaveLog;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeaveUsersNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LeaveUsersNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification to all users about approved leave';

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
        $leaves = LeaveLog::specialColumnsDate2('approval_status',Utility::APPROVED,'cron_status',Utility::ZERO,'start_date',today());
        DB::transaction(function() use($leaves){

            

            //LOOP THROUGH EACH APPROVED LEAVE
            if($leaves->count()){
                $activeUsers = User::specialColumns('active_status',Utility::STATUS_ACTIVE);
                foreach($leaves as $userData){
                    
                    $startDate = $userData->start_date;
                    $today = Carbon::today();
                    $humanStartDate = Carbon::parse($startDate)->format('l, jS F Y');
                    $humanEndDate = Carbon::parse($userData->end_date)->format('l, jS F Y');

                    // Days difference
                    $days = $today->diffInDays($startDate); // absolute difference

                    if($days <= 2){

                        $mailContent = [];
                        $mailContent['subject'] = 'Employee Leave Notification (' . $userData->user_c->firstname.' '.$userData->user_c->lastname. ')';
                        
                        $messageBody = '
                        <div style="font-family: Arial, sans-serif; line-height: 1.6;">
                            <p>Dear team,</p>
                            <p>This is to inform you that <strong>' . $userData->user_c->firstname.' '.$userData->user_c->lastname. '</strong>, 
                            will commence on <strong>' . e($userData->leaveType->leave_type) . '</strong> leave from 
                            <strong>' . $humanStartDate . '</strong> to <strong>' .$humanEndDate . '</strong>.</p>
                            <p>' . $userData->user_c->firstname.' will resume to work on the next working day after the end date.</p>
                            <p>If you have any urgent matter that may require ' ."". $userData->user_c->firstname."'s".' immediate attention, kindly reach out to 
                            <strong>' . e($userData->department->dept_name) . '</strong> unit.</p>
                            <br>
                            <p>Regards,<br>HR Team</p>
                            <hr>
                            <small>Thank you<br>Please do not reply to this automated message.</small>
                        </div>
                        ';

                        $mailContent['message'] = $messageBody;

                        if(!empty($activeUsers)){
                            foreach($activeUsers as $user){
                                Notify::GeneralMail('mail_views.general', $mailContent, $user->email);
                            }
                        }
                                        
                        if($userData->cron_status == Utility::ZERO){
                            //UPDATE TABLE OF LEAVE WHERE APPROVAL OCCURS
                            LeaveLog::defaultUpdate('id', $userData->id,['cron_status' => Utility::STATUS_ACTIVE]);
                        }
                    }
    
                }
            }
    

        });

    }
}
