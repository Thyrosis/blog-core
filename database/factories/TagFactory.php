<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Tag::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'description' => $faker->paragraph,
    ];
});
