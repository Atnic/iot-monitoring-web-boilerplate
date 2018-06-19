<?php

use Faker\Generator as Faker;

$factory->define(App\Datum::class, function (Faker $faker) {
    return [
        'dataset_id' => function () {
            return factory(App\Dataset::class)->create()->getKey();
        },
        'parameter_id' => function () {
            return factory(App\Parameter::class)->create()->getKey();
        },
        'value' => $faker->randomFloat(0.0, 1, 100.0),
        'logged_at' => now()->toAtomString()
    ];
});
