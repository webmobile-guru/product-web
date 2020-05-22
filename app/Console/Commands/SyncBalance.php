<?php

namespace App\Console\Commands;

use App\Coin;
use Illuminate\Console\Command;

class SyncBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize the balance from coin payment wallet';

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
        $coins = Coin::all();
        $balances = \Coinpayments::getBalances();

        foreach($coins as $coin) {
            if(isset($balances[$coin->coin])) {
                $balance = $coin->balance()->firstOrNew([
                    'coin_id' => $coin->id
                ]);

                $balance->balance_available = $balances[$coin->coin]['balancef'];

                $balance->save();
            }
        }
    }
}
