<?php

namespace App\Models\product;

use App\Models\sales_item\Sales_item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\Product\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function salesItems()
    {
        return $this->hasMany(Sales_item::class, 'product_id');
    }
}