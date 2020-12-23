<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'image', 'bank_account', 'provider_id', 'notification_preference'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNotificationPreferenceAttribute($value){
        return explode(',', $value);
    }

    public function getImageAttribute($value){
        if (!$value)
            return $value;
        if(strpos($value, 'facebook'))
            return $value;

        return url('/') . '/' . $value;
    }

    /*** Relationships ***/

    public function events(){
        return $this->belongsToMany(Event::class)->withPivot('funded');
    }

    public function myEvents(){
        return $this->hasMany(Event::class);
    }

    public function myPresentIdeas(){
        return $this->hasMany(PresentIdea::class);
    }

    public function votedPresentIdeas(){
        return $this->belongsToMany(PresentIdea::class,'user_voted');
    }

}
