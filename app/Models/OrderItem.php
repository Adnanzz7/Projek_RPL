<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_name', 'price', 'quantity', 'total_price'];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
