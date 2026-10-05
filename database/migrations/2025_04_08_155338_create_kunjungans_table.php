<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tamu')->constrained('tamus')->onDelete('cascade');
            $table->foreignId('id_departemen')->constrained('departemens')->onDelete('cascade');
            $table->string('tujuan');
            $table->string('bertemu_dengan');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar');
            $table->string('status');
            $table->timestamps();
        });
        // ini adalah table 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
