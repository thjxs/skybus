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

$factory->afterCreating(App\Thread::class, function ($thread, $faker) {
    $thread->content()->save(['body' => $faker->realText(100, 200)]);
});
