<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- CORREÇÃO AQUI ---
// Antes estava chamando a view direto. Agora chama o Controller.
Route::get('/dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Essa rota dashboard2 parece ser de teste, mantive igual mas cuidado com ela
Route::get('/dashboard2', function () {
    return view('dashboard_lojista_copy');
})->middleware(['auth', 'verified'])->name('dashboard2');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de Produtos
    // Adicionei as rotas de update/destroy aqui também para seus botões funcionarem
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit'); // Se tiver tela de edição
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});

Route::get('/admin/tag', [TagController::class, 'index']);

Route::get('/initial', function () {
    return view('auth.initial_page');
})->name('initial');

require __DIR__.'/auth.php';
