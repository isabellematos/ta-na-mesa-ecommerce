<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showPersonalInfo()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para continuar.');
        }

        $user = Auth::user();
        return view('checkout.personal-info', compact('user'));
    }

    public function savePersonalInfo(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para continuar.');
        }

        $request->validate([
            'cpf' => 'required|string|size:14',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string',
            'cep'=> 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->update([
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'telefone' => $request->telefone,
            'cep'=> $request->cep,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'receber_emails' => $request->has('receber_emails'),
        ]);

        return redirect()->route('checkout.payment')->with('success', 'Informações salvas com sucesso!');
    }

    public function showPayment()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para continuar.');
        }

        $user = Auth::user();
        $cartItems = \App\Models\CartItem::where('user_id', Auth::id())->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.payment', compact('user', 'cartItems', 'subtotal'));
    }

    public function finalizePurchase(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para continuar.');
        }

        $cartItems = \App\Models\CartItem::where('user_id', Auth::id())->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingCost = $subtotal >= 150 ? 0 : 10;
        $total = $subtotal + $shippingCost;

        $order = \App\Models\Order::create([
            'user_id' => Auth::id(),
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'payment_method' => $request->input('payment_method', 'pix'),
            'shipping_method' => $request->input('envio', 'correios'),
            'status' => 'pending',
        ]);

        foreach ($cartItems as $cartItem) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }

        \App\Models\CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('initial')->with('purchase_success', true);
    }
}
