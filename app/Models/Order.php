<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
    
    public function product()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    protected $fillable = [
        'user_id', // tambahkan ini
        'total_amount', // atribut lain yang bisa diisi secara mass
        // tambahkan atribut lain jika perlu
    ];
}

