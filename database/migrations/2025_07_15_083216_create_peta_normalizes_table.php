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
        Schema::create('peta_normalizes', function (Blueprint $table) {
        $table->id();
        $table->string('nama_file')->index();

        // Field utama yang langsung berisi hasil normalisasi
        $table->double('iku')->nullable(); // isinya = normal_iku
        $table->string('id_usulan')->nullable();
        $table->text('nama_kegiatan')->nullable();
        $table->double('nilai_rab_usulan', 20)->nullable(); // isinya = normal_nilai_rab_usulan
        $table->string('nama_unit')->nullable();
        $table->text('pernyataan_risiko')->nullable();
        $table->text('uraian_dampak')->nullable();
        $table->text('pengendalian')->nullable();
        $table->string('risiko')->nullable();
        $table->string('dampak')->nullable();
        $table->string('probabilitas')->nullable();

        // Tambahan untuk hasil perhitungan
        $table->double('tingkat_risiko')->nullable(); // = dampak_numerik * probabilitas_numerik
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
        Schema::dropIfExists('peta_normalizes');
    }
};
