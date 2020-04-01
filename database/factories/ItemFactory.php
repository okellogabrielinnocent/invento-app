<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'brand' => $faker->brand,
        'cost' => $faker->cost,
        'size' => Str::random(4),
        'minimum_quantity' => $faker->minimum_quantity,
        'quantity' => $faker->quantity,

        // 'code' =>Str::random(10),
        // 'saleable' => $faker->saleable
        // 'name' => $faker->name
        // 'labor' => $faker->labor,

    ];
});
