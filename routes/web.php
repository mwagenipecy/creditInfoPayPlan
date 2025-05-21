<?php

use App\Http\Controllers\CreditReportController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MyPackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Site\WelcomeController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback_url', [GoogleController::class, 'handleGoogleCallback']);


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
      Route::get('logs',[PaymentController::class,'paymentLogs'])->name('payment.log');

    });



    ////////////////////////?MY PACKAGE LIST && SECTIONS /////////////////////////

    Route::group(['prefix' => 'package'], function () {

      //  Route::get('plans',[PaymentController::class,'index'])->name('payment.plan');

      Route::get('active',[MyPackageController::class,'activePackage'])->name('package.active');
      Route::get('expired',[MyPackageController::class,'expiredPackage'])->name('expired.package');
      Route::get('usage',[MyPackageController::class,'usageHistory'])->name('usage.history');
  
      });





    // usermanagement 

    Route::group(['prefix' => 'user'], function () {
     Route::get('list',[UserController::class,'index'])->name('user.list');

    });



    // usage management 
    Route::group(['prefix' => 'usage'], function () {
        Route::get('dashboard',[UsageController::class,'index'])->name('usage.dashboard');
        
       });


       /// credit report section  credit.report
       Route::group(['prefix' => 'credit'], function () {
        Route::get('report',[CreditReportController::class,'index'])->name('credit.report');
        
       });



       /// profile settings 

       Route::group(['prefix'=>'settings'],function(){

         Route::get('/',[UserProfileController::class,'userSettings'])->name('user.setting');
         Route::get('profile',[UserProfileController::class,'userProfile'])->name('user.profile');

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