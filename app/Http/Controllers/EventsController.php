<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Resources\Event as EventResource;
use App\Notifications\EventFunded;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class EventsController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Event::class);

        return EventResource::collection(Event::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Event::class);
        $data = $this->validateData();

        $data['user_id'] = request()->user()->id;

        if ($request->has('image')) {
            $data['image'] = $request->image->store('/uploads/images');
        }

        $event = $request->user()->myEvents()->create($data);

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        return new EventResource($event);
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $data = request()->all();

        if ($request->has('image')) {
            $data['image'] = request()->image->store('/uploads/images');
        }

        $event->update($data);

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function userEvents()
    {
        $this->authorize('viewAny', Event::class);
        $events = request()->user()->events;

        return EventResource::collection($events);
    }

    public function addUsers(Event $event)
    {
        $this->authorize('update', $event);

        $data = collect(request()->all())->pluck('id');

        foreach ($data as $user) {
            $event->users()->attach($user);
        }

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function deleteUsers(Event $event)
    {
        $this->authorize('update', $event);

        $data = collect(request()->all())->pluck('id');

        foreach ($data as $user) {
            $event->users()->detach($user);
        }

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function updateFunding(Event $event)
    {
        $this->authorize('update', $event);

        $data = request()->all();
        $currentFund = $event->users()->find($data['userId'])->pivot->funded;

        $event->users()->updateExistingPivot($data['userId'], ['funded' => !$currentFund]);

        if($event->isFunded()){
            Notification::send($event->users, new EventFunded($event));
        }

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Event $event)
    {

        $this->authorize('delete', $event);
        $event->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }



    public function validateData()
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'max:255',
            'beneficier' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'image' => '',
        ]);
    }
}
