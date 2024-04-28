<?php

use App\Company;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('companies')->truncate();
//        factory(App\Company::class, 40)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
