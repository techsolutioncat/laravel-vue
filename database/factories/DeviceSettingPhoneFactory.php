<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\DeviceSettingPhone::class, function (Faker $faker) {
    return [
        'device_setting_id' => $faker->numberBetween(1, 10),
        'auth_no' => $faker->numberBetween(1, 11),
        'name' => $faker->streetAddress,
        'phone' => $faker->phoneNumber,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
