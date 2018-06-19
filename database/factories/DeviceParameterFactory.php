<?php

use Faker\Generator as Faker;

$factory->define(App\DeviceParameter::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->userName,
        'name' => $faker->name,
        'unit' => null
    ];
});
