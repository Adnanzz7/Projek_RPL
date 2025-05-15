<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase History PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>Purchase History</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                @if($user->role === 'admin')
                    <th>Buyer</th>
                @endif
                <th>Product</th>
                @if($user->role === 'admin' || $user->role === 'supplier')
                    <th>Supplier</th>
                @endif
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->id }}</td>
                    @if($user->role === 'admin')
                        <td>{{ $purchase->user->name ?? 'N/A' }}</td>
                    @endif
                    <td>{{ $purchase->barang->nama_barang ?? 'N/A' }}</td>
                    @if($user->role === 'admin' || $user->role === 'supplier')
                        <td>{{ $purchase->barang->supplier->name ?? 'N/A' }}</td>
                    @endif
                    <td>Rp. {{ number_format($purchase->price, 2, ',', '.') }}</td>
                    <td>{{ $purchase->jumlah }}</td>
                    <td>Rp. {{ number_format($purchase->total_amount, 2, ',', '.') }}</td>
                    <td>{{ ucfirst($purchase->status) }}</td>
                    <td>{{ $purchase->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
