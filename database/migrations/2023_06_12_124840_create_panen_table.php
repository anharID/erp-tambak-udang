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
        Schema::create('Panen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolam_id')->constrained('kolam');
            $table->foreignId('siklus_id')->constrained('siklus');
            // $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal');
            $table->time('waktu_panen');
            $table->float('size_besar');
            $table->float('size_kecil');
            $table->float('tonase_besar');
            $table->float('tonase_kecil');
            $table->float('tonase_jumlah');
            $table->float('populasi_terambil');
            $table->float('abw');
            $table->string('status')->nullable();
            $table->string('catatan')->nullable();
            $table->boolean('is_validated')->default(0);
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
        Schema::dropIfExists('Panen');
    }
};
