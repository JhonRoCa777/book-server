<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

/************************ PUBLIC ************************/
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

/************************ PRIVATE ************************/
Route::middleware('jwt.cookie')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
    });

    //************************ ADMIN ************************/
    Route::middleware('admin.auth')->group(function () {
        //BOOKS
        Route::prefix('books')->group(function () {
            Route::get('/', [BookController::class, 'index']);
        });
    });

    /************************ USER ************************/
    //BOOKS
    Route::prefix('books')->group(function () {
        Route::post('/', [BookController::class, 'show']);
    });
});
