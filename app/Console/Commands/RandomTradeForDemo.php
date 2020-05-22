<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repository\Order\OrderRepository;
use Illuminate\Support\Facades\DB;
use Ratchet\ConnectionInterface;
use App\Setting;

class RandomTradeForDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade:random';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $repositoy;
    public function __construct(OrderRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }
   
    public function handle()
    {
        $interval=60; //minutes
        set_time_limit( 0 );
        $sleep = $interval*60+(time());
        DB::purge(['demo' => 'live', 'live' => 'demo']['demo']);
        DB::setDefaultConnection('demo');
        while ( 1 ){
            //if(time() != $sleep) {
                $volume = rand(1,10);
                $user = \App\User::inRandomOrder()->first();

                $rate = $user->randomfloat(0.029,0.10);
                $command = rand(0,1);
                $buySell = ['buy', 'sell'][$command];

                $balanceOfCoin = [
                    'buy' => 'BTC', //buy buy ETH from BTC
                    'sell' => 'ETH' // sell ETH and get BTC
                ];
    
                $balance = $user->getBalance($balanceOfCoin[$buySell]);
    
                // Calculate total
                if($buySell == 'buy'){
                    $fee = (double) Setting::get_percentage_admin('buy', $rate, $volume);
                    $total_buy = (((double) $rate) * ((double) $volume));
                    $total = ( $total_buy + $fee);
                }else{
                    $total = $volume;
                }
    
                if($balance < $total) {
                    echo $user->email.' don\'t have sufficient '.$balanceOfCoin[$buySell].' balance';
                }else{
                    $currencyPair='BTC_ETH';
                    $this->repository->tradepost($rate, $volume, $buySell, $currencyPair, $user->id);
                }

               
               // time_sleep_until($sleep); 
           // }
            #do the routine job, trigger a php function and what not.
        }
        
        
    }
}
