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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string("nama_barang");
            $table->string("jenis_barang");
            $table->date("tanggal_peroleh");
            $table->integer("stok");
            $table->integer('harga_satuan');
            $table->integer('nilai_inventaris')->nullable();
            $table->string("lokasi");
            $table->string("status")->nullable();
            $table->string("catatan")->nullable();
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
        Schema::dropIfExists('inventaris');
    }
};
