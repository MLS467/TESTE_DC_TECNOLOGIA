<?php

namespace App\Models\sale;

use App\Models\client\Client;
use App\Models\installment\Installment;
use App\Models\sales_item\Sales_item;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'seller_id',
        'sale_date',
        'number_of_installments',
        'client_id',
        'total_amount'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class, 'sale_id');
    }

    public function salesItems()
    {
        return $this->hasMany(Sales_item::class, 'sales_id');
    }
}