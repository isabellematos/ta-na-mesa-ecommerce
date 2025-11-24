<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Se for lojista, redireciona para o dashboard
        if ($user->tipo === 'sim') {
            $products = \App\Models\Product::where('user_id', $user->id)->get();
            $categories = \App\Models\Category::all();
            
            return view('dashboard_lojista', [
                'user' => $user,
                'products' => $products,
                'categories' => $categories,
            ]);
        }
        
        // Se for comprador, mostra o perfil de comprador com pedidos
        $orders = \App\Models\Order::where('user_id', $user->id)
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('profile.edit', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'imagemPerfil' => 'nullable|image|max:2048',
        ]);

        $user = $request->user();
        
        $user->name = $validated['name'];
        if ($request->filled('email')) {
            $user->email = $validated['email'];
        }
        $user->telefone = $validated['telefone'] ?? null;

        if ($request->hasFile('imagemPerfil')) {
            \Log::info('Upload de foto detectado', ['file' => $request->file('imagemPerfil')->getClientOriginalName()]);
            $path = $request->file('imagemPerfil')->store('profile-photos', 'public');
            \Log::info('Foto salva', ['path' => $path]);
            $user->imagemPerfil = $path;
        } else {
            \Log::info('Nenhum arquivo de foto detectado');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        
        // Refresh the user in the session to update the profile photo
        $request->user()->refresh();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    /**
     * Cancel an order.
     */
    public function cancelOrder(\App\Models\Order $order): RedirectResponse
    {
        // Verificar se o pedido pertence ao usuário logado
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para cancelar este pedido.');
        }

        // Verificar se o pedido pode ser cancelado (apenas pedidos pendentes)
        if ($order->status !== 'pending') {
            return Redirect::route('profile.edit')->with('error', 'Este pedido não pode ser cancelado.');
        }

        // Deletar o pedido (os itens serão deletados automaticamente por cascade)
        $order->delete();

        return Redirect::route('profile.edit')->with('success', 'Pedido cancelado com sucesso!');
    }
}
