<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\product\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

        $data_value = Product::all();
        $columns = ['ID', 'Nome', 'Preço'];
        $keys_value = ['id', 'name', 'price'];


        return view('product_list', [
            'data_value' => $data_value,
            'columns' => $columns,
            'title' => 'Lista de Produtos',
            'keys_value' => $keys_value
        ]);
    }


    public function create()
    {
        return view('addProduct');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product_show', ['product' => $product]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('editProduct', ['product' => $product]);
    }


    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->save();

        return redirect()->route('product.index');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->save();

        return redirect()->route('product.index');
    }

    public function destroy($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
        return redirect()->route('product.index');
    }
}