<?php

use Faker\Generator as Faker;

$factory->define(App\Dataset::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'remark' => $faker->paragraph,
    ];
});
