<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('user_roles')->truncate();
        DB::table('user_roles')->insert([
            [
                'role'      => 'system',
                'auth'      => 10,
            ],
            [
                'role'      => 'admin',
                'auth'      => 5,
            ],
            [
                'role'      => 'user',
                'auth'      => 1,
            ],
            ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
