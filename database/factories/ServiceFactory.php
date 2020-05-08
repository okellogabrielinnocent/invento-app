<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Integer;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'labor' => $faker->random_int(2, 4),
    ];
});
