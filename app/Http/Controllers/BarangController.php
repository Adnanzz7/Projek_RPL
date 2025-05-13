<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $barangs = Barang::query();

        if ($search) {
            $barangs->where('nama_barang', 'like', '%' . $search . '%');
        }

        $barangs = $barangs->get();

        if ($request->ajax()) {
            return response()->json([
                'barangs' => $barangs
            ]);
        }

        return view('barangs.index', compact('barangs'));
    }   

    public function create()
    {
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'supplier')) {
            return view('barangs.create');
        }
        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');        
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_barang' => 'required|in:makanan,kerajinan',
            'harga_barang' => 'required|numeric',
            'jumlah_barang' => 'required|numeric',
            'foto_barang' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'keterangan_barang' => 'nullable|string|max:1000',
        ]);
    
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'supplier')) {
            $validated['user_id'] = Auth::id();           
            $hargaPokok = $validated['harga_barang'] - 1000;
            $validated['harga_pokok'] = $hargaPokok;
            $validated['jumlah_barang_awal'] = $validated['jumlah_barang'];
            $validated['jumlah_terjual'] = 0;
    
            if ($request->hasFile('foto_barang')) {
                $validated['foto_barang'] = $request->file('foto_barang')->store('images', 'public');
            }
    
            Barang::create($validated);
    
            return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan!');
        }
    
        abort(403, 'Anda tidak memiliki izin untuk menambah barang.');
    }    
    
    public function edit(Barang $barang)
    {
        // Log::info('User role: ' . Auth::user()->role);
        // Log::info('User ID: ' . Auth::id());
        // Log::info('Barang user ID: ' . $barang->user_id);

        if (Auth::check() && (Auth::user()->role === 'admin' || (Auth::user()->role === 'supplier' && Auth::id() === $barang->user_id))) {
            return view('barangs.edit', compact('barang'));
        }

        abort(403, 'Anda tidak memiliki izin untuk mengedit barang ini.');
    }


    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $barang->user_id) {
            return redirect()->route('barangs.index')->with('error', 'Anda tidak memiliki izin untuk menghapus barang ini.');
        }
        $barang->delete();
        return redirect()->route('barangs.index')->with('status', 'Barang berhasil dihapus.');
    }

    public function update(Request $request, Barang $barang)
    {
        // Validasi input yang diterima
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_barang' => 'required|in:makanan,kerajinan',
            'harga_barang' => 'required|numeric|min:0',
            'jumlah_barang' => 'required|integer|min:1',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan_barang' => 'nullable|string|max:1000',
        ]);

        if (Auth::check() && (Auth::user()->role === 'admin' || (Auth::user()->role === 'supplier' && Auth::id() === $barang->user_id))) 
        {
            $hargaBarang = $validated['harga_barang'];
            $hargaPokok = $hargaBarang - 1500;
            $hargaDenganRetribusi = $hargaBarang + 1000;
            $hargaDenganJasaWeb = $hargaDenganRetribusi + 500;
            $validated['harga_pokok'] = $hargaPokok;
            $validated['harga_dengan_retribusi'] = $hargaDenganRetribusi;
            $validated['harga_dengan_web'] = $hargaDenganJasaWeb;
            $validated['jumlah_barang_awal'] = $validated['jumlah_barang'];
            
            if ($request->hasFile('foto_barang')) 
            {
                if ($barang->foto_barang) {
                    Storage::delete('public/' . $barang->foto_barang);
                }
                
                $validated['foto_barang'] = $request->file('foto_barang')->store('images', 'public');
            } 
            else 
            {
                unset($validated['foto_barang']);
            }            

            $barang->update($validated);

            return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui!');
        }

        abort(403, 'Anda tidak memiliki izin untuk memperbarui barang ini.');
    }

    public function beli(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $jumlah = $request->input('jumlah');

        if ($jumlah > $barang->jumlah_barang) {
            return redirect()->back()->with('error', 'Jumlah yang dibeli melebihi stok yang tersedia.');
        }

        $totalHarga = $barang->harga_barang * $jumlah;
        $barang->jumlah_barang -= $jumlah;
        $barang->save();

        return view('barangs.beli', compact('barang', 'jumlah', 'totalHarga'));
    }

    public function beliMassa(Request $request)
    {
        $barangIds = array_keys($request->barang);
        $barangs = Barang::whereIn('id', $barangIds)->get();
        $pembelian = [];

        foreach ($barangs as $barang) {
            $jumlah = $request->barang[$barang->id];
            if ($jumlah > 0) {
                $pembelian[] = [
                    'barang' => $barang,
                    'jumlah' => $jumlah,
                    'total' => $barang->harga_barang * $jumlah
                ];
            }
        }

        return view('beli', compact('pembelian'));
    }

    public function prosesPembelian(Request $request)
    {
        $pembelian = session('pembelian');
        
        if (!$pembelian) {
            return redirect()->route('barangs.index')->with('error', 'Tidak ada barang yang dibeli.');
        }

        DB::transaction(function () use ($pembelian) {
            foreach ($pembelian as $item) {
                $barang = $item['barang'];
                $jumlah = $item['jumlah'];
                $total = $item['total'];
                $keuntungan = ($barang->harga_barang - $barang->harga_pokok) * $jumlah;

                if ($barang->jumlah_barang < $jumlah) {
                    throw new \Exception('Jumlah barang tidak cukup.');
                }

                $barang->jumlah_barang -= $jumlah;
                $barang->jumlah_terjual += $jumlah;
                $barang->save();

                Transaksi::create([
                    'user_id' => Auth::id(),
                    'barang_id' => $barang->id,
                    'jumlah' => $jumlah,
                    'total_harga' => $total,
                    'keuntungan' => $keuntungan,
                    'tanggal_transaksi' => now(),
                ]);
            }
        });

        session()->forget('pembelian');

        return redirect()->route('barangs.index')->with('success', 'Pembelian berhasil diproses!');
    }

    public function tambahKeKeranjang(Request $request)
    {
        $barang = Barang::find($request->id);
        
        if ($barang->jumlah_barang >= $request->quantity) {
            $barang->jumlah_barang -= $request->quantity;
            $barang->jumlah_terjual += $request->quantity;
            $barang->save();
        } 
        else {
            return redirect()->back()->with('error', 'Jumlah barang tidak cukup!');
        }

        $keranjang = session()->get('keranjang', []);
        $keranjang[$barang->id] = $request->quantity;
        session()->put('keranjang', $keranjang);

        return redirect()->route('keranjang.index')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        $jumlahBarangTerjual = $barang->jumlah_barang_awal - $barang->jumlah_barang;

        if ($jumlahBarangTerjual <= 0) {
            $totalHargaTerjual = 0;
            $keuntunganPKK = 0;
            $totalHasilPengiriman = 0;
        } 
        else {
            $totalHargaTerjual = $jumlahBarangTerjual * $barang->harga_barang;
            $keuntunganPKK = $jumlahBarangTerjual * 1000;
            $totalHasilPengiriman = $jumlahBarangTerjual * ($barang->harga_barang - 1000);
            $totalHasilPengiriman -= $jumlahBarangTerjual * 500;
        }

        $jumlahBarangSisa = $barang->jumlah_barang_awal - $jumlahBarangTerjual;

        return view('barangs.show', compact(
            'barang',
            'jumlahBarangTerjual',
            'jumlahBarangSisa',
            'totalHargaTerjual',
            'keuntunganPKK',
            'totalHasilPengiriman'
        ));
    }
}