<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Ini agar kolom-kolom tabel bisa diisi data (Mass Assignment)
    protected $guarded = []; 
}