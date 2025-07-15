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
        Schema::create('interpretasi_clusters', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file')->index();
            $table->unsignedTinyInteger('cluster');
            $table->double('c_iku')->nullable();
            $table->double('c_anggaran')->nullable();
            $table->double('c_tingkat_risiko')->nullable();
            $table->string('interpretasi')->nullable(); // Contoh: "Prioritas Sangat Tinggi"
            $table->unsignedTinyInteger('tingkat_prioritas')->nullable(); // 1–5
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
        Schema::dropIfExists('interpretasi_clusters');
    }
};
