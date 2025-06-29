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
        Schema::create('peta_awals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_clustering_run')->nullable();
            $table->string('idUsulan')->nullable();
            $table->string('iku')->nullable();
            $table->text('nmKegiatan')->nullable();
            $table->string('nilRabUsulan')->nullable();
            $table->string('nmUnit')->nullable();
            $table->text('pernyataanRisiko')->nullable();
            $table->text('uraianDampak')->nullable();
            $table->text('pengendalian')->nullable();
            $table->string('Resiko')->nullable();
            $table->string('dampak')->nullable();
            $table->string('probaBilitas')->nullable();
            $table->timestamps();

            $table->foreign('id_clustering_run')->references('id')->on('clustering_runs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peta_awals');
    }
};
