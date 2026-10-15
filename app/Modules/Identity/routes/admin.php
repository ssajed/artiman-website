<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Identity\Http\Controllers\Admin\DashboardController;
use App\Modules\Identity\Http\Controllers\Auth\LogoutController;

Route::middleware(['web', 'auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/logout', LogoutController::class)->name('logout');
    });