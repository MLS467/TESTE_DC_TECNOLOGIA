<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\client\Client;
use App\Models\product\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $client = Client::all();
        $product = Product::all();

        return view('new_sale', [
            'clients' => $client,
            'products' => $product
        ]);
    }
}