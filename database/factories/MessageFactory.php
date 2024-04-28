<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'device_assignment_id' => $faker->numberBetween(1, 20),
        'device_signal_id' => $faker->numberBetween(1, 20),
        'message' => $faker->domainName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
