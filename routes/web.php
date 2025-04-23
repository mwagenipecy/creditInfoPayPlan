<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('test',function(){

    return view('demo');
});


Route::get('test1',function(){

    return view('login');
});


Route::get('test2',function(){

    return view('register');
});


Route::get('test3',function(){

    return view('layout');
});