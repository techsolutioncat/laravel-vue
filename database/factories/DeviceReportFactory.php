<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\DeviceReport::class, function (Faker $faker) {
    return [
        'device_assignment_id' => $faker->numberBetween(1, 10),
        'device_signal_id' => $faker->numberBetween(1, 10),
        'lat' => $faker->numberBetween(100, 150),
        'lng' => $faker->numberBetween(100, 150),
        'battery' => $faker->numberBetween(10, 100),
        'dealt_with_at' => $faker->randomElement([null, $faker->dateTime]),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
