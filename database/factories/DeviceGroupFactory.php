<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\DeviceGroup::class, function (Faker $faker) {
    return [
        'group' => $faker->country,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
