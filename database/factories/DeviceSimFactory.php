<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\DeviceSim::class, function (Faker $faker) {
    return [
        'device_id' => $faker->numberBetween(1, 10),
        'sim_id' => $faker->numberBetween(1, 10),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
