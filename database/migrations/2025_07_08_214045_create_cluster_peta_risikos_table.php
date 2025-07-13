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
        Schema::create('cluster_peta_risikos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_clustering');
            $table->string('id_usulan');
            $table->string('iku')->nullable();
            $table->text('nama_kegiatan');
            $table->decimal('nil_rab_usulan', 20);
            $table->string('nama_unit');
            $table->text('pernyataan_risiko');
            $table->text('uraian_dampak');
            $table->text('pengendalian');
            $table->string('kategori_risiko');
            $table->string('dampak');
            $table->string('probabilitas');
            $table->integer('status_telaah');
            $table->integer('telaah_substansi')->nullable();
            $table->integer('telaah_teknis')->nullable();
            $table->integer('telaah_spi')->nullable();
            $table->text('rekomendasi_substansi')->nullable();
            $table->text('rekomendasi_teknis')->nullable();
            $table->text('rekomendasi_spi')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->text('kesesuaian_pk_direktur')->nullable();
            $table->integer('is_sesuai_pk_direktur');
            //transform
            $table->integer('dampak_numerik');
            $table->integer('probabilitas_numerik');
            $table->integer('iku_numerik')->nullable();
            $table->integer('tingkat_risiko');
            //normalisasi
            $table->float('normal_iku_numerik');
            $table->float('normal_nil_rab_usulan');
            $table->float('normal_tingkat_risiko');
            $table->integer('cluster');

            $table->timestamps();

            $table->foreign('id_clustering')->references('id')->on('clusterings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cluster_peta_risikos');
    }
};
