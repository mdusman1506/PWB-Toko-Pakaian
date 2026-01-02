<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // 1. TAMPILKAN HALAMAN KASIR (Form Transaksi)
    public function index()
    {
        // Ambil produk yang stoknya lebih dari 0 saja
        $products = Product::where('stock', '>', 0)->get();
        $history = Transaction::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(10) // Ambil 10 terakhir aja biar gak berat
            ->get();

        return view('transactions.index', compact('products', 'history'));

        // Ambil riwayat transaksi hari ini (agar kasir bisa lihat)
        $transactions = Transaction::with('product')->latest()->get();

        return view('transactions.index', compact('products', 'transactions'));
    }

    // 2. PROSES SIMPAN TRANSAKSI (BELANJA)
    public function store(Request $request)
    {
        // Ambil data JSON dari Cart
        $cart = json_decode($request->cart_data, true);

        if (!$cart || count($cart) < 1) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // Buat Kode Transaksi Unik (Agar bisa dikelompokkan di Nota)
        $invoice_code = 'TRX-' . time();

        // Variabel untuk hitung total di server (Validasi ulang biar aman)
        $grand_total_qty = 0;
        $grand_subtotal = 0;

        // 1. Hitung dulu total semuanya
        foreach ($cart as $item) {
            $grand_subtotal += ($item['price'] * $item['qty']);
            $grand_total_qty += $item['qty'];
        }

        // 2. LOGIKA DISKON (GANDA)
        // Jika Total Belanja > 200.000 ATAU Jumlah Barang > 3
        $discount_amount = 0;
        if ($grand_subtotal > 100000 || $grand_total_qty > 3) {
            $discount_amount = $grand_subtotal * 0.10; // Diskon 10%
        }

        // 3. Simpan Setiap Item ke Database
        foreach ($cart as $item) {
            $product = Product::find($item['id']);

            // Cek stok (Wajib sisakan 1)
            $stok_tersedia = $product->stock - 1; // Stok yang boleh dijual

            if ($item['qty'] > $stok_tersedia) {
                return back()->with('error', 'Gagal! Stok ' . $product->name . ' tinggal ' . $product->stock . '. Harus disisakan 1 untuk display.');
            }

            // Hitung harga per item setelah kena potongan diskon (proporsional)
            // Rumus: (Harga Item / Total Subtotal) * Total Diskon
            $item_subtotal = $item['price'] * $item['qty'];
            $item_discount = ($item_subtotal / $grand_subtotal) * $discount_amount;
            $final_price_per_row = $item_subtotal - $item_discount;

            Transaction::create([
                'user_id' => auth()->id(),
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'total_price' => $final_price_per_row, // Harga setelah diskon
                'created_at' => now(), // Timestamp sama
            ]);

            // Kurangi Stok
            $product->decrement('stock', $item['qty']);
        }

        // Simpan data invoice ke session untuk dicetak
        return redirect()->route('transactions.print')->with([
            'invoice_code' => $invoice_code,
            'cart' => $cart,
            'subtotal' => $grand_subtotal,
            'discount' => $discount_amount,
            'total' => $grand_subtotal - $discount_amount,
            'kasir' => auth()->user()->name,
            'date' => now()->format('d-m-Y H:i')
        ]);
    }


    // FUNGSI BARU: HALAMAN CETAK NOTA
    public function print()
    {
        if (!session('cart')) {
            return redirect()->route('transactions.index');
        }
        return view('transactions.print');
    }
}
