<?php

use Illuminate\Database\Seeder;

class DeviceSettingPhoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('device_setting_phones')->truncate();

        factory(App\DeviceSettingPhone::class, 100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
