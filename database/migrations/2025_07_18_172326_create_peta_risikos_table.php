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
            $table->foreignId('dataset_id')->constrained('datasets')->onDelete('cascade');
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
        Schema::dropIfExists('peta_risikos');
    }
};
