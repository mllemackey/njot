<?php

use App\Event;
use App\PresentIdea;
use App\User;
use Illuminate\Database\Seeder;

class PresentIdeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PresentIdea::class, 10)->create();

        foreach(PresentIdea::all() as $presentIdea) {

            $users = User::all()->random(3)->pluck('id');

            foreach ($users as $user){
                $presentIdea->usersVoted()->attach($user);
            }
        }
    }
}
