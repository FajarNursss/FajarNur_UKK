<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable(); // Menambahkan kolom bukti_pembayaran
        });
    }

    public function down()
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropColumn('bukti_pembayaran');
        });
    }
};
