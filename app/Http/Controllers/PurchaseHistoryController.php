<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Purchase;
use App\Models\Barang;
use App\Models\User;

use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseHistoryExport;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            $allPurchases = \App\Models\Purchase::with(['user', 'barang.supplier'])->get();
            return view('history.index', compact('allPurchases'));
        } elseif ($user->role === 'supplier') {
            $supplierPurchases = \App\Models\Purchase::with(['user', 'barang'])
                ->whereHas('barang', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();
            return view('history.index', compact('supplierPurchases'));
        } else {
            $purchases = $user->purchases;
            return view('history.index', compact('purchases'));
        }
    }

    public function exportPdf()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $purchases = \App\Models\Purchase::with(['user', 'barang.supplier'])->get();
        } elseif ($user->role === 'supplier') {
            $purchases = \App\Models\Purchase::with(['user', 'barang'])
                ->whereHas('barang', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();
        } else {
            $purchases = $user->purchases;
        }

        $pdf = PDF::loadView('history.pdf', compact('purchases', 'user'));
        return $pdf->download('purchase_history.pdf');
    }

    public function exportExcel()
    {
        $user = Auth::user();

        return Excel::download(new PurchaseHistoryExport($user), 'purchase_history.xlsx');
    }
    
    public function store(Request $request)
    {
        $purchase = new \App\Models\Purchase();
        
        $purchase->user_id = Auth::id();
        $purchase->product_name = $request->product_name;
        $purchase->price = $request->price;
        $purchase->total_amount = $request->price;
        $purchase->status = 'pending';
        $purchase->save();
    
        return redirect()->route('barangs.index');
    }
    

    public function storeTransaction(Request $request)
    {
        $purchase = new \App\Models\Purchase();
        $purchase->user_id = Auth::id();
        $purchase->product_name = $request->input('product_name');
        $purchase->price = $request->input('price');
        $purchase->total_amount = $request->input('total_amount');
        $purchase->status = 'pending';
        $purchase->save();

        return redirect()->route('barangs.index');
    }

    public function showSuccessPage()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $purchases = Auth::user()->purchases;
    
        return view('purchase.success', compact('purchases'));
    }

    public function history(Request $request)
    {
        $search = $request->input('search');
        $user = auth()->user();

        if ($user->role === 'user') {
            $purchases = Purchase::where('user_id', $user->id)
                ->whereHas('barang', function ($query) use ($search) {
                    $query->where('nama_barang', 'like', "%{$search}%");
                })
                ->orWhere('status', 'like', "%{$search}%")
                ->latest()->get();

            if ($request->ajax()) {
                return response()->json($purchases);
            }

            return view('history.index', compact('purchases'));
        }

        if ($user->role === 'supplier') {
            $supplierPurchases = Purchase::whereHas('barang', function ($query) use ($user, $search) {
                $query->where('supplier_id', $user->id)
                    ->where('nama_barang', 'like', "%{$search}%");
            })
            ->orWhere('status', 'like', "%{$search}%")
            ->latest()->get();

            if ($request->ajax()) {
                return response()->json($supplierPurchases);
            }

            return view('history.index', compact('supplierPurchases'));
        }

        if ($user->role === 'admin') {
            $allPurchases = Purchase::with(['user', 'barang.supplier'])
                ->whereHas('barang', function ($query) use ($search) {
                    $query->where('nama_barang', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->latest()->get();

            if ($request->ajax()) {
                return response()->json($allPurchases);
            }

            return view('history.index', compact('allPurchases'));
        }
    }
}
