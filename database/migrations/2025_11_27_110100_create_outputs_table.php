<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('outputs', function (Blueprint $table) {
            $table->bigIncrements('id_output');
            // NOTE: kode intentionally NOT unique so the same output string
            // can be associated with multiple kegiatan entries if desired.
            $table->string('kode');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('outputs');
    }
};
