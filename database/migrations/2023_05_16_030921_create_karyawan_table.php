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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("jabatan_id")->nullable();
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('set null');
            // $table->foreignId('jabatan_id')->constrained('jabatan')->nullable()->nullOnDelete();
            $table->string("nama");
            $table->string("alamat");
            $table->string("tempat_lahir");
            $table->date("tanggal_lahir");
            $table->string("no_hp");
            $table->string("email")->unique();
            $table->string("status");
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
        Schema::dropIfExists('karyawan');
    }
};
