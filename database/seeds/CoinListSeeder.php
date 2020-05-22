<?php

use Illuminate\Database\Seeder;

class CoinListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CoinForList::class, 10)->create();
    }
}
