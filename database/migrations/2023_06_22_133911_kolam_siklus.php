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
        Schema::create('kolam_siklus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolam_id')->constrained('kolam');
            $table->foreignId('siklus_id')->constrained('siklus');
            $table->integer('jumlah_tebar')->nullable();
            $table->integer('doc')->nullable();
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
        Schema::dropIfExists('kolam_siklus');
    }
};
