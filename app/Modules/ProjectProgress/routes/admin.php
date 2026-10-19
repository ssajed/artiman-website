<?php

use App\Modules\ProjectProgress\Http\Controllers\Admin\ProjectProgressController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'admin'])
    ->prefix('admin/project-progress')
    ->name('admin.project-progress.')
    ->group(function () {
        Route::get('/', [ProjectProgressController::class, 'index'])->name('index');
        Route::get('/phases/create', [ProjectProgressController::class, 'createPhase'])->name('phases.create');
        Route::post('/phases', [ProjectProgressController::class, 'storePhase'])->name('phases.store');
        Route::get('/phases/{phase}/edit', [ProjectProgressController::class, 'editPhase'])->name('phases.edit');
        Route::put('/phases/{phase}', [ProjectProgressController::class, 'updatePhase'])->name('phases.update');
        Route::get('/activities/create', [ProjectProgressController::class, 'create'])->name('activities.create');
        Route::post('/activities', [ProjectProgressController::class, 'store'])->name('activities.store');
        Route::get('/activities/{activity}/edit', [ProjectProgressController::class, 'edit'])->name('activities.edit');
        Route::put('/activities/{activity}', [ProjectProgressController::class, 'update'])->name('activities.update');
    });
