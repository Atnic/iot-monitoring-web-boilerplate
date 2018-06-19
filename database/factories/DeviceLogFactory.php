<?php

use Faker\Generator as Faker;

$factory->define(App\DeviceLog::class, function (Faker $faker) {
    return [
        'device_imei' => function () {
            return factory(App\Device::class)->create()->getKey();
        },
        'device_parameter_id' => function () {
            return factory(App\DeviceParameter::class)->create()->getKey();
        },
        'value' => $faker->randomFloat(0.0, 1, 100.0),
        'logged_at' => now()->toAtomString()
    ];
});
