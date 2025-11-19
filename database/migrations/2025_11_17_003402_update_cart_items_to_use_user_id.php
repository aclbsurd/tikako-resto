<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // 1. Tambahkan kolom user_id
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
            
            // 2. Hapus kolom session_id yang lama
            $table->dropColumn('session_id');
        });
    }

    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // 1. Kembalikan kolom session_id
            $table->string('session_id')->nullable();
            
            // 2. Hapus kolom user_id dan foreign key
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};