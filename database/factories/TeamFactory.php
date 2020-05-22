<?php

use Faker\Generator as Faker;

$factory->define(\App\Team::class, function (Faker $faker) {
    return [
        'type' => ['core', 'advisory'][rand(0,1)],
        'full_name' => $faker->name,
        'job_title' => $faker->jobTitle,
        'link' => $faker->url
    ];
});
