<?php

namespace App\Models\sales_item;

use App\Models\product\Product;
use App\Models\sale\Sale;
use Illuminate\Database\Eloquent\Model;

class Sales_item extends Model
{
    protected $fillable = [
        'sales_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sales_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}