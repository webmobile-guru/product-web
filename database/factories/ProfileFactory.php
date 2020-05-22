<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip' => $faker->postcode,
        'phone' => $faker->phoneNumber,
        'country_id' => \App\Country::inRandomOrder()->pluck('id')->first(),
        'dob' => $faker->date('Y-m-d', 'now'),
        'ide_no' => $faker->ssn,
        'ide_proof_photo' => $faker->imageUrl(),
        'avatar' => $faker->imageUrl(),
        'role' => ['admin', 'subscriber'][rand(0,1)],
        'referred_by' => \App\User::inRandomOrder()->pluck('id')->first(),
        'referral_code' => uniqid('REF-'),
        'created_by' => ['self', 'admin'][rand(0,1)],
        'verification_token' => str_random(60),
    ];
});
