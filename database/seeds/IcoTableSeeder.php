<?php

use Illuminate\Database\Seeder;

class IcoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 20;
        do {
            $ico = factory(\App\Ico::class)->create();

            factory(\App\Link::class)->create(['ico_id' => $ico->id]);

            factory(\App\Team::class, rand(2, 10))->create(['ico_id' => $ico->id]);

            $i--;
        } while ($i > 0);
    }
}
