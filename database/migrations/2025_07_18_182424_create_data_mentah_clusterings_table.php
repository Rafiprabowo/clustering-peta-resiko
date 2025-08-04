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
        Schema::create('data_mentah_clusterings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proses_clustering_id')->constrained('proses_clusterings')->onDelete('cascade');
            $table->string('iku')->nullable();
            $table->string('id_usulan')->nullable();
            $table->text('nama_kegiatan')->nullable();
            $table->decimal('nilai_rab_usulan', 20, 2)->nullable();
            $table->string('nama_unit')->nullable();
            $table->string('resiko')->nullable();
            $table->string('dampak')->nullable();
            $table->string('probabilitas')->nullable();
            $table->text('pernyataan_risiko')->nullable();
            $table->text('uraian_dampak')->nullable();
            $table->text('pengendalian')->nullable();
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
        Schema::dropIfExists('data_mentah_clusterings');
    }
};
