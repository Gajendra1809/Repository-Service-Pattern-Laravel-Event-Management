<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login',[UserController::class,'login'])->name('login');

Route::resource('/users',UserController::class);

Route::middleware('auth:api')->group(function () {

    Route::resource('/events',EventController::class);
    Route::get('/users/{id}/events',[EventController::class,'eventsByUser']);

    Route::resource('/tickets',TicketController::class);
    Route::get('/events/{id}/tickets',[TicketController::class,'ticketsByEvent']);
    Route::get('/users/{id}/tickets',[TicketController::class,'ticketsByUser']);

});
