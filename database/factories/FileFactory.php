<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\File;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(File::class, function (Faker $faker) {

    $title = $faker->sentence(5);
    $filename = Str::slug($title);
    return [
        'title' => $title,
        'path' => "storage\\files\\",
        'filename' => $filename,
    ];
});
