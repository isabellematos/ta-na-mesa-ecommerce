<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Order;    // <--- Importante
use App\Models\Category; // <--- Importante

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        // --- BUSCA PEDIDOS ---
        $ordersQuery = Order::where('user_id', $user->id)
                            ->with('items.product.Category');

        if ($request->filled('date')) {
            $ordersQuery->whereDate('created_at', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $ordersQuery->whereHas('items.product', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category_id') && $request->category_id != '') {
             $categoryId = $request->category_id;
             $ordersQuery->whereHas('items.product', function($q) use ($categoryId) {
                 $q->where('category_id', $categoryId);
             });
        }

        $orders = $ordersQuery->orderBy('created_at', 'desc')->get();
        
        // --- BUSCA CATEGORIAS (Para o filtro) ---
        $categories = Category::all();

        // --- RETORNA TUDO ---
        return view('profile.edit', [
            'user' => $user,
            'orders' => $orders,
            'categories' => $categories, // <--- ESSENCIAL PARA O FILTRO FUNCIONAR
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('imagemPerfil')) {
            if ($user->imagemPerfil) {
                Storage::disk('public')->delete($user->imagemPerfil);
            }
            $path = $request->file('imagemPerfil')->store('perfil', 'public');
            $user->imagemPerfil = $path;
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}