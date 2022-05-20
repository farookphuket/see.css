<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\RegisterController as Register;
use App\Http\Controllers\LoginController as Login;

use App\Http\Controllers\Member\ProfileController as Profile;
use App\Http\Controllers\WhatupController as Whatup;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/* ===================== Register Route START ===============================*/
// get your friend
Route::get('/your-friends',[Register::class,'getYourFriends'])
    ->name("getYourFriends");

// new register
Route::post('/register',[Register::class,'store']);


// login 
Route::post('/login',[Login::class,'store']);

// check user passport
Route::get('/user-has-passport',[Login::class,'checkUserPassport'])
    ->name('checkUserPassport');

/* ===================== Register Route END ================================*/


// whatup 
Route::get('/whatup',[Whatup::class,"index"]);


Route::prefix("member")->name("member.")->middleware('auth:sanctum')
                                        ->group(function(){
    Route::resource('/profile',Profile::class);

});
 


/* ===================== Admin Route ======================================== */
Route::prefix("admin")->name("admin.")->middleware('auth:sanctum')
                                        ->group(function(){
    Route::resource('/whatup',Whatup::class);

});



