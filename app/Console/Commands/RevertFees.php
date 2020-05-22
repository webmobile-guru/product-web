<?php

namespace App\Console\Commands;

use App\CoinPair;
use App\Payback;
use Illuminate\Console\Command;

class RevertFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revert:fees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
        $coinPairs = CoinPair::whereHas('listedBy')->get();

        foreach ($coinPairs as $pair) {

            $tradeVolumeOfLastMonth = $pair->tradeVolume()->sum('volume');
            $tradeFeesOfLastMonth = $pair->tradeVolume()->sum('fees');

            $volumeValueInUsd = 0;
            $feeToRevert = 0;
            $conversionRate = 0;

            if($pair->baseCoin->coin == 'BTC') {
                $conversionRate = $pair->baseCoin->getPriceInUsd();
                $volumeValueInUsd = $tradeVolumeOfLastMonth * $conversionRate;
                $feeToRevert = ($tradeFeesOfLastMonth * $conversionRate) * 0.5;
            } elseif ($pair->baseCoin->coin == 'USDT'){
                $conversionRate = 1;
                $volumeValueInUsd = $tradeVolumeOfLastMonth;
                $feeToRevert = $tradeFeesOfLastMonth * 0.5;
            }

            if($volumeValueInUsd > 1000000 ) {
                // Put fees amount in a seperate tab
                Payback::create([
                    'user_id' => $pair->listedBy->id,
                    'coin_pair_id' => $pair->id,
                    'revert_type' => 'fees',
                    'volume' => $tradeVolumeOfLastMonth,
                    'volume_in_usd' => $volumeValueInUsd,
                    'fees' => $feeToRevert,
                    'rate_in_usd' => $conversionRate,
                    'usd_to_revert' => $feeToRevert
                ]);

            }

        }
    }
}