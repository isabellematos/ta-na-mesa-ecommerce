<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Função para EXIBIR a tela com os produtos filtrados
    public function index()
    {
        // Pega o usuário logado
        $userId = Auth::id();

        // Busca apenas os produtos DESTE usuário
        $products = Product::where('user_id', $userId)->get();

        // Retorna a view passando os produtos
        return view('dashboard_lojista', compact('products'));
    }

    public function store(Request $request)
    {
        $product = $request->all();
        $product['user_id'] = Auth::id(); // Garante que o dono é quem está logado
        
        // Salva imagem se vier no request (opcional, ajuste conforme sua lógica de upload)
        if ($request->hasFile('image1')) {
            $path = $request->file('image1')->store('products', 'public');
            $product['image1'] = $path;
        }

        Product::create($product);
        
        return redirect()->route('dashboard')->with('success', 'Produto criado com sucesso!');
    }

    public function update(Product $product, Request $request)
    {
        // Segurança: verifica se o produto é do usuário
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->all();

        if ($request->hasFile('image1')) {
            $path = $request->file('image1')->store('products', 'public');
            $data['image1'] = $path;
        }

        $product->update($data);
        
        return redirect()->route('dashboard')->with('success', 'Produto atualizado!');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $product->delete();
        
        return redirect()->route('dashboard')->with('success', 'Produto excluído!');
    }
}