<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('ikpa_targets', function (Blueprint $table) {
            $table->bigIncrements('id_ikpa_target');
            $table->string('jenis_belanja');
            $table->unsignedTinyInteger('triwulan');
            $table->integer('tahun');

            // Kolom target 0–100
            $table->unsignedTinyInteger('target')
                ->default(0)
                ->check('target <= 100');

            $table->timestamps();

            $table->unique(['jenis_belanja', 'triwulan', 'tahun']);
        });
    }

    public function down() {
        Schema::dropIfExists('ikpa_targets');
    }
};
