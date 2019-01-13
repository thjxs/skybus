<?php

use Faker\Generator as Faker;

$factory->define(App\Thread::class, function (Faker $faker) {
    $node_ids = [1,2,3];
    return [
        'title' => $faker->realText($faker->numberBetween(10,20)),
        'published_at' => now(),
        'node_id' => $faker->randomElement($node_ids)
    ];
});
