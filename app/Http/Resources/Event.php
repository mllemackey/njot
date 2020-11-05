<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
                'id' => $this->id,
                'admin' => $this->admin,
                'name' => $this->name,
                'title' => $this->name,
                'description' => $this->description,
                'beneficier' => $this->beneficier,
                'date' => $this->date->format('m/d/Y'),
                'startDate' => $this->date->format('Y-m-d H:H:H'),
                'amount' => $this->amount,
                'image' => $this->image,
                'users' => $this->users,
                'privacy' => $this->privacy,
                'presentIdeas' => $this->presentIdeas,
                'can' => $this->permissions(),
                'updated_at' => $this->updated_at->diffForHumans(),
                'self_link' => $this->path(),
                'url' => $this->path()
        ];
    }

    /**
     * Returns the permissions of the resource.
     *
     * @return array
     */
    protected function permissions()
    {
        $user = Auth::user();
        return [
            'view' => $user->can('view', $this->resource),
            'update' => $user->can('update', $this->resource),
            'delete' => $user->can('delete', $this->resource),
        ];
    }
}
