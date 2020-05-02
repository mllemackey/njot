<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/logout-manual', function (){
    Auth::logout();
    request()->session()->invalidate();
});

Route::get('/{any}', 'AppController@index')->where('any', '.*');
