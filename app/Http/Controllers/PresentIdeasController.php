<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Resources\PresentIdea as PresentIdeaResource;
use App\PresentIdea;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function GuzzleHttp\Promise\all;

class PresentIdeasController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', PresentIdea::class);

        return PresentIdeaResource::collection(PresentIdea::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', PresentIdea::class);

//        dd(request()->user()->id);

        $data = request()->all();
        $data['user_id'] = request()->user()->id;

        $event = Event::find($request->event_id);
        $presentIdea = $event->presentIdeas()->create($data);

        return (new PresentIdeaResource($presentIdea))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PresentIdea $presentIdea)
    {
        $this->authorize('view', $presentIdea);

        return new PresentIdeaResource($presentIdea);
    }

    public function update(Request $request, PresentIdea $presentIdea)
    {
        $this->authorize('update', $presentIdea);

        $data = request()->all();

        $presentIdea->update($data);

        return (new PresentIdeaResource($presentIdea))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function vote(PresentIdea $presentIdea)
    {
        $this->authorize('vote', $presentIdea);

//        dd(request()->all());
//        $data = request()->call();

        $user = request()->user();
        $presentIdea = PresentIdea::find(request()->present_idea_id);
//        dd($presentIdea);
//        $data = collect(request()->all())->pluck('id');

        $presentIdea->usersVoted()->toggle($user);

        return PresentIdeaResource::collection(PresentIdea::all())
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function deleteVotes(PresentIdea $presentIdea)
    {
        $this->authorize('update', $presentIdea);

        $data = collect(request()->all())->pluck('id');

        foreach ($data as $user) {
            $presentIdea->usersVoted()->detach($user);
        }

        return (new PresentIdeaResource($presentIdea))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
