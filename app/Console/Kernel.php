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
        Commands\SocketServer::class,
        Commands\DepositCoin::class,
        Commands\SyncBalance::class,
        Commands\RoboTrading::class,
        Commands\RevertFees::class,
        Commands\RevertProfit::class,
        Commands\BalanceAddOnDemoAccount::class,
        Commands\RandomTradeForDemo::class,
        Commands\GetCryptoRates::class,
        Commands\SocketTrigger::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       
	   $schedule->command('crypto:rates')
            ->everyFiveMinutes()
            ->withoutOverlapping()
			->evenInMaintenanceMode()
			->timezone('UTC');
			
		$schedule->command('execute:queue')
            ->everyMinute()
            ->withoutOverlapping()
			->evenInMaintenanceMode()
			->timezone('UTC');
			
        /*
        $schedule->command('revert:fees')
            ->monthlyOn(1, '00:00')
            ->withoutOverlapping()
            ->evenInMaintenanceMode();
        
        $schedule->command('sync:balance')
            ->everyFiveMinutes()
            ->withoutOverlapping();
			
		 $schedule->command('deposit:coin')
            ->everyFiveMinutes()
            ->withoutOverlapping();
        
        $schedule->command('robot:start')
            ->everyMinute()
            ->withoutOverlapping();*/
        
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
