<?php

use Faker\Generator as Faker;

$factory->define(App\Recipe::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'procedure' => $faker->paragraph
    ];
});
