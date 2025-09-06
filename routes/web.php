<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    try {
        DB::connection()->getPdo();
        echo "conexão realizada com sucesso";
    } catch (\Throwable $e) {
        echo "Erro na conexão: " . $e->getMessage();
    }
});