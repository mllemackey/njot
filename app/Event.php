<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    protected $dates = ['date'];

    public function path(){
        return '/events/' . $this->id;
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::parse($date);
    }

    public function users(){
        return $this->belongsToMany(User::class)
            ->withPivot('funded');
    }

    public function admin(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function presentIdeas(){
        return $this->hasMany(PresentIdea::class);
    }

    public function isFunded(){
        foreach($this->users as $user){
            if($user->pivot->funded === 0){
                return false;
            }
        }
        return true;
    }

}
