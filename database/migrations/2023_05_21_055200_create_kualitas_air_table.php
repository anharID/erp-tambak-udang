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
        Schema::create('kualitas_air', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolam_id');
            $table->foreignId('user_id');
            $table->float('suhu');
            $table->float('ph');
            $table->float('do');
            $table->float('salinitas');
            $table->float('kecerahan');
            $table->string('warna_air');
            $table->float('tinggi_air');
            $table->float('amonia')->nullable();
            $table->float('nitrit')->nullable();
            $table->time('waktu_pengukuran');
            $table->date('tanggal');
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
        Schema::dropIfExists('monitoring');
    }
};
