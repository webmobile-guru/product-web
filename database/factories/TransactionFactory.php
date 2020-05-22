<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'code' => 'TXN'.str_random(),
        'user_id' => \App\User::inRandomOrder()->pluck('id')->first(),
        'coin_id' => \App\Coin::inRandomOrder()->pluck('id')->first(),
        'source'=>['deposit', 'withdraw'][rand(0,1)],
        'type'=>['Credit', 'Debit'][rand(0,1)],
        'amount'=> rand(1, 5000),
        'description' => $faker->sentence,
        'status'=> 1,
    ];
});
