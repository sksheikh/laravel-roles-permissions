<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permission Routes
    Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [App\Http\Controllers\PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [App\Http\Controllers\PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}', [App\Http\Controllers\PermissionController::class, 'show'])->name('permissions.show');
    Route::get('/permissions/{id}/edit', [App\Http\Controllers\PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{id}', [App\Http\Controllers\PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{id}', [App\Http\Controllers\PermissionController::class, 'destroy'])->name('permissions.destroy');
});

require __DIR__.'/auth.php';
