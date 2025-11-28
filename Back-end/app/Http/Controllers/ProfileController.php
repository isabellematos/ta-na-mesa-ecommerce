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
use App\Models\Order;
use App\Models\Category;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request) // Removi o ": View" para aceitar Redirect
    {
        $user = $request->user();

        // ==========================================================
        // 1. O GUARDA DE TRÂNSITO (DESVIO DO LOJISTA)
        // ==========================================================
        // Se o usuário for Lojista, manda ele para o Dashboard dele!
        if ($user->tipo === 'sim') {
            return redirect()->route('dashboard');
        }

        // ==========================================================
        // 2. LÓGICA DO COMPRADOR (SE NÃO FOR LOJISTA)
        // ==========================================================
        
        // Busca pedidos
        $ordersQuery = Order::where('user_id', $user->id)
                            ->with('items.product.Category');

        // Filtros
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
        $categories = Category::all(); 

        // Retorna a tela do Comprador
        return view('profile.edit', [
            'user' => $user,
            'orders' => $orders,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the user's profile information.
     */
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

        // Se for lojista, volta pro dashboard depois de salvar. Se for comprador, fica no perfil.
        if ($user->tipo === 'sim') {
             return redirect()->route('dashboard')->with('success', 'Perfil atualizado!');
        }

        return Redirect::route('profile.edit')->with('success', 'Perfil atualizado!');
    }

    /**
     * Delete the user's account.
     */
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