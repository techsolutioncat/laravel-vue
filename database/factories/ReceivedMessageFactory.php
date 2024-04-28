<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\ReceivedMessage;
use Faker\Generator as Faker;

$factory->define(ReceivedMessage::class, function (Faker $faker) {
    return [
        'device_report_id' => $faker->numberBetween(1, 20),
        'device_assignment_id' => $faker->numberBetween(1, 20),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
