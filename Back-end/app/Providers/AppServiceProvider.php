<?php

namespace App\Providers;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        
    }

public function boot()
{
    view()->composer('*', function ($view) {
        if (Auth::check()) {
            $count = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $count = CartItem::where('session_id', session()->getId())->sum('quantity');
        }

        $view->with('cartCount', $count);
    });
}
}




