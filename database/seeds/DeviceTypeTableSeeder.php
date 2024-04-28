<?php

use Illuminate\Database\Seeder;

class DeviceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('device_types')->truncate();

        // DeviceTypeテーブルの初期レコード
        DB::table('device_types')->insert([
            [
                'type'              => 'H-TL401L',
            ],
            [
                'type'              => 'H-TL402L',
            ],
            [
                'type'              => 'H-TL403L',
            ],
            [
                'type'              => 'H-TL404L',
            ],
            [
                'type'              => 'H-TL405L',
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
