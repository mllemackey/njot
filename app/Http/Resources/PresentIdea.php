<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PresentIdea extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event' => $this->event,
            'user' => $this->user,
            'idea' => $this->idea,
            'order_place' => $this->order_place,
            'usersVoted' => $this->usersVoted,
            'iVoted' => $this->userVoted($this->usersVoted),
            'voted' => count($this->usersVoted),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }

    public function userVoted(Collection $users)
    {
//        dump(Auth::id());

        foreach ($users as $user){
//                dump($user->id);
            if($user->id == Auth::id()) {
                return true;
            }
        }
        return false;
    }
}
