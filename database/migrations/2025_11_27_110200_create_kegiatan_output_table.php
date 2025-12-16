<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kegiatan_output', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kegiatan_id');
            $table->unsignedBigInteger('output_id');
            $table->unsignedBigInteger('akun_id');
            $table->unsignedBigInteger('uraian_id');
            $table->timestamps();

            $table->foreign('kegiatan_id')->references('id_kegiatan')->on('kegiatans')->onDelete('cascade');
            $table->foreign('output_id')->references('id_output')->on('outputs')->onDelete('cascade');
            $table->foreign('akun_id')->references('id_akun')->on('akuns')->onDelete('cascade');
            $table->foreign('uraian_id')->references('id_uraian')->on('uraians')->onDelete('cascade');
            $table->unique(['kegiatan_id','output_id','akun_id', 'uraian_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('kegiatan_output');
    }
};
