<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use App\Models\sale\Sale;

class printController extends Controller
{
    public function __invoke()
    {

        $sales = Sale::with(['client', 'salesItems.product', 'installments'])->get();


        return view('print_sales', [
            'sale' => $sales
        ]);
    }
}