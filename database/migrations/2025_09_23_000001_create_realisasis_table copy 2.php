<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('realisasis', function (Blueprint $table) {
            $table->bigIncrements('id_realisasi');
            $table->string('kegiatan');
            $table->string('komponen')->nullable();
            $table->string('jenis_belanja')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('output');
            $table->unsignedBigInteger('akun_id');
            $table->unsignedBigInteger('uraian_id');
            $table->string('uraians')->nullable();
            $table->bigInteger('target')->default(0);
            $table->bigInteger('jan')->default(0);
            $table->bigInteger('feb')->default(0);
            $table->bigInteger('mar')->default(0);
            $table->bigInteger('apr')->default(0);
            $table->bigInteger('mei')->default(0);
            $table->bigInteger('jun')->default(0);
            $table->bigInteger('jul')->default(0);
            $table->bigInteger('agt')->default(0);
            $table->bigInteger('sep')->default(0);
            $table->bigInteger('okt')->default(0);
            $table->bigInteger('nov')->default(0);
            $table->bigInteger('des')->default(0);
            $table->timestamps();
            $table->foreign('akun_id')->references('id_akun')->on('akuns');
            $table->foreign('uraian_id')->references('id_uraian')->on('uraians');

            // Tambahkan UNIQUE KEY
            $table->unique(['output', 'akun_id', 'uraian_id', 'uraians']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('realisasis');
    }
};
