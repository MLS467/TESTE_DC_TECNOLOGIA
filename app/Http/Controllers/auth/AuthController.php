<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Models\seller\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(loginRequest $request)
    {
        $credentials = $request->validated();

        $seller = Seller::where('email', $credentials['email'])->first();

        if ($seller && Hash::check($credentials['password'], $seller->password)) {
            Session::put('seller_id', $seller->id);
            Session::put('seller_name', $seller->name);
            $request->session()->regenerate();

            return redirect()->route('new-sale');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function logout()
    {
        Session::forget('seller_id');
        Session::forget('seller_name');

        return redirect()->route('login.get');
    }
}