<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    $company = factory(App\Company::class)->create();
    return [
        'name' => $company->name,
        'login_id' => $faker->unique()->userName,
        'company_id'    => $company->id,
        'user_role_id'       => $faker->numberBetween(1, 3),
        'enabled'       => $faker->boolean,
        'password' => Hash::make('password'),
        'remember_token' => Str::random(10),
        'login_verified_at' => now(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
