<?php

use App\Company;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();

        // usersテーブルの初期レコード
        $faker = \Faker\Factory::create('ja_JP');

        DB::table('users')->insert([
            [
                'name'          => 'system_test',
                'login_id'      => 'system',
                'password'      => Hash::make('password'),
                'company_id'    => 1,
                'user_role_id'  => 1,
                'enabled'       => true,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ],
            [
                'name'          => 'admin_test',
                'login_id'      => 'admin',
                'password'      => Hash::make('password'),
                'company_id'    => 2,
                'user_role_id'  => 2,
                'enabled'       => true,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ],
            [
                'name'          => 'user_test',
                'login_id'      => 'user',
                'password'      => Hash::make('password'),
                'company_id'    => 3,
                'user_role_id'  => 3,
                'enabled'       => true,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ],
        ]);

//        factory(User::class, 100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
