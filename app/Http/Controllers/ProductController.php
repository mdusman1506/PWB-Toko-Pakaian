<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // 1. TAMPILKAN DAFTAR PRODUK
    public function index()
    {
        $products = Product::all();

        // UBAH BAGIAN INI (Filter Hari Ini Saja)
        $total_omset = Transaction::whereDate('created_at', today())->sum('total_price');

        // Produk Terlaris (Hari ini)
        $produk_laris = Transaction::whereDate('created_at', today())
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->first();

        return view('products.index', compact('products', 'total_omset', 'produk_laris'));
    }

    // 2. TAMPILKAN HALAMAN FORM TAMBAH (Baru)
    public function create()
    {
        return view('products.create');
    }

    // 3. PROSES SIMPAN DATA KE DATABASE (Baru)
    public function store(Request $request)
    {
        // Validasi: Pastikan semua kolom diisi
        $request->validate([
            'name' => 'required|unique:products', // Soal: Nama produk sama tidak bisa 
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:2', // Soal: Stok 1 tidak bisa (Min harus 2) 
        ], [
            'stock.min' => 'Stok minimal harus 2 (1 untuk display, sisanya dijual).'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
    // 4. TAMPILKAN HALAMAN EDIT (Ambil data lama)
    public function edit($id)
    {
        $product = Product::findOrFail($id); // Cari produk berdasarkan ID
        return view('products.edit', compact('product'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            // TAMBAHKAN |min:2 DI BAWAH INI AGAR SAAT EDIT TIDAK BISA JADI 1
            'stock' => 'required|numeric|min:2',
        ], [
            // Pesan Error Custom (Biar jelas kenapa ditolak)
            'stock.min' => 'Stok tidak boleh 1. Minimal 2 (Wajib sisa 1 untuk display).'
        ]);

        // Update Database
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // 6. PROSES HAPUS DATA
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
