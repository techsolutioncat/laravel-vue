<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(CompanyTableSeeder::class);
//        $this->call(UserTableSeeder::class);
//
//        $this->call(RoleTableSeeder::class);
//        $this->call(DeviceStateTableSeeder::class);
//
//        $this->call(DeviceSignalTableSeeder::class);
////        $this->call(SimTableSeeder::class);
//        $this->call(DeviceGroupTableSeeder::class);
//        $this->call(DeviceTypeTableSeeder::class);
//        $this->call(DeviceTableSeeder::class);

        $this->call(DeviceReportTableSeeder::class);
//        $this->call(DeviceSimTableSeeder::class);
//        $this->call(DeviceAssignmentSeeder::class);

//        $this->call(MessageTableSeeder::class);
//        $this->call(ReceivedMessageTableSeeder::class);
//        $this->call(PhoneTableSeeder::class);
//        $this->call(DeviceSettingTableSeeder::class);
//        $this->call(DeviceSettingPhoneTableSeeder::class);
    }
}
