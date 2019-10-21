<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Magazine;
use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Magazine::class, function (Faker $faker) {
    $title = $faker->sentence(5);
    return [
        'name' => $title,
        'link' => $faker->url(),
        'description' => $faker->text(),
        'img' => null,
        'slug' => Str::slug($title)
    ];
});
