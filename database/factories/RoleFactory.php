<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Role::class, function (Faker $faker) {
    return [
        'role' => $faker->name,
        'auth' => $faker->numberBetween(0, 20),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
