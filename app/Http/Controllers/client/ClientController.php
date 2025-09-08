<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\client\Client;
use Illuminate\Http\Request;

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

    public function create()
    {
        return view('addClient');
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('client_show', ['client' => $client]);
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('editClient', ['client' => $client]);
    }

    public function store(ClientStoreRequest $request)
    {
        $validated = $request->validated();

        $client = new Client();
        $client->name = $validated['name'];
        $client->cpf = $validated['cpf'];
        $client->save();

        return redirect()->route('client.index');
    }


    public function update(ClientUpdateRequest $request, $id)
    {
        $validated = $request->validated();


        $client = Client::findOrFail($id);
        $client->name = $validated['name'];
        $client->cpf = $validated['cpf'];
        $client->save();

        return redirect()->route('client.index');
    }

    public function destroy($client_new)
    {

        $client_new = Client::findOrFail($client_new);
        $client_new->delete();
        return redirect()->route('client.index');
    }
}