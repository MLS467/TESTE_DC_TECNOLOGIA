<?php

namespace App\Models\installment;

use App\Models\sale\Sale;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'sale_id',
        'amount',
        'due_date',
        'is_paid',
        'payment_type'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}