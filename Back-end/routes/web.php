<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard_lojista');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard2', function () {
    return view('dashboard_lojista_copy');
})->middleware(['auth', 'verified'])->name('dashboard2');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/product', [ProductController::class, 'store'])->name('product.store');


});

Route::get('/admin/tag', [TagController::class, 'index']);

Route::get('/initial', function () {
    return view('auth.initial_page');
})->name('initial');

require __DIR__.'/auth.php';
