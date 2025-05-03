<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah');
            $table->decimal('total', 10, 2);
            $table->decimal('keuntungan', 10, 2);
            $table->string('status')->default('pending'); // Tambahan untuk status transaksi
            $table->timestamps();
        
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
        
            // Indeks
            $table->index('user_id');
            $table->index('barang_id');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('transaksis'); // Drop tabel jika migrasi dibatalkan
    }
}
