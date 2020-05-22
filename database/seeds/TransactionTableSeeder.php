<?php

use Illuminate\Database\Seeder;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [4, 8, 9, 10, 11, 12, 13, 14, 17];

        $coins = [1,2,3,4,5,6,8,9,10];
        $amount = [
            1 => 5, 2 => 10000,
            3 => 5, 4 => 5,
            5 => 5, 6 =>5,
            8 =>5, 9 => 5,
            10 => 5
        ];

        foreach ($users as $user) {
            foreach ($coins as $coin) {
                $t = factory(\App\Transaction::class)->create();
                $t->user_id = $user;
                $t->coin_id = $coin;
                $t->amount = $amount[$coin];
                $t->source = 'deposit';
                $t->type = 'Credit';
                $t->save();
            }
        }
    }
}
