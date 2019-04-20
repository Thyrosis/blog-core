<?php

use Faker\Generator as Faker;

$factory->define(App\Media::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'label' => $faker->word,
        'description' => $faker->sentence,
        'filename' => $faker->word,
        'filepath' => '/path/to/file/jfkdlajfkda.jpg',
        'filetype' => $faker->mimeType,
    ];
});
