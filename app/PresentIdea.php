<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresentIdea extends Model
{
    protected $guarded = [];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function usersVoted(){
        return $this->belongsToMany(User::class,'user_voted');
    }
}
