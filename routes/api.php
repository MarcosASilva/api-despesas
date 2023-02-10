<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:sanctum'], function () {  
    Route::resource('despesas', DespesaController::class);
    Route::resource('users', UserController::class);

    
});

    Route::post('/logout', [AuthenticationController::class, 'logout']);

    Route::post('/login', [AuthenticationController::class, 'login']);

