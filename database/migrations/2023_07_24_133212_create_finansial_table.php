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
            $table->unsignedBigInteger("karyawan_id")->nullable();
            $table->unsignedBigInteger("siklus_id")->nullable();
            $table->unsignedBigInteger("logistik_id")->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('set null');
            $table->foreign('siklus_id')->references('id')->on('siklus');
            $table->foreign('logistik_id')->references('id')->on('logistik')->onDelete('set null');
            // $table->foreign('siklus_id')->references('id')->on('siklus');
            // $table->unsignedBigInteger("logistik_id")->nullable();
            // $table->foreign('logistik_id')->references('id')->on('logistik');
            $table->string("keterangan");
            $table->string("jenis_transaksi");
            $table->bigInteger("jumlah");
            $table->string("status")->nullable();
            $table->string("catatan")->nullable();
            $table->date("tanggal");
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
