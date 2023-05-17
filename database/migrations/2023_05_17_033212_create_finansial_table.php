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
        Schema::create('finansial', function (Blueprint $table) {
            $table->id();
            $table->foreignId("karyawan_id");
            // $table->foreignId("logistik_id");
            $table->date("tanggal");
            $table->string("keterangan");
            $table->string("jenis_transaksi");
            $table->integer("jumlah");
            $table->string("status");
            $table->string("catatan");
            $table->integer("total_saldo");
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
        Schema::dropIfExists('finansial');
    }
};
