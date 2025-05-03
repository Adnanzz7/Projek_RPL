<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\Barang;

class RestoreCartStock
{
    public function handle(Logout $event)
    {
        $cart = session()->get('cart', []);

        // Mengembalikan stok barang
        foreach ($cart as $id => $quantity) {
            $barang = Barang::find($id);
            if ($barang) {
                $barang->jumlah_barang += $quantity;
                $barang->save();
            }
        }

        // Hapus session keranjang
        session()->forget('cart');
    }
}
