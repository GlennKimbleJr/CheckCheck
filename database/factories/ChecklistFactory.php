<?php

use App\Checklist;
use Faker\Generator as Faker;

$factory->define(Checklist::class, function (Faker $faker) {
    return [
        'name' => $faker->words(3, true),
    ];
});
