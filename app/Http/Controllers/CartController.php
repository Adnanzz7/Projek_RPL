<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\Order;
use Mpdf;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $cart = session()->get('cart', []);    
        $id = $request->id;
        $quantity = $request->quantity;
        $barang = Barang::findOrFail($id);
    
        if ($barang->jumlah_barang < $quantity) {
            return redirect()->back()->with('error', 'Jumlah barang yang Anda pilih melebihi stok yang tersedia!');
        }
    
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } 
        else {
            $cart[$id] = [
                'name' => $barang->nama_barang,
                'price' => $barang->harga_barang,
                'quantity' => $quantity,
                'foto_barang' => $barang->foto_barang,
                'initial_stock' => $barang->jumlah_barang,
            ];
        }
    
        $barang->jumlah_barang -= $quantity;
        $barang->save();
        session()->put('cart', $cart);
    
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        session()->put('cart.count', $totalQuantity);
    
        $quantity = $cart[$id]['quantity'] ?? 1;
        $quantity = $cart[$id]['quantity'] ?? 1;
        return redirect()->route('barangs.index')->with('success', "Barang berhasil ditambahkan ke keranjang. Jumlah: $quantity");
    }
    
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $total = 0;
    
        foreach ($cartItems as $id => $item) {
            if (is_array($item) && isset($item['name'], $item['price'], $item['quantity'])) {
                $barang = Barang::find($id);
                $item['stok'] = $barang ? $barang->jumlah_barang : 0;
                $total += $item['price'] * $item['quantity'];
                $cartItems[$id] = $item;
            } 
            else {
                unset($cartItems[$id]);
            }
        }
    
        session()->put('cart', $cartItems);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function edit($id)
    {
        $cartItems = session()->get('cart', []);
        
        if (!isset($cartItems[$id])) {
            return redirect()->route('cart.index')->with('warning', 'Barang tidak ditemukan di keranjang.');
        }

        return view('cart.edit', [
            'id' => $id,
            'item' => $cartItems[$id],
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:256',
        ]);

        $cartItems = session()->get('cart', []);

        if (!isset($cartItems[$id])) {
            return redirect()->route('cart.index')->with('warning', 'Barang tidak ditemukan di keranjang.');
        }

        $cartItems[$id]['quantity'] = $request->input('quantity');
        $cartItems[$id]['description'] = $request->input('description');
        session()->put('cart', $cartItems);

        return redirect()->route('cart.index')->with('success', 'Barang berhasil diperbarui.');
    }
    
    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:barangs,id',
        ]);
    
        $cart = session()->get('cart', []);
        $id = $request->id;

        if (isset($cart[$id])) {
            $barang = Barang::find($id);

            if ($barang) {
                $barang->jumlah_barang += $cart[$id]['quantity'];
                $barang->save();
            }
    
            unset($cart[$id]);
            session()->put('cart', $cart);
            session()->put('cart.count', count($cart));
    
            return redirect()->route('cart.index')->with('success', 'Barang berhasil dihapus dari keranjang!');
        }
    
        return redirect()->route('cart.index')->with('error', 'Barang tidak ditemukan di keranjang!');
    }
    
    public function checkout()
    {
        $cartItems = session()->get('cart', []); 
        $totalHarga = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
    
        $errorMessages = [];
    
        foreach ($cartItems as $id => $item) {
            $barang = Barang::find($id);
    
            if (!$barang) {
                return redirect()->route('cart.index')->with('error', 'Barang dengan ID ' . $id . ' tidak ditemukan.');
            }
    
            if (isset($item['initial_stock']) && $barang->jumlah_barang < ($item['initial_stock'] - $item['quantity'])) {
                $errorMessages[] = 'Stok barang ' . $item['name'] . ' hanya tersisa ' . $barang->jumlah_barang . '. Anda akan membeli dengan jumlah yang tersedia.';
            }            
        }
    
        if (!empty($errorMessages)) {
            return redirect()->route('cart.checkout')->with('error', implode(' ', $errorMessages));
        }
    
        $order = [
            'id' => uniqid(),
        ];
    
        return view('cart.checkout', compact('cartItems', 'totalHarga', 'order'));
    }

    public function showAddForm($id = null)
    {
        if (!$id) {
            return redirect()->route('barangs.index')->with('error', 'Barang tidak ditemukan.');
        }
    
        $barang = Barang::findOrFail($id);
        return view('cart.add', compact('barang'));
    }    

    public function addFromForm(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $barang = Barang::findOrFail($request->id);

        if ($barang->jumlah_barang < $request->quantity) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$barang->id])) {
            $totalQuantity = $cart[$barang->id]['quantity'] + $request->quantity;

            if ($totalQuantity > $barang->jumlah_barang) {
                return redirect()->back()->with('error', 'Stok barang tidak mencukupi untuk jumlah yang diinginkan.');
            }

            $cart[$barang->id]['quantity'] = $totalQuantity;
        } 
        else {
            $cart[$barang->id] = [
                'id' => $barang->id,
                'name' => $barang->nama_barang,
                'price' => $barang->harga_barang,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'foto_barang' => $barang->foto_barang,
                'initial_stock' => $barang->jumlah_barang,
            ];
        }

        $barang->jumlah_barang -= $request->quantity;
        $barang->save();
        session()->put('cart', $cart);
        session()->put('cart.count', array_sum(array_column($cart, 'quantity')));

        return redirect()->route('cart.index')->with('success', 'Barang berhasil ditambahkan ke keranjang!');

        $barang->jumlah_barang -= $request->quantity;
        $barang->save();
        session()->put('cart', $cart);
        session()->put('cart.count', array_sum(array_column($cart, 'quantity')));
    
        return redirect()->route('cart.index')->with('success', 'Barang berhasil ditambahkan ke keranjang!');
    }    

    public function completeCheckout(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $cartItems = session('cart', []);

        if (!$paymentMethod || !in_array($paymentMethod, ['cash', 'qris'])) {
            return redirect()->back()->with('error', 'Metode pembayaran tidak valid.');
        }

        $status = $paymentMethod === 'cash' ? 'pending' : 'completed';

        $order = Order::create([
            'user_id' => auth()->id(),
            'payment_method' => $paymentMethod,
            'status' => $status,
        ]);

        foreach ($cartItems as $id => $item) {
            $barang = Barang::find($id);
            if ($barang && $barang->jumlah_barang >= $item['quantity']) {
                $barang->jumlah_barang -= $item['quantity'];
                $barang->save();

                Purchase::create([
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                    'barang_id' => $barang->id,
                    'jumlah' => $item['quantity'],
                    'price' => $item['price'],
                    'total_amount' => $item['price'] * $item['quantity'],
                    'status' => $status,
                ]);
            } else {
                return redirect()->route('cart.success.get', ['orderId' => $order->id])
                    ->with('error', 'Stok tidak mencukupi untuk barang ' . $item['name']);
            }
        }

        session()->forget('cart');

    return redirect()->route('cart.success.get', ['orderId' => $order->id])
        ->with('success', 'Pembelian berhasil!');
    }
    
    public function pembayaranBerhasil()
    {
        $cartItems = session()->get('cart', []);
        $totalHarga = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
    
        $order = [
            'id' => uniqid(),
            'user_id' => Auth::id(),
            'total' => $totalHarga,
            'items' => $cartItems,
        ];
    
        session()->put('order', $order);
        session()->forget('cart');
    
        return view('cart.success', compact('order', 'cartItems', 'totalHarga'));
    }
    
    public function cancel()
    {
        $cart = session()->get('cart');
    
        foreach ($cart as $id => $details) {
            $barang = Barang::find($id);
    
            if ($barang) {
                $barang->jumlah_barang += $details['quantity'];
                $barang->save();
            }
        }
    
        session()->forget('cart');
    
        return redirect()->route('barangs.index')->with('status', 'Pesanan dibatalkan, stok barang telah diperbarui!');
    }
    public function selesai()
    {
        $cartItems = session()->get('cart', []);
        
        foreach ($cartItems as $id => $item) {
            $barang = Barang::find($id);
            
            if (!$barang) {
                return redirect()->route('cart.index')->with('error', 'Barang dengan ID ' . $id . ' tidak ditemukan.');
            }
    
            if ($barang->jumlah_barang < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', 'Stok tidak mencukupi untuk barang ' . $item['name']);
            }
    
            $barang->jumlah_barang -= $item['quantity'];
            $barang->save();
        }
    
        session()->forget('cart');
    
        return redirect()->route('barangs.index')->with('status', 'Pembelian berhasil');
    }
    
    public function downloadPdf()
    {
        $order = session()->get('order');
        $cartItems = $order['items'] ?? [];
        $totalHarga = $order['total'] ?? 0;    
        $user = Auth::user();
        $mpdf = new \Mpdf\Mpdf();
        $html = view('cart.pdf', compact('cartItems', 'totalHarga', 'user', 'order'))->render();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('bukti-pembayaran.pdf', 'D');
    }

    public function clear()
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $id => $item) {
            $barang = Barang::find($id);
            if ($barang) {
                $barang->jumlah_barang += $item['quantity'];
                $barang->save();
            }
        }
    
        session()->forget('cart');
    
        return redirect()->back()->with('success', 'Keranjang telah dibersihkan, dan stok barang telah dikembalikan!');
    }

public function success(Request $request, $orderId)
{
    $order = Order::find($orderId);
    if (!$order) {
        return redirect()->route('cart.index')->with('error', 'Pesanan tidak ditemukan.');
    }

    $cartItems = Purchase::where('order_id', $orderId)->get();

    $totalHarga = $cartItems->sum(function ($item) {
        return $item->price * $item->jumlah;
    });

    return view('cart.success', compact('order', 'cartItems', 'totalHarga'));
}
}    