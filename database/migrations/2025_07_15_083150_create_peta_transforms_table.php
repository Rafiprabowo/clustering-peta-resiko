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
        Schema::create('peta_transforms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file')->index();
            $table->double('iku')->nullable();
            $table->string('id_usulan')->nullable();
            $table->text('nama_kegiatan')->nullable();
            $table->decimal('nilai_rab_usulan', 20)->nullable();
            $table->string('nama_unit')->nullable();
            $table->text('pernyataan_risiko')->nullable();
            $table->text('uraian_dampak')->nullable();
            $table->text('pengendalian')->nullable();
            $table->string('risiko')->nullable();
            $table->double('dampak')->nullable();
            $table->double('probabilitas')->nullable();
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
        Schema::dropIfExists('peta_transforms');
    }
};
