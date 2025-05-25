<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;

class Purchase extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
    
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $purchases = Auth::user()->purchases;

        return view('history.index', compact('purchases'));
    }

    protected $fillable = [
        'user_id', 'barang_id', 'jumlah', 'price', 'total_amount', 'status'
    ];    
    protected $guarded = [];
}
