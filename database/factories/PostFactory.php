<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Post::class, function (Faker $faker) {

    $title = $faker->word . " " . $faker->word;

    return [
        'title' => $title,
        'longTitle' => $faker->sentence,
        'slug' => $faker->word,
        'summary' => $faker->paragraph,
        'body' => $faker->paragraph . $faker->paragraph,
        'commentable' => 0,
        'featured' => 0,
        'featureimage' => '',
        'published' => 1,
        'published_at' => Carbon::now()->subDay(),
    ];
});

$factory->state(App\Post::class, 'publishing', [
    'published_at_date' => Carbon::now()->subDay()->toDateString(),
    'published_at_time' => '00:00',
]);