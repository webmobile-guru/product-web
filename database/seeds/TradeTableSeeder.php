<?php

use Illuminate\Database\Seeder;

class TradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Trade::class, 200)->create();
    }
}
