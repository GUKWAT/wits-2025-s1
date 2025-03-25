<?php

use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\StaticController::class, 'home'])->name('welcome');
Route::get('/about', [\App\Http\Controllers\StaticController::class, 'about'])->name('about');
Route::get('/contact', [\App\Http\Controllers\StaticController::class, 'contact'])->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('users', UserController::class);

//Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

Route::middleware('auth')->group(function () {
    Route::resource('users', \App\Http\Controllers\UserController::class)->except(['index', 'show', 'edit', 'update', 'create', 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

Route::resource('packages', PackageController::class)
    ->only(['index', 'edit', 'update', 'destroy', 'show']);
Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');
Route::get('/packages/search', [PackageController::class, 'search'])->name('packages.search');
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/packages/edit', [PackageController::class, 'edit'])->name('packages.edit');

require __DIR__.'/auth.php';
