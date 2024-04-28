<?php

use Illuminate\Database\Seeder;

class DeviceAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('device_assignments')->truncate();

        $faker = \Faker\Factory::create('ja_JP');
        DB::table('device_assignments')->insert([
            [
                'device_sim_id'     => 1,
                'device_group_id'    => 1,
                'device_state_id'    => 1,
                'company_id'    => 1,
                'active'    => true,
                'name'      => 'テスト端末',
                'battery'           => 100,
                'mount_no'           => 11111111,
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime,
            ],
            [
                'device_sim_id'     => 1,
                'device_group_id'    => 2,
                'device_state_id'    => 2,
                'company_id'    => 1,
                'active'    => true,
                'name'      => 'テスト端末',
                'battery'           => 100,
                'mount_no'           => 11111111,
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime,
            ],
            [
                'device_sim_id'     => 1,
                'device_group_id'    => 3,
                'device_state_id'    => 1,
                'company_id'    => 3,
                'active'    => true,
                'name'      => 'テスト端末',
                'battery'           => 100,
                'mount_no'           => 11111111,
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime,
            ],
            [
                'device_sim_id'     => 1,
                'device_group_id'    => 4,
                'device_state_id'    => 1,
                'company_id'    => 1,
                'active'    => true,
                'name'      => 'テスト端末',
                'battery'           => 100,
                'mount_no'           => 11111111,
                'created_at'        => $faker->dateTime,
                'updated_at'        => $faker->dateTime,
            ],
        ]);

        factory(App\DeviceAssignment::class, 100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
