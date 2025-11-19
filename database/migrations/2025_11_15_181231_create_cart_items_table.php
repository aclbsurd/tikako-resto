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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap baris keranjang

            // Kolom untuk melacak keranjang siapa ini
            $table->string('session_id'); 

            // Kolom untuk menghubungkan ke tabel 'menu'
            $table->foreignId('menu_id')
                  ->constrained('menu') // Terhubung ke 'id' di tabel 'menu'
                  ->onDelete('cascade'); // Jika menu dihapus, item ini juga terhapus

            // Berapa banyak item ini yang dipesan
            $table->integer('quantity');

            $table->timestamps(); // Kapan item ini ditambahkan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
