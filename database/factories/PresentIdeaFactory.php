<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\PresentIdea;
use App\User;
use Faker\Generator as Faker;

$factory->define(PresentIdea::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->isNotEmpty() ? User::all()->random()->id : factory(User::class),
        'event_id' => Event::all()->isNotEmpty() ? Event::all()->random()->id : factory(Event::class),
        'idea' => $faker->text,
        'order_place' => $faker->url,
        'votes' => $faker->numberBetween(1, 20)
    ];
});
