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
    
        return view('admin.purchases-management', compact('purchases'));
    }      

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,cancelled',
        ]);

        $purchase = Purchase::findOrFail($id);
        $purchase->status = $request->status;
        $purchase->save();

        return back()->with('success', 'Purchase status updated successfully.');
    }
}