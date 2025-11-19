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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id(); // ID unik untuk baris detail ini

            // 1. Terhubung ke tabel 'orders'
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade'); // Jika pesanan dihapus, detailnya ikut terhapus

            // 2. Terhubung ke tabel 'menu'
            $table->foreignId('menu_id')
                  ->constrained('menu')
                  ->onDelete('cascade'); // Jika menu dihapus, detail ini ikut terhapus

            // 3. Berapa banyak yang dipesan
            $table->integer('quantity');

            // 4. Harga satuan item SAAT DIPESAN
            $table->integer('price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};