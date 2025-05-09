<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        // Data contoh, bisa diganti dengan data dari database nanti
        $wishlistItems = [
            ['nama' => 'Produk A', 'harga' => 150000],
            ['nama' => 'Produk B', 'harga' => 200000],
        ];

        return view('wishlist.index', compact('wishlistItems'));
    }
}
