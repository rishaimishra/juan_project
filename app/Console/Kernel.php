<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            \Log::error('Testing scheduler: ');

            $now = Carbon::now(); // Get current time using Carbon

            DB::table('opportunities')
                ->where('opp_keep_time', 1)
                ->where('created_at', '<=', Carbon::now()->subWeeks(1)) // Subtract 1 week from now
                ->update(['admin_bit' => 3]);

            DB::table('opportunities')
                ->where('opp_keep_time', 2)
                ->where('created_at', '<=', Carbon::now()->subWeeks(2)) // Corrected condition
                ->update(['admin_bit' => 3]); // Use associative array for update

            DB::table('opportunities')
                ->where('opp_keep_time', 3)
                ->where('created_at', '<=', Carbon::now()->subWeeks(3)) // Corrected condition
                ->update(['admin_bit' => 3]); // Use associative array for update
                \Log::error('Opportunity Closed: ');
        })->everyMinute(); // Adjust schedule as needed
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
