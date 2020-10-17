<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\User;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->isNotEmpty() ? User::all()->random()->id : factory(User::class),
        'name' => $faker->name,
        'description' => $faker->text,
        'beneficier' => $faker->name,
        'date' => '10/27/1990',
        'amount' => $faker->numberBetween(1, 50),
        'privacy' => $faker->boolean
    ];
});
