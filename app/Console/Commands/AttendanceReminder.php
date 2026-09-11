<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\AttendanceRecord;
use App\model\AttendanceTimeSchedule;
use App\model\AttendanceUsers;
use App\model\Events;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AttendanceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AttendanceReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail, x number of times ahead of the Punch In/Out day and time';

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
        $attendance = AttendanceUsers::getAllData();
        foreach($attendance as $val){
            $record = AttendanceRecord::firstRow('user_id',$val->user_id);
            if(!empty($record)){
                $schedule = AttendanceTimeSchedule::firstRow('id',$val->schedule_id);
                $currTime = Carbon::now($schedule->timeZone->name);
                $startTime = Carbon::parse($schedule->start_time);
                $endTime = Carbon::parse($schedule->end_time);
                $startbefore = $startTime->copy()->subMinutes(15);
                $startAfter = $startTime->copy()->addMinutes(15);
                $endbefore = $endTime->copy()->subMinutes(15);
                $endAfter = $endTime->copy()->addMinutes(15);

                if($currTime == $startTime || $currTime == $endTime || $currTime == $startbefore ||  $currTime == $startAfter || $currTime == $endbefore || $currTime == $endAfter){

                        $userEmail = $val->userData->email;

                        $mailContent = [];

                        $messageBody = "Hello ".$val->userData->firstname.", it appears you have not recorded your attendance for today. ";

                        $mailContent['message'] = $messageBody;
                        Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);


                }
            }
        }

    }
}
