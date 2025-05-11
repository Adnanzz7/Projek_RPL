<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('barang')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $barangs = Barang::all();

        return view('wishlist.index', compact('wishlists', 'barangs'));
    }

    public function add($barangId)
    {
        $userId = auth()->id();

        // Check if the item is already in the wishlist
        $existingWishlistItem = Wishlist::where('user_id', $userId)
                                        ->where('barang_id', $barangId)
                                        ->first();

        if ($existingWishlistItem) {
            return redirect()->back()->with('error', 'Item sudah ada di wishlist!');
        }

        // If not in wishlist, add the item
        Wishlist::create([
            'user_id' => $userId,
            'barang_id' => $barangId
        ]);

        return redirect()->back()->with('success', 'Item berhasil ditambahkan ke wishlist!');
    }

    public function store(Request $request)
    {
        $request->validate(['barang_id' => 'required|exists:barang,id']);

        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'barang_id' => $request->product_id
        ]);

        return back()->with('success', 'Produk ditambahkan ke wishlist.');
    }

    public function moveToCart($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $barang = $wishlist->barang;

        // Ambil keranjang dari session
        $cart = session()->get('cart', []);

        // Cek stok barang
        if ($barang->jumlah_barang < 1) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        // Tambahkan barang ke keranjang atau update jika sudah ada
        if (isset($cart[$barang->id])) {
            $cart[$barang->id]['quantity'] += 1;
        } else {
            $cart[$barang->id] = [
                'name' => $barang->nama_barang,
                'price' => $barang->harga_barang,
                'quantity' => 1,
                'foto_barang' => $barang->foto_barang,
                'initial_stock' => $barang->jumlah_barang,
            ];
        }

        // Kurangi jumlah barang di database
        $barang->jumlah_barang -= 1;
        $barang->save();

        // Simpan keranjang ke session
        session()->put('cart', $cart);
        session()->put('cart.count', array_sum(array_column($cart, 'quantity')));

        // Hapus dari wishlist
        $wishlist->delete();

        $quantity = $cart[$barang->id]['quantity'] ?? 1;
        return redirect()->route('barangs.index')->with('success', "Item berhasil dipindahkan ke keranjang. Jumlah: $quantity");
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $wishlist->delete();

        return back()->with('success', 'Produk dihapus dari wishlist.');
    }
}