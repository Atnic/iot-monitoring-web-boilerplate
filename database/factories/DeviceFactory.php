<?php

use Faker\Generator as Faker;

$factory->define(App\Device::class, function (Faker $faker) {
    return [
        'imei' => $faker->unique()->isbn13,
        'name' => $faker->name,
    ];
});
