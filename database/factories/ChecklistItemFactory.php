<?php

use App\Checklist;
use App\ChecklistItem;
use Faker\Generator as Faker;

$factory->define(ChecklistItem::class, function (Faker $faker) {
    return [
        'name' => $faker->words(3, true),
        'checklist_id' => function () {
            return factory(Checklist::class)->create()->id;
        },
    ];
});
