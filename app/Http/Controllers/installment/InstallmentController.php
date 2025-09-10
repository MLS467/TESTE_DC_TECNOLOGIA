<?php

namespace App\Http\Controllers\installment;

use App\Http\Controllers\Controller;
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


        return redirect()->route('sales.edit', ['sale' => $sale_id]);
    }
}
