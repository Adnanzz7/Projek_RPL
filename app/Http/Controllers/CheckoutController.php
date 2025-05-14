<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Purchase; // Pastikan model Purchase diimport
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function processPayment(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        
        // Validasi metode pembayaran
        if (!in_array($paymentMethod, ['qris', 'tunai', 'cash'])) {
            return redirect()->back()->with('error', 'Metode pembayaran tidak valid!');
        }

        // Removed saving transaction here to save on finish click
        // return redirect()->route('cart.finish')->with('success', 'Pembayaran berhasil diproses!');
        return redirect()->route('cart.finish');
    }

    public function processCheckout(Request $request)
    {
        // Removed saving transaction here to save on finish click
        // $this->saveTransaction('cash'); // Default payment method
        
        return redirect()->route('cart.finish');
    }

    public function finish()
    {
        // Redirect ke barangs.index setelah selesai
        return redirect()->route('barangs.index')->with('success', 'Pembelian berhasil!');
    }

    protected function saveTransaction($paymentMethod)
    {
        $cartItems = session('cart', []);
        $userId = Auth::id();

        DB::beginTransaction();
        try {
            foreach ($cartItems as $id => $item) {
                $barang = Barang::findOrFail($id);
                
                // Simpan ke tabel purchases
                Purchase::create([
                    'user_id' => $userId,
                    'barang_id' => $barang->id,
                    'jumlah' => $item['quantity'],
                    'price' => $item['price'],
                    'total_amount' => $item['price'] * $item['quantity'],
                    'payment_method' => $paymentMethod,
                    'status' => 'completed',
                ]);

                // Update stok barang
                $barang->decrement('jumlah_barang', $item['quantity']);
                $barang->increment('jumlah_terjual', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart'); // Bersihkan keranjang
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}