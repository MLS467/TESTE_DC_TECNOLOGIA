<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\sales\NewSalesController;
use App\Http\Controllers\sales\printController;
use App\Http\Controllers\sales\SalesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['authenticate'])->group(function () {

    Route::resources([
        'product' => ProductController::class,
        'client' => ClientController::class,
        'sales' => SalesController::class,
    ]);

    Route::get('/print', printController::class)->name('sales.print');

    Route::get('/new-sale', NewSalesController::class)->name('new-sale');

    Route::view('/payment', 'payment')->name('payment');
});


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.get');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');