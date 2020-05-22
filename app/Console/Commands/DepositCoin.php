<?php

namespace App\Console\Commands;

use App\Coin;
use App\CoinTransaction;
use App\DepositAddress;
use App\Repository\Wallet\WalletApp;
use App\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DepositCoin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposit:coin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will deposit the coins in users wallet';

    protected $wallet;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(WalletApp $wallet)
    {
        $this->wallet = $wallet;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $coin = Coin::where('coin', 'BTN')
            ->first();

        $pTransactions = $this->wallet->listTransactions("", 1000, 0);

        foreach ($pTransactions as $transaction) {

            $queryDa = DepositAddress::where('address', $transaction['address'])
                ->where('coin_id', $coin->id);

            $queryCt = CoinTransaction::where('coin_address', $transaction['address'])
                ->where('reference_no', trim($transaction['txid']));

            if(($queryDa->exists()) && (!$queryCt->exists()) && ($transaction['category'] == 'receive')){

                $coinAddress = $queryDa->first();

                $trxn = [
                    'code' => uniqid('DEP').str_random(10),
                    'user_id' => $coinAddress->user_id,
                    'coin_id' => $coin->id,
                    'source' => 'deposit',
                    'type' => 'Credit',
                    'amount' => $transaction['amount'],
                    'description' => 'Detected BTN deposit transaction in wallet',
                    'status' => 0,
                ];

                $ct = [
                    'user_id' => $coinAddress->user_id,
                    'coin_id' => $coin->id,
                    'coin_id' => $coin->id,
                    'coin_address' => $transaction['address'],
                    'reference_no' => trim($transaction['txid']),
                    'amount' => $transaction['amount'],
                    'type' => 'Credit',
                    'status' => 0,
                    'remarks' => 'Detected BTN deposit transaction in wallet',
                ];

                DB::transaction(function() use ($trxn, $ct){
                    $t = Transaction::create($trxn);
                    $ct['transaction_id'] = $t->id;
                    CoinTransaction::create($ct);
                });

            } elseif($queryCt->exists() && ($transaction['confirmations'] >= 0)) {
				
				$updateCt = $queryCt->first();
				$updateCt->status = 1;
				$updateCt->save();
				
                $updateCt->transaction->status = 1;
                $updateCt->transaction->save();
            }

        }
    }
}
