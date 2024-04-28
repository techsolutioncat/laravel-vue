<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {


    return [
        'name' => $faker->company,

        'phone' => $faker->phoneNumber,
        'postcode' => $faker->postcode,
        'address' => $faker->streetAddress,

        'owner_name' => $faker->name,
        'owner_mail' => $faker->companyEmail,

        'sb_payment_no' => $faker->numberBetween(10000, 99999).$faker->numberBetween(10000, 99999),
        'message_enabled' => $faker->boolean,

        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
