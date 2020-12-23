<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\User;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->isNotEmpty() ? User::all()->random()->id : factory(User::class),
        'name' => ucfirst($faker->word . " " . $faker->word),
        'description' => $faker->text,
        'beneficier' => $faker->name,
        'date' => $faker->dateTimeBetween('-1 month'),
        'amount' => $faker->numberBetween(1, 50),
        'privacy' => $faker->boolean
    ];
});
