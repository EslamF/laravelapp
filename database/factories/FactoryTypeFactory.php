<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Organization\FactoryType;
use Faker\Generator as Faker;

$factory->define(FactoryType::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
