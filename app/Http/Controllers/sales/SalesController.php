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
        session()->forget([
            'total_amount',
            'client_id_edit',
            'sale_id_edit',
            'is_editing',
            'installment_edit',
            'new_installments'
        ]);

        $sales = Sale::with(['client', 'salesItems.product', 'installments'])->get();

        return view('sales', ['sales' => $sales]);
    }

    public function show($id)
    {
        $sale = Sale::with(['client', 'salesItems.product', 'installments'])
            ->find($id);

        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Sale not found.');
        }

        return view('sales_details', ['sale' => $sale]);
    }

    public function store(Request $request)
    {

        try {

            DB::transaction(function () use ($request) {
                $sale = Sale::create([
                    'client_id' => intval($request->input('id_client')),
                    'sale_date' => Carbon::now(),
                    'number_of_installments' => count($request->input('installments')),
                    'total_amount' => floatval($request->input('subtotal')),
                    'seller_id' => session('seller_id')
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
        $sale = Sale::with(['client', 'salesItems.product', 'installments'])
            ->find($id);

        if (!$sale) {
            return redirect()->route('sales.index')->with('error', 'Sale not found.');
        }

        if (!session()->has('is_editing')) {
            session([
                'total_amount' => $sale->total_amount,
                'client_id_edit' => $sale->client_id,
                'sale_id_edit' => $sale->id,
                'is_editing' => false
            ]);
        }

        if (session()->has('installment_edit')) {
            $new_values = session('installment_edit');

            $mappedInstallments = [];
            foreach ($new_values as $installment) {
                $mappedInstallments[] = [
                    'id' => null,
                    'sale_id' => $sale->id,
                    'amount' => $installment['valor'] ?? 0,
                    'due_date' => $installment['data'] ?? now(),
                    'is_paid' => false,
                    'payment_type' => $installment['tipo_pagamento'] ?? 'pending',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $sale->installments = $mappedInstallments;
            session()->put('new_installments', $mappedInstallments);

            session()->forget('installment_edit');
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
                if ($request->has('sale_date')) {
                    $sale->sale_date = $request->sale_date;
                }

                if ($request->has('number_of_installments')) {
                    $sale->number_of_installments = $request->number_of_installments;
                }

                if ($request->has('client_name') || $request->has('client_cpf')) {
                    $client = $sale->client;
                    if ($request->has('client_name')) {
                        $client->name = $request->client_name;
                    }
                    if ($request->has('client_cpf')) {
                        $client->cpf = $request->client_cpf;
                    }
                    $client->save();
                }

                $sale->save();

                $newInstallments = session()->get('new_installments');
                if ($newInstallments) {
                    Installment::where('sale_id', $sale->id)->delete();

                    foreach ($newInstallments as $installment) {
                        Installment::create([
                            'sale_id' => $sale->id,
                            'amount' => floatval($installment['amount']),
                            'payment_type' => $installment['payment_type'],
                            'due_date' => Carbon::parse($installment['due_date']),
                            'is_paid' => false
                        ]);
                    }
                }
            });

            return redirect()->route('sales.index')->with('success', 'Venda atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('error', 'Falha ao atualizar: ' . $e->getMessage());
        }
    }

    public function cancelEdit()
    {
        session()->forget([
            'total_amount',
            'client_id_edit',
            'sale_id_edit',
            'is_editing',
            'installment_edit',
            'new_installments'
        ]);

        return redirect()->route('sales.index')->with('info', 'Edição cancelada.');
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
