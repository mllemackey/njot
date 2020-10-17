<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'event' => $this->event,
            'user' => $this->user,
            'idea' => $this->idea,
            'order_place' => $this->order_place,
            'voted' => count($this->usersVoted),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
