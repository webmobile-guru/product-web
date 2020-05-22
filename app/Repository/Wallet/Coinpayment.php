<?php namespace App\Repository\Wallet;

class Coinpayment
{
    public static function getRates($currency)
    {
        $rates = \Coinpayments::getRates();

        return $rates[$currency]['rate_btc'];
    }

    public static function toUsd($currency, $amount)
    {
        $rateCurrencyInBtc = self::getRates($currency);

        $amountInBTC = $rateCurrencyInBtc * $amount;

        $rateUsdInBtc = 1 / self::getRates('USD');

        // price return in usd
        return $rateUsdInBtc * $amountInBTC;
    }
}