<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Sim::class, function (Faker $faker) {
    return [
        'iccid' => $faker->numberBetween(10000, 99999).
            $faker->numberBetween(10000, 99999).
            $faker->numberBetween(10000, 99999).
            $faker->numberBetween(10000, 99999),
        'msn' => $faker->phoneNumber,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
