<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function index()
    {
        $products = Product::latest()->get();
        $total = $products->sum(fn($p) => $p->quantity * $p->price);


        return view('products.index', [
            'products' =>$products,
            'total' => $total
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($request->all());


        $jsonPath = storage_path('app/products.json');
        $data = Product::all();
        file_put_contents($jsonPath, $data->toJson(JSON_PRETTY_PRINT));

        return response()->json(['success' => true, 'product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return response()->json(['success' => true, 'product' => $product]);
    }

public function destroy(Product $product)
{
    $product->delete();

    $jsonPath = storage_path('app/products.json');
    $data = Product::all();
    file_put_contents($jsonPath, $data->toJson(JSON_PRETTY_PRINT));

    return response()->json(['success' => true]);
}

}
