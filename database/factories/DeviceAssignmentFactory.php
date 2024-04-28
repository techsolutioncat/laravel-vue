<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\DeviceAssignment::class, function (Faker $faker) {
    return [
        'device_sim_id' => factory(App\DeviceSim::class)->create(),
        'device_group_id' => $faker->numberBetween(1, 10),
        'company_id' => $faker->numberBetween(1, 10),
        'device_state_id' => $faker->numberBetween(1, 2),
        'active' => $faker->boolean,
        'name' => $faker->lastName,
        'mount_no' => $faker->numberBetween(10000000, 99999999),
        'battery' => $faker->numberBetween(0, 100),
        'applied_at' => $faker->dateTime,
        'started_at' => $faker->dateTime,
        'ended_at' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
