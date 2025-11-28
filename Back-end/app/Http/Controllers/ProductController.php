<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order; // <--- NÃO ESQUEÇA DISSO AQUI!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // === DECISÃO: É LOJISTA? ===
        if ($user->tipo === 'sim') {
            // Lógica do Lojista (BUSCA PRODUTOS PARA VENDER)
            $query = Product::where('user_id', $user->id);

            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('category_id') && $request->category_id != 'all') {
                $query->where('category_id', $request->category_id);
            }
            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }

            $products = $query->get();
            $categories = Category::all();

            // MANDA PARA A TELA DE LOJISTA
            return view('dashboard_lojista', compact('products', 'categories'));
        }

        // === DECISÃO: É COMPRADOR? ===
        else {
            // Lógica do Comprador (BUSCA PEDIDOS REALIZADOS)
            
            // Verifica se a classe Order foi importada lá em cima
            // Se der erro, troque 'Order::' por '\App\Models\Order::'
            $ordersQuery = \App\Models\Order::where('user_id', $user->id)
                                ->with('items.product.Category');

            // Filtro 1: Data da Compra
            if ($request->filled('date')) {
                $ordersQuery->whereDate('created_at', $request->date);
            }

            // Filtro 2: Categoria dos Itens Comprados
            if ($request->filled('categories')) {
                $categoriasSelecionadas = $request->categories;
                $ordersQuery->whereHas('items.product.Category', function($q) use ($categoriasSelecionadas) {
                    $q->whereIn('name', $categoriasSelecionadas);
                });
            }

            $orders = $ordersQuery->orderBy('created_at', 'desc')->get();

            // MANDA PARA A TELA DE COMPRADOR (dashboard.blade.php)
            // É aqui que estava o problema! Antes ele mandava para 'dashboard_lojista'
            return view('dashboard', compact('orders'));
        }
    }

    // ... O RESTO DAS SUAS FUNÇÕES (store, update, destroy...) CONTINUA IGUAL ...
    public function store(Request $request)
    {
        // ... (seu código de store continua aqui)
        $data = $request->all();
        $data['user_id'] = Auth::id();
        
        if ($request->hasFile('image1')) {
            $data['image1'] = $request->file('image1')->store('products', 'public');
        }

        Product::create($data);
        
        return redirect()->route('dashboard')->with('success', 'Anúncio criado!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->units = $request->units;
        $product->category_id = $request->category_id;
        $product->description = $request->description;

        if ($request->hasFile('image1')) {
            $path = $request->file('image1')->store('products', 'public');
            $product->image1 = $path;
        }

        $product->save();

        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) { abort(403); }
        $product->delete();
        return redirect()->route('dashboard');
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) { abort(403); }
        $categories = Category::all();
        return view('pages.item', compact('product', 'categories'));  
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}