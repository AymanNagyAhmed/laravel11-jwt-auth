<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::group(['prefix' => 'v1'], function () {
    Route::apiResources(['users' => UserController::class]);

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {

    Route::get('me', [AuthController::class, 'profile']);
    Route::get('refresh', [AuthController::class, 'refreshToken']);
    Route::get('logout', [AuthController::class, 'logout']);
});
