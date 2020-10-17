<?php

namespace App\Http\Controllers;

use App\Http\Resources\PresentIdea as PresentIdeaResource;
use App\PresentIdea;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $data = request()->all();

        $presentIdea = $request->user()->presentIdeas()->create($data);

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

    public function addVotes(PresentIdea $presentIdea)
    {
        $this->authorize('update', $presentIdea);

        $data = collect(request()->all())->pluck('id');

        foreach ($data as $user) {
            $presentIdea->usersVoted()->attach($user);
        }

        return (new PresentIdeaResource($presentIdea))
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
