<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Product::where('user_id', $userId);

        // --- LÓGICA DE FILTRO ---
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

        return view('dashboard_lojista', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
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
}