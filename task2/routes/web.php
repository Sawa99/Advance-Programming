<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\MarkController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/awards',[AwardController::class, 'index'])
    ->name('awards.index');
Route::get('/awards/{id}', [AwardController::class, 'show'])
    ->name('awards.show');
Route::get('/awards/create', [AwardController::class, 'create'])
    ->name('awards.create');
Route::post('/awards', [AwardController::class, 'store'])
    ->name('awards.store');
Route::get('/awards/{id}/edit', [AwardController::class, 'edit'])
    ->name('awards.edit');
Route::put('/awards/{id}', [AwardController::class, 'update'])
    ->name('awards.update');
Route::delete('/awards/{id}', [AwardController::class, 'destroy'])
    ->name('awards.destroy');

Route::get('/modules', [ModuleController::class, 'index'])
    ->name('modules.index');
Route::get('/modules/create', [ModuleController::class, 'create'])
    ->name('modules.create');
Route::post('/modules', [ModuleController::class, 'store'])
    ->name('modules.store');
Route::get('/modules/{id}', [ModuleController::class, 'show'])
    ->name('modules.show');
Route::get('/modules/{id}/edit', [ModuleController::class, 'edit'])
    ->name('modules.edit');
Route::put('/modules/{id}', [ModuleController::class, 'update'])
    ->name('modules.update');
Route::delete('/modules/{id}', [ModuleController::class, 'destroy'])
    ->name('modules.destroy');

Route::get('/assignments', [AssignmentController::class, 'index'])
    ->name('assignments.index');
Route::get('/assignments/create', [AssignmentController::class, 'create'])
    ->name('assignments.create');
Route::post('assignments', [AssignmentController::class, 'store'])
    ->name('assignments.store');
Route::get('/assignments/{id}', [AssignmentController::class, 'show'])
    ->name('assignments.show');
Route::get('/assignments/{id}/edit', [AssignmentController::class, 'edit'])
    ->name('assignments.edit');
Route::put('/assignments/{id}', [AssignmentController::class, 'update'])
    ->name('assignments.update');
Route::delete('/assignments/{id}', [AssignmentController::class, 'destroy'])
    ->name('assignments.destroy');

Route::get('/marks', [MarkController::class, 'index'])
    ->name('marks.index');
Route::get('/marks/create', [MarkController::class, 'create'])
    ->name('marks.create');
Route::post('/marks', [MarkController::class, 'store'])
    ->name('marks.store');
Route::get('/marks/{id}', [MarkController::class, 'show'])
    ->name('marks.show');
Route::get('/marks/{id}/edit', [MarkController::class, 'edit'])
    ->name('marks.edit');
Route::put('/marks/{id}', [MarkController::class, 'update'])
    ->name('marks.update');
Route::delete('/marks/{id}', [MarkController::class, 'destroy'])
    ->name('marks.destroy');
