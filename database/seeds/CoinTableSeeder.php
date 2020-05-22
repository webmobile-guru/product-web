<?php

use Illuminate\Database\Seeder;

class CoinTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coins')->insert([
            'name' => 'US Dollar',
            'coin' => 'USD',
            'is_base' => 1,
            'status' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('coins')->insert([
            'name' => 'Bitcoin',
            'coin' => 'BTC',
            'is_base' => 0,
            'status' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('coins')->insert([
            'name' => 'Etherium',
            'coin' => 'ETH',
            'is_base' => 0,
            'status' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('coins')->insert([
            'name' => 'JPCoin',
            'coin' => 'JPC',
            'is_base' => 0,
            'status' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
