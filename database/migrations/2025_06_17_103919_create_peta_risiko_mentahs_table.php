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
        Schema::create('peta_risiko_mentahs', function (Blueprint $table) {
            $table->id();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peta_risiko_mentahs');
    }
};
