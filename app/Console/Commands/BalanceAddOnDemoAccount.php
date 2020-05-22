<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Coin;
use App\Transaction;
use App\CoinTransaction;


class BalanceAddOnDemoAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:demo {userid}';

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
                $userId = $this->argument('userid');
                $Coin = new Coin;
                $Coin->setConnection('demo');
                $demouser = new User;
                $demouser->setConnection('demo');
                $user = $demouser::find($userId);
                $results = $Coin->where('status',1)->get();
                foreach($results as $data){
                    $cTransaction = null; $transaction = null;
            
                    $code = 'TXN'.str_random(13);
                    $transaction = [
                        'code' => $code,
                        'user_id' => $user->id,
                        'coin_id' => $data->id,
                        'amount' => ($data->coin=='BTC') ? '2':'100',
                        'source' => 'deposit',
                        'type' => 'Credit',
                        'description'=> 'Auto Credit for DEMO',
                        'status' => 1
                    ];
                    $dbtransaction = new Transaction;
                    $dbtransaction->setConnection('demo');
                    $transaction = $dbtransaction->create($transaction);
                    $cTransaction = [
                        'user_id' => $user->id,
                        'coin_id' => $data->id,
                        'transaction_id' => $transaction->id,
                        'amount' => ($data->coin=='BTC') ? '2':'100',
                        'type' => 'Credit',
                        'reference_no' => $code,
                        'coin_address' => 'SYSTEM_CREDIT',
                        'remarks' => 'Auto Credit for DEMO',
                        'status' => 1
                    ];
            
                    $coinTransaction = new CoinTransaction;
                    $coinTransaction->setConnection('demo')->create($cTransaction);
            
                }
    }
}
