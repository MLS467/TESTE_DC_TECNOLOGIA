<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\client\Client;

class ClientController extends Controller
{
    public function index()
    {
        $data_value = Client::all();
        $columns =  ['id', 'nome', 'cpf'];
        $keys =  ['id', 'name', 'cpf'];


        return view(
            'client_list',
            [
                'data_value' => $data_value,
                'columns' => $columns,
                'keys_value' => $keys,
                'title' => 'Cliente'
            ]
        );
    }
}