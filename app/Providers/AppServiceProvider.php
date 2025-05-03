<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use App\Models\Barang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menangani event Logout
        Event::listen(Logout::class, function ($event) {
            $cart = session()->get('cart', []);
    
            // Mengembalikan stok barang
            foreach ($cart as $id => $item) {
                $quantity = is_array($item) ? ($item['quantity'] ?? 0) : $item;
    
                if (!is_numeric($quantity) || $quantity <= 0) {
                    continue; // Abaikan data yang tidak valid
                }
    
                $barang = Barang::find($id);
                if ($barang) {
                    $barang->jumlah_barang += (int) $quantity;
                    $barang->save();
                }
            }
    
            // Hapus session keranjang
            session()->forget('cart');
        });
    }
    
}
