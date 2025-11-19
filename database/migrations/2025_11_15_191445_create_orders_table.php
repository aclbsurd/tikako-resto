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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // ID unik untuk pesanan (misal: Pesanan #1, #2)

            // Kolom untuk melacak pesanan siapa ini
            $table->string('session_id');

            // Berapa total harga pesanan ini
            $table->integer('total_price');

            // Status pesanan, defaultnya 'Diterima' saat baru dibuat
            $table->string('status')->default('Diterima');

            $table->timestamps(); // Kapan pesanan ini dibuat
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};