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
        Schema::create('peta_risiko_clusters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peta_risiko_mentah');
            $table->integer('cluster');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_peta_risiko_mentah')->references('id')->on('peta_risiko_mentahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peta_risiko_clusters');
    }
};
