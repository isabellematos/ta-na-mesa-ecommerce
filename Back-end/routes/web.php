<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetController;

function notLojista() {
    if (Auth::check() && Auth::user()->tipo === 'sim') {
        session()->flash('show_lojista_modal', true);
        return redirect()->route('initial');
    }
    return null;
}

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/reset-password', [PasswordResetController::class, 'showForm'])->name('password');
    Route::post('/reset-password', [PasswordResetController::class, 'simpleReset'])->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');
    Route::get('/dashboard2', function () {
        return view('dashboard_lojista_copy');
    })->name('dashboard2');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/order/{order}', [ProfileController::class, 'cancelOrder'])->name('order.cancel');

    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
});

Route::get('/admin/tag', [TagController::class, 'index']);

Route::get('/initial', function (Request $request) {
    $query = \App\Models\Product::query();

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('categories')) {
        $query->whereHas('Category', function ($q) use ($request) {
            $q->whereIn('name', $request->categories);
        });
    }

    $products = $query->get();
    $categories = collect([
        (object)['id' => 1, 'name' => 'Vestimentas'],
        (object)['id' => 2, 'name' => 'Acessórios'],
        (object)['id' => 3, 'name' => 'Livros'],
        (object)['id' => 4, 'name' => 'Dados'],
        (object)['id' => 5, 'name' => 'Brinquedos'],
        (object)['id' => 6, 'name' => 'Outro'],
    ]);

    return view('auth.initial_page', [ 
        'products' => $products,
        'categories' => $categories
    ]);
})->name('initial');

Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');



Route::get('/cart', function () {
    $block = notLojista(); 
    if ($block) return $block; 
    return app(\App\Http\Controllers\CartController::class)->index();
})->name('cart.index');


Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/save-address', [CartController::class, 'saveAddress'])->name('cart.saveAddress');


Route::get('/checkout/personal-info', function () {
    $block = notLojista(); 
    if ($block) return $block;
    return app(\App\Http\Controllers\CheckoutController::class)->showPersonalInfo();
})->name('checkout.personalInfo');


Route::post('/checkout/personal-info', function (Request $request) {
    $block = notLojista();
    if ($block) return $block;
    
    return app(\App\Http\Controllers\CheckoutController::class)->savePersonalInfo($request);
})->name('checkout.savePersonalInfo');


Route::get('/checkout/payment', function () {
    $block = notLojista(); 
    if ($block) return $block;
    return app(\App\Http\Controllers\CheckoutController::class)->showPayment();
})->name('checkout.payment');


Route::post('/checkout/finalize', function (Request $request) {
    $block = notLojista();
    if ($block) return $block;
    
    return app(\App\Http\Controllers\CheckoutController::class)->finalizePurchase($request);
})->name('checkout.finalize');
