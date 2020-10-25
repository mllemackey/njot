<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {

    Route::get('/events', 'EventsController@index');
    Route::get('/me/events', 'EventsController@userEvents');
    Route::post('/events', 'EventsController@store');

    Route::get('/events/{event}', 'EventsController@show');
    Route::put('/events/{event}', 'EventsController@update');
    Route::post('/events/{event}/users', 'EventsController@addUsers');
    Route::put('/events/{event}/users', 'EventsController@deleteUsers');
    Route::delete('/events/{event}', 'EventsController@destroy');

    Route::get('/users',  'UsersController@index');
    Route::get('/users/{user}',  'UsersController@show');
    Route::put('/users/{user}',  'UsersController@update');

    Route::get('/present-ideas',  'PresentIdeasController@index');
    Route::get('/present-ideas/{presentIdea}',  'PresentIdeasController@show');
    Route::post('/present-ideas', 'PresentIdeasController@store');
    Route::put('/present-ideas/{presentIdea}',  'PresentIdeasController@update');
    Route::delete('/present-ideas/{presentIdea}',  'PresentIdeasController@destroy');
    Route::put('/present-ideas/{presentIdea}/votes', 'PresentIdeasController@vote');

});
