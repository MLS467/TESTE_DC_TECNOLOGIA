<?php

namespace App\Models\client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\Client\ClientFactory> */
    use HasFactory;


    public function sales()
    {
        return $this->hasMany(\App\Models\sale\Sale::class, 'client_id');
    }
}