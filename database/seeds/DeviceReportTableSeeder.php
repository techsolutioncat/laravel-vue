<?php

use Illuminate\Database\Seeder;

class DeviceReportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('device_reports')->truncate();

        $faker = \Faker\Factory::create('ja_JP');
        DB::table('device_reports')->insert([
            [
                'device_assignment_id'         => 1,
                'device_signal_id'             => 1,
                'lat'                   => 100,
                'lng'                   => 100,
                'battery'               => 100,
                'dealt_with_at'         => $faker->dateTime(),
                'created_at'            => $faker->dateTime(),
                'updated_at'            => $faker->dateTime(),
            ],
        ]);

        factory(App\DeviceReport::class, 100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
