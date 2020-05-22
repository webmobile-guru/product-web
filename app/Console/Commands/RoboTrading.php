<?php

namespace App\Console\Commands;

use App\Setting;
use App\CoinPair;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use App\Repository\Order\OrderRepository;
use App\Http\Controllers\ExchangeController;
use Illuminate\Support\Facades\Log;
use Ratchet\Client\WebSocket;

class RoboTrading extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will start a robo trading between some value';

    protected $repository, $setting;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderRepository $repository, Setting $setting)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->setting = $setting;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        while(true)
        {
            $users = [4, 8, 9, 10, 11, 12, 13, 14, 17]; //Got from db
            $commands = ['buy', 'sell']; // The operations

            $currentUserID = array_random($users);
            $currentCommand = array_random($commands);

            $coinPair = CoinPair::where('pair_name', 'BTC_BCH')->get();
            //$coinPair = CoinPair::active()->get();

            foreach($coinPair as $pair)
            {
                $robotStatus = true;

                if($robotStatus) {

                    $lowestPrice = 200 /** 10000000*/;
                    $highestPrice = 300 /** 10000000*/;

                    $lowestAmount = 1 * 10000000;
                    $highestAmount = 10 * 10000000;

                    $rate = mt_rand($lowestPrice, $highestPrice) /*/ 100000000*/;

                    $amount = mt_rand($lowestAmount, $highestAmount) / 100000000;

                    if($currentCommand == 'buy') {
                        $feeAmount = $this->setting->get_percentage_admin('buy', $rate, $amount);

                        $total_buy = ((float) $rate * (float) $amount);
                        $total = ($total_buy + $feeAmount);
                    } else {
                        $total = $amount;
                    }

                    // Get balance of coin
                    $balanceOfCoin = [
                        'buy' => $pair->baseCoin->getBalanceFor($currentUserID),
                        'sell' => $pair->pairCoin->getBalanceFor($currentUserID)
                    ];


                    $balance = $balanceOfCoin[$currentCommand];

                    if($balance >= $total) {

                        $req = new Request([
                            'currencyPair' => $pair->pair_name,
                            'rate' => $rate,
                            'amount' => $amount,
                            'command' => $currentCommand,
                            'user' => $currentUserID
                        ]);

                        $ctrl = new ExchangeController($this->repository);

                        $response = $ctrl->orderPost($req);


                        /*\Ratchet\Client\connect('ws://localhost:8095')->then(function($conn) use($pair, $currentUserID) {
                            $conn->on('message', function($msg) use ($conn) {
                                Log::info("Received: {$msg}");
                                $conn->close();
                            });

                            $conn->send('{"channel": 2000,"currencyPair":"'.$pair->pair_name.'","params": {"id":'.$currentUserID.', "type":"buysell"}}');
                        }, function ($e) {
                            Log::error("Could not connect: {$e->getMessage()}");
                        });*/

                        Log::info($response);
                    }
                }
            }
        }
    }
}