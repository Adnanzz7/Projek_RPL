<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin sees all purchases
            $allPurchases = \App\Models\Purchase::with(['user', 'barang.supplier'])->get();
            return view('history.index', compact('allPurchases'));
        } elseif ($user->role === 'supplier') {
            // Supplier sees purchases related to their barangs using whereHas with eager loading
            $supplierPurchases = \App\Models\Purchase::with(['user', 'barang'])
                ->whereHas('barang', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();
            return view('history.index', compact('supplierPurchases'));
        } else {
            // Normal user sees their own purchases
            $purchases = $user->purchases;
            return view('history.index', compact('purchases'));
        }
    }
    
    public function store(Request $request)
    {
        $purchase = new \App\Models\Purchase();
        
        $purchase->user_id = Auth::id();
        $purchase->product_name = $request->product_name;
        $purchase->price = $request->price;
        $purchase->total_amount = $request->price;
        $purchase->status = 'completed';
        $purchase->save();
    
        return redirect()->route('history.index');
    }
    

    public function storeTransaction(Request $request)
    {
        $purchase = new \App\Models\Purchase();
        $purchase->user_id = Auth::id();
        $purchase->product_name = $request->input('product_name');
        $purchase->price = $request->input('price');
        $purchase->total_amount = $request->input('total_amount');
        $purchase->status = 'completed';
        $purchase->save();

        return redirect()->route('history.index');
    }

    public function showSuccessPage()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $purchases = Auth::user()->purchases;
    
        return view('purchase.success', compact('purchases'));
    }
}
