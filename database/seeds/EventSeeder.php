<?php

use App\Event;
use App\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Event::class, 10)->create();

        foreach(Event::all() as $event) {

            $users = User::all()->except($event->user_id)->random(3)->pluck('id');

            foreach ($users as $user){
                $event->users()->attach($user);
            }
        }
    }
}
