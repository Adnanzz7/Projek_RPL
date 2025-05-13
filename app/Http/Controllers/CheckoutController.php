<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\transaksi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Method untuk memproses pembayaran
    public function processPayment(Request $request)
    {
        // Mendapatkan metode pembayaran yang dipilih
        $paymentMethod = $request->input('payment_method');
        
        // Lakukan logika pemrosesan pembayaran sesuai metode yang dipilih
        switch ($paymentMethod) {
            case 'qris':
                // Proses pembayaran dengan QRIS
                break;
            case 'tunai':
                // Proses pembayaran dengan Tunai
                break;
            case 'cash':
                // Proses pembayaran dengan Cash
                break;
            default:
                // Tangani jika tidak ada metode yang dipilih
                return redirect()->back()->with('error', 'Pilih metode pembayaran!');
        }

        return redirect()->route('cart.finish')->with('success', 'Pembayaran berhasil diproses!');
    }

    public function processCheckout(Request $request)
    {
        return redirect()->route('cart.finish');
    }

    public function success()
    {
        return view('cart.finish');
    }

    public function store(Request $request)
    {
        $cartItems = session('cart', []);

        foreach ($cartItems as $item) {
            $barang = Barang::findOrFail($item['id']);
            $jumlah = $item['jumlah'];

            Purchase::create([
                'user_id' => auth()->id(),
                'barang_id' => $barang->id,
                'jumlah' => $jumlah,
                'price' => $barang->harga_barang,
                'total_amount' => $barang->harga_barang * $jumlah,
                'status' => 'completed',
            ]);

            // Update jumlah_terjual dan stok_tersisa
            $barang->jumlah_terjual += $jumlah;
            $barang->stok_tersisa -= $jumlah;
            $barang->save();
        }

        session()->forget('cart'); // Hapus cart setelah checkout

        return redirect()->route('history.index')->with('success', 'Pembelian berhasil!');
    }
}