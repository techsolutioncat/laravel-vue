<?php

use App\ReceivedMessage;
use Illuminate\Database\Seeder;

class ReceivedMessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('received_messages')->truncate();

        factory(ReceivedMessage::class, 100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
