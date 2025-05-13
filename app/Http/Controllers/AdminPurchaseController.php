<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['barang.supplier', 'user']);
    
        if ($request->filled('buyer')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->buyer . '%');
            });
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $purchases = $query->get();

        if ($request->ajax()) {
            $data = $purchases->map(function ($purchase) {
                return [
                    'id' => $purchase->id,
                    'buyer' => $purchase->user->name ?? 'N/A',
                    'product' => $purchase->barang->nama_barang ?? 'N/A',
                    'supplier' => $purchase->barang->supplier->name ?? 'N/A',
                    'price' => number_format($purchase->price, 2, ',', '.'),
                    'quantity' => $purchase->jumlah,
                    'total' => number_format($purchase->total_amount, 2, ',', '.'),
                    'status' => $purchase->status,
                    'status_label' => ucfirst($purchase->status),
                    'created_at' => $purchase->created_at->format('d-m-Y'),
                ];
            });
            return response()->json($data);
        }
    
        return view('admin.purchases-management', compact('purchases'));
    }      

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,pending,cancelled',
        ]);

        $purchase = Purchase::findOrFail($id);
        $purchase->status = $request->status;
        $purchase->save();

        return back()->with('success', 'Purchase status updated successfully.');
    }
}