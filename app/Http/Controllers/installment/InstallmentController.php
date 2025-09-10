<?php

namespace App\Http\Controllers\installment;

use App\Http\Controllers\Controller;
use App\Models\client\Client;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{

    public function editInstallments()
    {

        $amount_total = session('total_amount');

        return view('edit_installments', compact('amount_total'));
    }


    public function saveInstallmentsInLocalStorage(Request $request)
    {
        $client_id = session()->get('client_id_edit');
        $sale_id = session()->get('sale_id_edit');

        session()->forget(['total_amount', 'client_id_edit', 'sale_id_edit']);

        session([
            'installment_edit' => $request->input('installments'),
            'client_id_edit' => $client_id
        ]);

        session()->forget('is_editing');
        return redirect()->route('sales.edit', ['sale' => $sale_id]);
    }

    public function previewInstallments()
    {
        $installments = session('installments', []);
        $total_amount = session('subtotal', 0);
        $client_id = session('id_client');
        $products = session('products', []);

        $client = null;
        if ($client_id) {
            $client = Client::find($client_id);
        }

        if (empty($installments)) {
            return redirect()->route('new-sale')->with('error', 'Nenhuma parcela encontrada.');
        }

        return view('preview_installments', compact('installments', 'total_amount', 'client', 'products'));
    }

    public function savePreviewData(Request $request)
    {
        session([
            'installments' => $request->input('installments'),
            'subtotal' => $request->input('subtotal'),
            'id_client' => $request->input('id_client'),
            'products' => $request->input('products')
        ]);

        return response()->json(['success' => true]);
    }
}
