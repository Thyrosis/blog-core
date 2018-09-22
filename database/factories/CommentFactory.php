<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'post_id' => function () {
            return factory('App\Post')->create()->id;
        },
        'name' => $faker->name,
        'emailaddress' => $faker->email,
        'body' => $faker->paragraph . $faker->paragraph,
    ];
});
