<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\product\Product;


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
}