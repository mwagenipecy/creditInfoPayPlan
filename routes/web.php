<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Site\WelcomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard.dashboard');
    })->name('dashboard');



    Route::group(['prefix' => 'document'], function () {
        Route::get('list',[DocumentController::class,'index'])->name('document.list');

        //register company 
        Route::get('company',[DocumentController::class,'addCompany'])->name('add.company');

        // add document
        Route::get('/add/{id}',[DocumentController::class,'addDocument'])->name('add.document');
    });




    Route::group(['prefix' => 'payment'], function () {

      Route::get('plans',[PaymentController::class,'index'])->name('payment.plan');

    });
    


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



///  welcome page 
Route::get('',[WelcomeController::class,'index'])->name('home');

// pricing page 
Route::get('/price',[WelcomeController::class,'showPricing'])->name('price.list');