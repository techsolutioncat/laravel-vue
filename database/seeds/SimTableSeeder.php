<?php

use Illuminate\Database\Seeder;

class SimTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('sims')->truncate();
        // DeviceTypeテーブルの初期レコード
        DB::table('sims')->insert([
            [
                'iccid'     => '8981200290670155033',
                'msn'       => '08044618109',
            ],
            [
                'iccid'     => '8981200290670155058',
                'msn'       => '08048300028',
            ]
        ]);

//        factory(App\Sim::class, 20)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
