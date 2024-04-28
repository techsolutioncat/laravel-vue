<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DeviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('devices')->truncate();

        $faker = \Faker\Factory::create('ja_JP');
        DB::table('devices')->insert([
            [
                'imei'              => "863949040226775",
                'device_type_id'    => 1,
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime,
            ],
        ]);

        factory(App\Device::class, 20)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
