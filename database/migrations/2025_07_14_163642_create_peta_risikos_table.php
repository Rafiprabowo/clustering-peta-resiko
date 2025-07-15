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
        Schema::create('peta_risikos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file')->index();
            $table->string('iku')->nullable();
            $table->string('id_usulan')->nullable();
            $table->text('nama_kegiatan')->nullable();
            $table->decimal('nilai_rab_usulan', 20)->nullable();
            $table->string('nama_unit')->nullable();
            $table->text('pernyataan_risiko')->nullable();
            $table->text('uraian_dampak')->nullable();
            $table->text('pengendalian')->nullable();
            $table->string('risiko')->nullable();
            $table->string('dampak')->nullable();
            $table->string('probabilitas')->nullable();
            $table->integer('status_telaah')->nullable();
            $table->integer('telaah_substansi')->nullable();
            $table->integer('telaah_teknis')->nullable();
            $table->integer('telaah_spi')->nullable();
            $table->text('rekomendasi_substansi')->nullable();
            $table->text('rekomendasi_teknis')->nullable();
            $table->text('rekomendasi_spi')->nullable();
            $table->text('kesesuaian_pk_direktur')->nullable();
            $table->integer('is_sesuai_pk_direktur')->nullable();

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
        Schema::dropIfExists('peta_risikos');
    }
};
