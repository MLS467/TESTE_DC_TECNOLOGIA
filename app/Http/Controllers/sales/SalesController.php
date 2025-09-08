<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use App\Models\installment\Installment;
use App\Models\sale\Sale;
use App\Models\sales_item\Sales_item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['client', 'salesItems.product', 'installments'])->get();

        return view('sales', ['sales' => $sales]);
    }

    public function store(Request $request)
    {

        try {

            DB::transaction(function () use ($request) {
                $sale = Sale::create([
                    'client_id' => intval($request->input('id_client')),
                    'sale_date' => Carbon::now(),
                    'number_of_installments' => count($request->input('installments')),
                    'total_amount' => floatval($request->input('subtotal'))
                ]);

                foreach ($request->input('installments') as $installment) {
                    Installment::create([
                        'sale_id' => $sale->id,
                        'amount' => floatval($installment['valor']),
                        'payment_type' => $installment['tipo_pagamento'],
                        'due_date' => Carbon::parse($installment['data']),
                        'is_paid' => false
                    ]);
                }

                foreach ($request->input('products') as $product) {

                    Sales_item::create([
                        'sales_id' => intval($sale->id),
                        'product_id' => intval($product['id']),
                        'quantity' => intval($product['quantity']),
                        'unit_price' => floatval($product['unit_value']),
                        'total_price' => floatval($product['unit_value'] * $product['quantity'])
                    ]);
                }
            });

            return redirect()->route('sales.index');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('error', 'Transaction failed: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $sale = Sale::with(['client', 'salesItems.product', 'installments'])->find($id);

        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Sale not found.');
        }

        return view('edit_sales', ['sale' => $sale]);
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Sale not found.');
        }

        try {
            DB::transaction(function () use ($request, $sale) {
                $sale->update([
                    'client_id' => intval($request->input('client_id')),
                    'sale_date' => $request->input('sale_date'),
                    'number_of_installments' => intval($request->input('number_of_installments')),
                    'total_amount' => floatval($request->input('total_amount'))
                ]);

                $quantityUpdated = false;

                if ($request->has('items')) {
                    foreach ($request->input('items') as $itemData) {
                        $salesItem = Sales_item::find($itemData['id']);
                        if ($salesItem) {
                            if (isset($itemData['quantity']) && $salesItem->quantity != intval($itemData['quantity'])) {
                                $quantityUpdated = true;
                            }

                            $salesItem->update([
                                'quantity' => intval($itemData['quantity']),
                                'unit_price' => floatval($itemData['unit_price']),
                                'total_price' => floatval($itemData['unit_price'] * $itemData['quantity'])
                            ]);
                        }
                    }
                }

                $newTotal = $sale->salesItems()->sum(DB::raw('quantity * unit_price'));
                $sale->update(['total_amount' => $newTotal]);

                if ($quantityUpdated) {
                    $sale->installments()->delete();
                    $totalQuantity = $sale->salesItems()->sum('quantity');

                    if ($totalQuantity > 0) {
                        $installmentValue = $newTotal / $totalQuantity;

                        for ($i = 1; $i <= $totalQuantity; $i++) {
                            Installment::create([
                                'sale_id' => $sale->id,
                                'amount' => round($installmentValue, 2),
                                'payment_type' => 'pending',
                                'due_date' => Carbon::now()->addMonths($i - 1),
                                'is_paid' => false
                            ]);
                        }

                        $sale->update(['number_of_installments' => $totalQuantity]);
                    }
                }
            });

            return redirect()->route('sales.index')->with('success', 'Venda atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('error', 'Falha ao atualizar: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Sale not found.');
        }

        try {
            DB::transaction(function () use ($sale) {
                $sale->installments()->delete();
                $sale->salesItems()->delete();
                $sale->delete();
            });

            return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('error', 'Failed to delete sale: ' . $e->getMessage());
        }
    }
}