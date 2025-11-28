<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard2', function () {
    return view('dashboard_lojista_copy');
})->middleware(['auth', 'verified'])->name('dashboard2');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/order/{order}', [ProfileController::class, 'cancelOrder'])->name('order.cancel');

    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit'); // Se tiver tela de edição
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});

Route::get('/admin/tag', [TagController::class, 'index']);

Route::get('/initial', function (\Illuminate\Http\Request $request) {
    // Inicia a consulta de produtos
    $query = \App\Models\Product::query();
    
    // 1. Filtro de Texto (Nome do produto)
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    
    // 2. Filtro de Múltiplas Categorias (O novo!)
    if ($request->filled('categories')) {
        // "whereHas" entra na tabela relacionada (Category) e filtra pelo nome
        $query->whereHas('Category', function($q) use ($request) {
            $q->whereIn('name', $request->categories);
        });
    }
    
    // Pega os produtos filtrados
    $products = $query->get();

    return view('auth.initial_page', ['products' => $products]); 
})->name('initial');

Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{cartItem}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cartItem}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/save-address', [\App\Http\Controllers\CartController::class, 'saveAddress'])->name('cart.saveAddress');

Route::get('/checkout/personal-info', [\App\Http\Controllers\CheckoutController::class, 'showPersonalInfo'])->name('checkout.personalInfo');
Route::post('/checkout/personal-info', [\App\Http\Controllers\CheckoutController::class, 'savePersonalInfo'])->name('checkout.savePersonalInfo');
Route::get('/checkout/payment', [\App\Http\Controllers\CheckoutController::class, 'showPayment'])->name('checkout.payment');
Route::post('/checkout/finalize', [\App\Http\Controllers\CheckoutController::class, 'finalizePurchase'])->name('checkout.finalize');

require __DIR__.'/auth.php';
