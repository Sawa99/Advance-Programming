<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AwardController;


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

