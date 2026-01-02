<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel Users (Siapa kasirnya?)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relasi ke tabel Products (Baju apa yang dibeli?)
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('quantity');    // Jumlah beli
            $table->integer('total_price'); // Total bayar
            $table->timestamps();           // Tanggal transaksi
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
