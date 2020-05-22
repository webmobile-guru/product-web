<?php

namespace App\Console\Commands;

use App\CoinPair;
use App\Payback;
use Illuminate\Console\Command;

class RevertProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revert:profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will revert 25% of profit to users whose trade volume is 10000 USD';

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
        $coinPairs = CoinPair::all();

        foreach ($coinPairs as $pair) {

            $tradeFeesOfLastMonth = $pair->tradeVolume()->sum('fees');

            $distributableBaseFee = $tradeFeesOfLastMonth * 0.25;

            $summary = $pair->tradeVolume;

            foreach ($summary as $record)
            {
                $volumeValueInUsd = 0;
                $feeToRevert = 0;
                $conversionRate = 0;

                if($pair->baseCoin->coin == 'BTC') {
                    $conversionRate = $pair->baseCoin->getPriceInUsd();
                    $volumeValueInUsd = $record->volume * $conversionRate;
                    $feeToRevert = ($distributableBaseFee / $record->fees) * $conversionRate;
                } elseif ($pair->baseCoin->coin == 'USDT'){
                    $conversionRate = 1;
                    $volumeValueInUsd = $record->volume;
                    $feeToRevert = $distributableBaseFee / $record->fees;
                }

                if($volumeValueInUsd > 10000 ) {

                    // Put fees amount in a seperate tab
                    Payback::create([
                        'user_id' => $record->user_id,
                        'coin_pair_id' => $record->coin_pair_id,
                        'revert_type' => 'profit',
                        'volume' => $record->volume,
                        'volume_in_usd' => $volumeValueInUsd,
                        'fees' => $record->fees,
                        'rate_in_usd' => $conversionRate,
                        'usd_to_revert' => $feeToRevert
                    ]);

                }
            }
        }
    }
}
