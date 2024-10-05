<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BussniesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Bussnies\ServiceController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
Route::post('login',[AuthController::class,'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('admin')->group(function () {
Route::get('users',[UserController::class,'index']);
Route::post('adduser', [UserController::class,'store']);
Route::delete('users/{id}', [UserController::class, 'destroy']);

});

//Bussnies Crud
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/businesses', [BussniesController::class, 'create']);
    Route::post('Bussniess/{id}',[BussniesController::class,'update']);
    Route::delete('Bussniess/{id}',[BussniesController::class,'delete']);

});
Route::get('Bussniess',[BussniesController::class,'index']);
Route::get('Bussniess/{id}',[BussniesController::class,'show']);
#Service Crud 
Route::middleware('auth:sanctum')->group(function (){
Route::get('Service',[ServiceController::class,'index']);
Route::get('Service/{id}',[ServiceController::class,'show']);
Route::post('Service',[ServiceController::class,'store']);
Route::post('Service/{id}',[ServiceController::class,'update']);
Route::delete('Service/{id}',[ServiceController::class,'delete']);

}
);
#Booking Crud
Route::middleware('auth:sanctum')->group(function (){
 Route::get('/bookings', [BookingController::class, 'index']);
 Route::get('/bookings/{id}', [BookingController::class, 'show']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::post('/bookings/{id}', [BookingController::class, 'update']);
Route::delete('/bookings/{id}',[BookingController::class,'delete']);
});

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/review', [ReviewController::class, 'index']);
    Route::get('/review/{id}', [ReviewController::class, 'reviews_show']);
   Route::post('/review', [ReviewController::class, 'store']);
   Route::post('/review/{id}', [ReviewController::class, 'update']);
   Route::delete('/review/{id}',[ReviewController::class,'delete']);
   });
   







