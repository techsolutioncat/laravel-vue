<?php

use Illuminate\Database\Seeder;

class DeviceGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('device_groups')->truncate();

        // グループテーブルの初期レコード
        DB::table('device_groups')->insert([
            [
                'group'              => '実機テスト',
            ],
        ]);

        factory(App\DeviceGroup::class, 100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
