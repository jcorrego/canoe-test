<?php

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

// For simplicity, the API routes are created without any authentication.
Route::apiResource('funds', 'App\Http\Controllers\FundController');
Route::get('duplicates', 'App\Http\Controllers\FundController@duplicates');
