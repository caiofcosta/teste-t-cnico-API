<?php

use Illuminate\Support\Facades\Route;

Route::post('login', [App\Http\Controllers\Api\TokenController::class, 'createToken'])->name('login.post');
Route::get('login', function () {
    return view('errors.default');
})->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', App\Http\Controllers\Api\UserController::class)->except(['edit']);
    Route::resource('activities', App\Http\Controllers\Api\ActivityController::class)->except(['show', 'edit']);
    Route::post('activities/search', [App\Http\Controllers\Api\ActivityController::class, 'search'])->name('activities.search');

});
// Route::get('users', [UserController::class, 'index'])->name('users.list');
// Route::put('users', [UserController::class, 'update'])->name('users.edit');
