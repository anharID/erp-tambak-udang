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
        Schema::create('sampling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolam_id')->constrained('kolam');
            $table->foreignId('siklus_id')->constrained('siklus');
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal');
            $table->integer('umur');
            $table->float('berat_sampling');
            $table->float('banyak_sampling');
            $table->float('abw');
            $table->float('adg');
            $table->float('size');
            $table->float('sr');
            $table->float('fr');
            $table->float('biomas');
            $table->float('fcr');
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
        Schema::dropIfExists('sampling');
    }
};
