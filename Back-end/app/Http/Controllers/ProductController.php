<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $categories = collect([
            (object)['id' => 1, 'name' => 'Vestimentas'],
            (object)['id' => 2, 'name' => 'Acessórios'],
            (object)['id' => 3, 'name' => 'Livros'],
            (object)['id' => 4, 'name' => 'Dados'],
            (object)['id' => 5, 'name' => 'Brinquedos'],
            (object)['id' => 6, 'name' => 'Outro'],
        ]);

        if ($user->tipo === 'sim') {
            
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

            return view('dashboard_lojista', compact('products', 'categories'));
        }

        else {
            $ordersQuery = Order::where('user_id', $user->id)
                                ->with('items.product.Category');

            if ($request->filled('date')) {
                $ordersQuery->whereDate('created_at', $request->date);
            }
            if ($request->filled('category_id') && $request->category_id != 'all') {
                $categoryId = $request->category_id;
                $ordersQuery->whereHas('items.product', function($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });
            }
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $ordersQuery->whereHas('items.product', function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            }

            $orders = $ordersQuery->orderBy('created_at', 'desc')->get();

            return view('dashboard', compact('orders', 'categories'));
        }
    }

    
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        Product::create($data);
        return redirect()->route('dashboard')->with('success', 'Anúncio criado!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->fill($request->all()); 
        $product->save();
        return redirect()->back()->with('success', 'Produto atualizado!');
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
        
        $categories = collect([
            (object)['id' => 1, 'name' => 'Vestimentas'],
            (object)['id' => 2, 'name' => 'Acessórios'],
            (object)['id' => 3, 'name' => 'Livros'],
            (object)['id' => 4, 'name' => 'Dados'],
            (object)['id' => 5, 'name' => 'Brinquedos'],
            (object)['id' => 6, 'name' => 'Outro'],
        ]);
        
        return view('pages.item', compact('product', 'categories'));  
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
