<?php

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

Route::resource('/films', App\Http\Controllers\FilmController::class);
Route::resource('/actors', App\Http\Controllers\ActorController::class);
Route::resource('/genres', App\Http\Controllers\GenreController::class);




