<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\ContentType;
use App\File;
use App\Organisation;
use App\Region;
use App\Source;
use App\Topic;
use App\Author;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(8),
        'format' => rand(1,3),
        'topic_id' => function () {
            return factory(Topic::class)->create()->id;
        },
        'annotation' => $faker->text(),
        'author_id' => function () {
            return factory(Author::class)->create()->id;
        },
        'source_id' => function () {
            return factory(Source::class)->create()->id;
        },
        'organisation_id' => function () {
            return factory(Organisation::class)->create()->id;
        },
        'link' => $faker->url,
        'year' => rand(1980,2019),
        'region_id' => function () {
            return factory(Region::class)->create()->id;
        },
        'file_id' => function () {
            return factory(File::class)->create()->id;
        },
        'img'=> $faker->word . '-'. $faker->lexify('???????'). '.jpg',
        'content_type_id' => function () {
            return factory(ContentType::class)->create()->id;
        }


    ];
});
