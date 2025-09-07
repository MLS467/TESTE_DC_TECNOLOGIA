<?php

use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\order\Order;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\order\OrderController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::resources([
    'product' => ProductController::class,
    'client' => ClientController::class,
    'order' => OrderController::class,
]);


Route::get('/test_connection', function () {
    try {
        DB::connection()->getPdo();
        echo "conexão realizada com sucesso";
    } catch (\Throwable $e) {
        echo "Erro na conexão: " . $e->getMessage();
    }
});