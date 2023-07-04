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
        Schema::create('logistik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaris_id')->constrained('inventaris');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->integer('stok_masuk')->nullable();
            $table->integer('stok_keluar')->nullable();
            $table->string('sumber');
            $table->string('catatan')->nullable();
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
        Schema::dropIfExists('logistik');
    }
};
