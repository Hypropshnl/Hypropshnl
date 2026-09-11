<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        'App\Console\Commands\InventoryReorderLevel',
        'App\Console\Commands\Birthday',
        'App\Console\Commands\BirthdayForTempUsers',
        'App\Console\Commands\InventoryContractNotify',
        'App\Console\Commands\LoanDeduction',
        'App\Console\Commands\OdometerLogReminder',
        'App\Console\Commands\VehicleMaintenanceScheduling',
        'App\Console\Commands\EventReminder',
        'App\Console\Commands\LeaveDates',
        'App\Console\Commands\VendorApprovedTransfer',
        'App\Console\Commands\VehicleComplianceChecklist',
        'App\Console\Commands\LeaveUsersNotification',
        'App\Console\Commands\NewsNotification',
        'App\Console\Commands\AttendanceReminder',
        'App\Console\Commands\SendLmsCertificateEmails',
        'App\Console\Commands\DocumentDueDateReminder',

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('command:InventoryReorder')
            ->weekly();

        $schedule->command('command:VehicleMaintenanceScheduling')
            ->daily();

        $schedule->command('command:Birthday')
            ->daily();

        $schedule->command('command:BirthdayForTempUsers')
            ->daily();

        $schedule->command('command:OdometerLogReminder')
            ->daily();

        $schedule->command('command:EventReminder')
            ->everyMinute();

        $schedule->command('command:LoanDeduction')
            ->daily();

        $schedule->command('command:LeaveDates')
            ->weekly();

        $schedule->command('command:VendorApprovedTransfer')
        ->everyMinute();

        $schedule->command('command:SendLmsCertificateEmails')
            ->everyMinute();

        $schedule->command('command:VehicleComplianceChecklist')
            ->daily();

        $schedule->command('command:LeaveUsersNotification')
            ->everyMinute();

        $schedule->command('command:NewsNotification')
            ->everyMinute();

        $schedule->command('command:AttendanceReminder')
            ->everyMinute();
        
        $schedule->command('command:DocumentNotification')
            ->everyMinute();

        $schedule->command('command:DocumentDueDateReminder')
            ->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
