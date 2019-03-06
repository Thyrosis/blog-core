<?php

use Faker\Generator as Faker;

$factory->define(App\Meta::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'key' => 'first_name',
        'value' => $faker->name,
    ];
});
