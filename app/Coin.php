<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Repository\Wallet\WalletApp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'coin', 'is_base', 'status','withdraw',
        'currency_type','withdraw_enabled','withdraw_fees',
        'withdraw_min_amount','withdraw_max_amount',
        'deposit_enabled','deposit_fees', 'deposit_min_amount',
        'deposit_max_amount'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_base' => 'boolean',
        'status' => 'boolean',
        'deposit_enabled' => 'boolean',
        'withdraw_enabled' => 'boolean',
    ];

    public function address()
    {
        return $this->hasMany(DepositAddress::class, 'coin_id');
    }

    public function getHourlyChangeAttribute()
    {
        $result = DB::select("SELECT fn_get_change_percent('BTC_.$this->coin',1) AS changes");
        return isset($result[0]->changes)?$result[0]->changes:0;
    }

    public function getDailyChangeAttribute()
    {
        $result = DB::select("SELECT fn_get_change_percent('BTC_.$this->coin',24) AS changes");
        return isset($result[0]->changes)?$result[0]->changes:0;
    }

    public function getWeeklyChangeAttribute()
    {
        $result = DB::select("SELECT fn_get_change_percent('BTC_.$this->coin',168) AS changes");
        return isset($result[0]->changes)?$result[0]->changes:0;
    }

    public function scopeCrypto($query)
    {
        return $query->where('currency_type', 'Crypto');
    }

    public function scopeFiat($query)
    {
        return $query->where('currency_type', 'Fiat');
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(1);
    }

    public function getPrice()
    {
        $trade = new Trade();
        return $trade->lastPrice('BTC_'.$this->coin);
    }

    public function getPriceInUsd()
    {
        $trade = new Trade();
        $priceInUsdt = $trade->lastPrice('USDT_'.$this->coin);
        if($priceInUsdt > 0) {
            return $priceInUsdt;
        }

        $priceInBtc = $this->getPrice();

        $btcPrice = $trade->lastPrice('USDT_BTC');


        return doubleval($priceInBtc * $btcPrice);
    }

    public function balance()
    {
        return $this->hasOne(CoinWalletBalance::class, 'coin_id');
    }

    public function getBalance()
    {
        if($this->coin != 'BTN'){
            $balance = $this->balance()->pluck('balance_available')->first();
        } else {
            $client = new WalletApp();
            $balance = $client->getBalance();
        }
        
        $balance = ($balance > 0) ? $balance : 0;
        return number_format($balance, 8);
    }

    public function getBalanceFor($user)
    {
        $result = DB::select('CALL sp_get_balance(?, ?)', [$user, $this->id]);

        return ($result[0]->balance)?$result[0]->balance:0;
    }

    public function getDeposit()
    {
        $transaction = new CoinTransaction();
        $amount = $transaction->ofCoin($this->coin)
            ->deposit()->where('status',1)->sum('amount');

        $fee = $transaction->ofCoin($this->coin)
            ->deposit()->sum('fees');
        return ($amount - $fee);
    }

    public function getWithdrawal()
    {
        $transaction = new CoinTransaction();
        $amount = $transaction->ofCoin($this->coin)
            ->withdraw()->where('status',1)->sum('amount');
       
        return $amount;
    }

    public function autoWithdraw()
    {
        return ($this->withdraw == 'automatic');
    }

    public function scopeBase($query)
    {
        return $query->where('is_base', 1);
    }

    public function scopeNotBase($query)
    {
        return $query->where('is_base', 0);
    }
}
