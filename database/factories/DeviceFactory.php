<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Device::class, function (Faker $faker) {
    return [
        'imei' => $faker->numberBetween(10000, 99999).
            $faker->numberBetween(10000, 99999).
            $faker->numberBetween(10000, 99999),
        'device_type_id' => $faker->numberBetween(1, 5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
