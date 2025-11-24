<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        
        if ($quantity > $product->units) {
            return redirect()->back()->with('error', 'Quantidade indisponível em estoque.');
        }

        $cartItem = $this->findOrCreateCartItem($product->id);
        
        if ($cartItem->quantity + $quantity > $product->units) {
            return redirect()->back()->with('error', 'Quantidade total excede o estoque disponível.');
        }

        $cartItem->quantity += $quantity;
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $quantity = $request->input('quantity', 1);
        
        if ($quantity > $cartItem->product->units) {
            return response()->json(['error' => 'Quantidade indisponível'], 400);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return response()->json(['success' => true]);
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Item removido do carrinho.');
    }

    private function getCartItems()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())->with('product')->get();
        } else {
            $sessionId = session()->getId();
            return CartItem::where('session_id', $sessionId)->with('product')->get();
        }
    }

    private function findOrCreateCartItem($productId)
    {
        if (Auth::check()) {
            return CartItem::firstOrCreate(
                ['user_id' => Auth::id(), 'product_id' => $productId],
                ['quantity' => 0]
            );
        } else {
            $sessionId = session()->getId();
            return CartItem::firstOrCreate(
                ['session_id' => $sessionId, 'product_id' => $productId],
                ['quantity' => 0]
            );
        }
    }

    public function saveAddress(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $request->validate([
            'cep' => 'required|string|size:8',
            'logradouro' => 'required|string',
            'numero' => 'nullable|string',
            'complemento' => 'nullable|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string|size:2',
        ]);

        $user = Auth::user();
        $user->update([
            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
        ]);

        return response()->json(['success' => true, 'message' => 'Endereço salvo com sucesso!']);
    }
}
