<?php

use App\DeviceSignal;
use Illuminate\Database\Seeder;

class DeviceSignalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('device_signals')->truncate();
        // DeviceTypeテーブルの初期レコード
//        DB::table('device_signals')->insert(DeviceSignal::getRows());

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
