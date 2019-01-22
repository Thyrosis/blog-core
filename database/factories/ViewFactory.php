<?php

use Faker\Generator as Faker;

$factory->define(App\View::class, function (Faker $faker) {
    $post = function () {
        return factory('App\Post')->create()->id;
    };

    return [
        'post_id' => $post->id,
        'url' => $post->link(),
        'path' => $post->path(),
        'ipaddress' => $faker->ipv4,
        'iphash' => encrypt($faker->ipv4),
    ];
});
