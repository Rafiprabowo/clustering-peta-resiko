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
        Schema::create('preprocessing_petas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peta_cleaned');
            $table->json('transform')->nullable();
            $table->json('normalisasi')->nullable();
            $table->timestamps();

            $table->foreign('id_peta_cleaned')->references('id')->on('peta_cleaneds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preprocessing_petas');
    }
};
