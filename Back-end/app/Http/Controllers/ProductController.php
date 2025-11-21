<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request){
        $product = $request->all();
        $product['user_id']=$request->user()->id;
        Product::create($product);
        return redirect('/dashboard');
    }

    public function update(Product $product,Request $resquest){
    Product::update($resquest->all());
    return redirect('/dashboard');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect('/dashboard');
    }
}
