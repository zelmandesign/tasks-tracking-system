<?php

use App\Http\Controllers\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// report user info
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// create bearer token for registered user
Route::post('/tokens/create', [ApiAuthController::class, 'createToken']);

// new user registration
Route::post('/user/register', [ApiAuthController::class, 'registerUser']);
