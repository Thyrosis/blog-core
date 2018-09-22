<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'longTitle' => $faker->sentence,
        'slug' => $faker->word,
        'summary' => $faker->paragraph,
        'body' => $faker->paragraph . $faker->paragraph,
        'commentable' => 0,
        'featured' => 0,
        'featureimage' => '',
        'published' => 1,
        'published_at' => Carbon::now()->subDay()->toDateString(),
    ];
});
