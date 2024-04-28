<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DeviceStateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('device_states')->truncate();

        $faker = \Faker\Factory::create('ja_JP');
        DB::table('device_states')->insert([
            [
                'state'    => '利用中',
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime,
            ],
            [
                'state'    => '利用停止',
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime,
            ],
            [
                'state'    => '休止',
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime,
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
