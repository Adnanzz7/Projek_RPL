<?php

namespace App\Exports;

use App\Models\Purchase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

class PurchaseHistoryExport implements FromCollection, WithHeadings
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->user->role === 'admin') {
            $purchases = Purchase::with(['user', 'barang.supplier'])->get();
        } elseif ($this->user->role === 'supplier') {
            $purchases = Purchase::with(['user', 'barang'])
                ->whereHas('barang', function ($query) {
                    $query->where('user_id', $this->user->id);
                })
                ->get();
        } else {
            $purchases = $this->user->purchases;
        }

        return $purchases->map(function ($purchase) {
            return [
                'Order ID' => $purchase->id,
                'Buyer' => $purchase->user->name ?? 'N/A',
                'Product' => $purchase->barang->nama_barang ?? 'N/A',
                'Supplier' => $purchase->barang->supplier->name ?? 'N/A',
                'Price' => $purchase->price,
                'Quantity' => $purchase->jumlah,
                'Total' => $purchase->total_amount,
                'Status' => $purchase->status,
                'Date' => $purchase->created_at->format('d M Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Buyer',
            'Product',
            'Supplier',
            'Price',
            'Quantity',
            'Total',
            'Status',
            'Date',
        ];
    }
}
