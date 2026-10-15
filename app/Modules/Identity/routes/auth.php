<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Identity\Http\Controllers\Auth\LoginController;

Route::middleware('web')->group(function () {
    // Display login form (only for guests)
    Route::get('/login', [LoginController::class, 'show'])
        ->name('login')
        ->middleware('guest');
    
    // Process login (only for guests, with rate limiting)
    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.post')
        ->middleware(['guest', 'throttle:5,1']);
});