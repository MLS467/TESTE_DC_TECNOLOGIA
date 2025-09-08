<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use App\Models\client\Client;
use App\Models\product\Product;

class NewSalesController extends Controller
{
    public function __invoke()
    {
        $client = Client::all();
        $product = Product::all();

        return view('new_sale', [
            'clients' => $client,
            'products' => $product
        ]);
    }
}