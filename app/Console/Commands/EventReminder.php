<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\model\Events;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EventReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:EventReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail three times ahead of the event day and time';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events = Events::getAllData();
        $now = Carbon::now();

        foreach ($events as $val) {
            $eventStart = Carbon::parse($val->start_event);

            if (!$eventStart->isFuture()) {
                continue;
            }

            $shouldSendReminder = $this->shouldSendReminder($eventStart, $now);

            if (!$shouldSendReminder) {
                continue;
            }

            $users = $val->event_type == Utility::GENERAL_SCHEDULE
                ? User::specialColumns('active_status', Utility::STATUS_ACTIVE)
                : collect([$this->getSingleUser($val)]);

            foreach ($users as $userData) {
                if ($userData) {
                    $this->sendReminderEmail($userData, $val);
                }
            }
        }
    }

    private function shouldSendReminder(Carbon $eventStart, Carbon $now)
    {
        $reminderTimes = [
            $eventStart->copy()->subDays(2),
            $eventStart->copy()->subMinutes(45),
            $eventStart->copy()->subMinutes(10),
        ];

        foreach ($reminderTimes as $reminderTime) {
            if ($reminderTime->isSameMinute($now)) {
                return true;
            }
        }

        return false;
    }

    private function getSingleUser($val)
    {
        return User::firstRow('id', $val->user->id);
    }

    private function sendReminderEmail($userData, $val)
    {
        $messageBody = "Hello {$userData->firstname}, an event with title {$val->event_title} will start by {$val->start_event} and end by {$val->end_event}. This is just to inform you ahead of time.";

        Notify::GeneralMail('mail_views.general', ['message' => $messageBody], $userData->email);
    }
}
