<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ContentType;
use Faker\Generator as Faker;

$factory->define(ContentType::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'code' => $faker->lexify('???')
    ];
});
