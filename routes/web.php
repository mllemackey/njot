<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

//Route::get('/logout-manual', function (){
//    Auth::logout();
//    request()->session()->invalidate();
//    redirect('/');
//});

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/{any}', 'AppController@index')->where('any', '.*')->name('home');
