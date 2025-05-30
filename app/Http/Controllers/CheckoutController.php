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
        
        if (!in_array($paymentMethod, ['qris', 'tunai', 'cash'])) {
            return redirect()->back()->with('error', 'Metode pembayaran tidak valid!');
        }

        // return redirect()->route('cart.finish')->with('success', 'Pembayaran berhasil diproses!');
        return redirect()->route('cart.finish');
    }

    public function processCheckout(Request $request)
    {
        // $this->saveTransaction('cash');
        $paymentMethod = $request->input('payment_method', 'cash');
        $this->saveTransaction($paymentMethod);

        return redirect()->route('cart.success');        
    }

    public function finish()
    {
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
                
                Purchase::create([
                    'user_id' => $userId,
                    'barang_id' => $barang->id,
                    'jumlah' => $item['quantity'],
                    'price' => $item['price'],
                    'total_amount' => $item['price'] * $item['quantity'],
                    'payment_method' => $paymentMethod,
                    'status' => 'pending',
                ]);

                $barang->decrement('jumlah_barang', $item['quantity']);
                $barang->increment('jumlah_terjual', $item['quantity']);
            }

            session([
                'last_cart_items' => $cartItems,
                'last_total_harga' => array_reduce($cartItems, function ($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0),
                'last_order' => (object)[
                    'id' => now()->timestamp,
                ]
            ]);

            DB::commit();
            session()->forget('cart');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function completeCheckout(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $this->saveTransaction($paymentMethod);

        $cartItems = session('last_cart_items', []);
        $totalHarga = session('last_total_harga', 0);
        $order = session('last_order');

        return view('checkout.success', compact('cartItems', 'totalHarga', 'order'));
    }
}