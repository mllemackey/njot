<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return User
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, User $user)
    {
//        $this->authorize('update', $user);

        $data = request()->all();
//dd(request()->image);
        if($request->has('image')) {
            $data['image'] = request()->image->store('/uploads/images');
        }

        $user->update($data);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
