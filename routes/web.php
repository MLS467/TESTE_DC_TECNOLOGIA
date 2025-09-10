<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\installment\InstallmentController;
use App\Http\Controllers\product\ProductController;
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

    Route::post('/edit-installments', [InstallmentController::class, 'saveInstallmentsInLocalStorage'])->name('installments_save');

    Route::get('/edit-installments', [InstallmentController::class, 'editInstallments'])->name('edit_installments');

    Route::get('/sales/cancel-edit', [SalesController::class, 'cancelEdit'])->name('sales.cancel_edit');
});


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.get');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
