<?php

use Faker\Generator as Faker;

$factory->define(\App\CoinForList::class, function (Faker $faker) {
    $cname = $faker->word;
    return [
        'user_id' => \App\User::inRandomOrder()->pluck('id')->first(),
        'name' => $cname,
        'coin' => strtoupper(substr($cname, 0, 3)),
        'status' => 0,
        'withdraw' => 'manual',
        'withdraw_enabled' => rand(0,1),
        'deposit_enabled' => rand(0,1),
        'contact_email' => $faker->safeEmail,
        'website' => $faker->url,
        'remarks' => $faker->sentence
    ];
});
