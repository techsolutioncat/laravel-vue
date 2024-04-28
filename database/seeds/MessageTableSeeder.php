<?php

use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('messages')->truncate();

        $faker = \Faker\Factory::create('ja_JP');

        $values = [];
        for($i=1; $i<=7;$i++) {
            $values[] = [
                'device_assignment_id' => 1,
                'device_signal_id' => $i,
                'message' => $i.' message',
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ];
        }
        DB::table('messages')->insert($values);

        factory(App\Message::class, 100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
