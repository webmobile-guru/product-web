<?php

use Faker\Generator as Faker;

$factory->define(\App\Ico::class, function (Faker $faker) {
    $slugCode = str_random(30); $path = storage_path('app'.DIRECTORY_SEPARATOR.'ico'.DIRECTORY_SEPARATOR.$slugCode);
    if(!(\Illuminate\Support\Facades\File::exists($path))){
        \Illuminate\Support\Facades\File::makeDirectory($path);
    }

    $path = $faker->image($path, 800, 800, 'business');
    return [
        'slug' => $slugCode,
        'title' => $faker->sentence,
        'logo' => $path,
        'short_description' => $faker->paragraph(),
        'ico_start_at' => $faker->dateTime('Y-m-d H:i:s'),
        'ico_end_at' => $faker->dateTime('Y-m-d H:i:s'),
        'additional_notes' => $faker->sentence,

        'feature_description' => $faker->text(),

        'whitelist' => ['yes', 'no'][rand(0,1)],
        'token_sale_hard_cap' => rand(100000,10000000000),
        'token_sale_hard_cap_currency' => $faker->currencyCode,
        'token_sale_soft_cap' => rand(1000,100000),
        'token_sale_soft_cap_currency' => $faker->currencyCode,
        'presale' => ['yes', 'no'][rand(0,1)],
        'token_symbol' => ['ABC', 'CDE', 'EFG', 'GHI', 'IJK'][rand(0,4)],
        'price_per_token' => ['1 TOKEN = 0.06 USD', '1 TOKEN = 0.000006 BTC', '1 TOKEN = 0.00320 ETH'][rand(0,2)],
        'kyc' => ['yes', 'no'][rand(0,1)],
        'participation_restriction' => $faker->sentence,
        'selling_to_us_canada' => rand(0,1),
        'accept_coin' => ['USD', 'BTC', 'ETH'][rand(0,2)],

        'company_name' => $faker->company,
        'company_info' => $faker->sentence,
        'contact_person_name' => $faker->name,
        'permissions' => '["I certify that any statements provided in this form are by an authorized representative of this project, and that any public marketing materials are true and correct to the personal knowledge of the submitter.", "This project complies with the laws and regulations, specifically dealing with sales of securities, in every country/jurisdiction that it sells."]',
        'involvement' => '{"2": "I am not a Representative of this Project in any way"}',
        'contact_person_email' => $faker->email,
        'contact_person_telegram' => $faker->url,

        'marketing_services' => '{"1": "Premium Highlighted Placement", "2": "ICO Review (Video or Article)", "3": "None of the above"}',
        'listing_fee' => ['yes', 'no'][rand(0,1)],
    ];
});
