<?php

use Faker\Generator as Faker;

$factory->define(\App\Link::class, function (Faker $faker) {
    return [
        'website' => $faker->url,
        'whitepaper' => $faker->url,
        'twitter' => $faker->url,
        'slack' => $faker->url,
        'telegram' => $faker->url,
        'facebook' => $faker->url,
        'reddit' =>$faker->url,
        'bitcointalk' => $faker->url,
        'medium' => $faker->url,
        'github' => $faker->url,
        'discord' => $faker->url,
        'video' => $faker->url
    ];
});
