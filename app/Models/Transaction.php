<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Transaksi milik siapa? (User/Kasir)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Transaksi beli barang apa? (Product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
