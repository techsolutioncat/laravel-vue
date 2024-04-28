<?php

use Illuminate\Database\Seeder;

class PhoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('phones')->truncate();

        // Phonesテーブルの初期レコード
        DB::table('phones')->insert([
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 11,
                'name'              => '指令センター',
                'phone'             => '09080607124',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 1,
                'name'              => 'コールセンター1',
                'phone'             => '0000000000000',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 2,
                'name'              => 'コールセンター2',
                'phone'             => '0000000000000',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 3,
                'name'              => 'コールセンター3',
                'phone'             => '0000000000000',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 4,
                'name'              => 'コールセンター4',
                'phone'             => '0000000000000',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 5,
                'name'              => 'コールセンター5',
                'phone'             => '0000000000000',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 6,
                'name'              => 'コールセンター6',
                'phone'             => '0000000000000',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 7,
                'name'              => 'コールセンター7',
                'phone'             => '0000000000000',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 8,
                'name'              => 'コールセンター8',
                'phone'             => '0000000000000',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 9,
                'name'              => 'コールセンター9',
                'phone'             => '0000000000000',
            ],
            [
                'device_assignment_id'     => 1,
                'auth_no'           => 10,
                'name'              => 'コールセンター10',
                'phone'             => '0000000000000',
            ],
        ]);

        //factory(App\Phone::class, 20)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
