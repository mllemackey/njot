<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'event_id' => $this->id,
                'admin' => $this->user_id,
                'name' => $this->name,
                'description' => $this->description,
                'beneficier' => $this->beneficier,
                'date' => $this->date->format('m/d/Y'),
                'amount' => $this->amount,
                'image' => $this->image,
                'users' => $this->users,
                'privacy' => $this->privacy,
                'presentIdeas' => $this->presentIdeas,
                'updated_at' => $this->updated_at->diffForHumans()
            ],
            'links' => [
                'self' => $this->path()
            ]
        ];
    }
}
