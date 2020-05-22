<?php

use Faker\Generator as Faker;

$factory->define(App\Trade::class, function (Faker $faker) {
    $volume = rand(1,10);
    $user = \App\User::inRandomOrder()->first();
    //return false;
    return [
        'user_id' => $user->id,
        'coin_pair_id' => 1,//\App\CoinPair::inRandomOrder()->pluck('id')->first(),
        'price' => $user->randomfloat(0.029,0.10),
        'volume' => $volume,
        'fees' => 0.003,
        'type' => ['buy', 'sell'][rand(0,1)],
        'status' => rand(0, 2)
    ];
});
