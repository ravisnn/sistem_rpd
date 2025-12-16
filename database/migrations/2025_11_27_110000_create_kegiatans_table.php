<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->bigIncrements('id_kegiatan');
            $table->string('kode');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kegiatans');
    }
};
