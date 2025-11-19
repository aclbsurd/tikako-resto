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
        // Perintah untuk MENAMBAHKAN kolom baru
        Schema::table('orders', function (Blueprint $table) {
            // Kita akan menambahkan kolom 'nomor_meja'
            // Kita buat 'nullable()' agar pesanan lama (jika ada) tidak error
            // 'after('session_id')' = meletakkan kolom ini setelah 'session_id' (rapi)
            $table->string('nomor_meja')->nullable()->after('session_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Perintah untuk MENGHAPUS kolom (jika migrasi dibatalkan)
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('nomor_meja');
        });
    }
};