<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('uraians', function (Blueprint $table) {
              $table->bigIncrements('id_uraian');
            $table->string('kode')->unique();
            $table->string('nama');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('uraians');
    }
};
