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
        Schema::create('energi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolam_id')->constrained('kolam');
            $table->foreignId('siklus_id')->constrained('siklus');
            $table->foreignId('penggunaan_id')->constrained('penggunaan_energi');
            $table->date('tanggal');
            $table->string('sumber_energi');
            $table->integer('jumlah');
            $table->float('daya');
            $table->float('lama_penggunaan');
            $table->float('kwh');
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
        Schema::dropIfExists('energi');
    }
};
