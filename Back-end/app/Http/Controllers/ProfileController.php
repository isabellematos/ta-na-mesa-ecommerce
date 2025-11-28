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
    // Adicione lá em cima: use Illuminate\Support\Facades\Storage;

public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    $data = $request->validated();

    // Lógica da Imagem de Perfil
    if ($request->hasFile('imagemPerfil')) {
        // Se o usuário já tinha foto antes, apaga a velha para não encher o servidor
        if ($user->imagemPerfil) {
            Storage::disk('public')->delete($user->imagemPerfil);
        }

        // Salva a nova na pasta 'perfil'
        $path = $request->file('imagemPerfil')->store('perfil', 'public');
        $user->imagemPerfil = $path;
    }

    $user->fill($data);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('dashboard')->with('status', 'profile-updated');
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
