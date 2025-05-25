<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kategori_barang',
        'harga_barang',
        'harga_pokok',
        'jumlah_barang',
        'jumlah_barang_awal',
        'jumlah_terjual',
        'foto_barang',
        'keterangan_barang',
        'user_id'
    ];
    
    // public function getHargaBarangAttribute($value)
    // {
    //     $hargaDenganRetribusi = $value + 1000;
    
    //     $hargaDenganJasaWeb = $hargaDenganRetribusi + 500;
    
    //     return $hargaDenganJasaWeb;
    // }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function colors()
    {
        return $this->hasMany(Color::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
