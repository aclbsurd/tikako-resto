<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        // Perintah untuk MEMBUAT tabel 'menu'
        Schema::create('menu', function (Blueprint $table) {
            $table->id(); // Kolom 'id' (Primary Key, Auto-increment)
            
            $table->string('nama_menu'); // Kolom untuk nama menu (tipe VARCHAR)
            $table->integer('harga'); // Kolom untuk harga (tiPE INTEGER)
            
            // Kolom untuk kategori (misal: Makanan, Minuman, Cemilan)
            $table->string('kategori')->default('Makanan'); 
            
            $table->text('deskripsi')->nullable(); // Kolom deskripsi (boleh kosong)
            $table->string('foto')->nullable(); // Kolom untuk path/url gambar (boleh kosong)
            
            // === Kolom Penting Sesuai Dokumen Anda ===
            
            // Untuk status ketersediaan (Stok Habis/Ada)
            // default(true) berarti setiap menu baru otomatis dianggap 'tersedia'
            $table->boolean('is_tersedia')->default(true); 
            
            // Untuk fitur "Rekomendasi Menu Terlaris"
            // default(false) berarti menu baru tidak otomatis jadi rekomendasi
            $table->boolean('is_rekomendasi')->default(false); 
            
            // Otomatis membuat kolom 'created_at' dan 'updated_at'
            // Berguna untuk melacak kapan menu dibuat atau diubah
            $table->timestamps(); 
        });
    }

    /**
     * Balikkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        // Perintah untuk MENGHAPUS tabel 'menu' jika migrasi dibatalkan
        Schema::dropIfExists('menu');
    }
};