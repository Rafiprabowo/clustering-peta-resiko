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
        //
        Schema::create('iku_peta', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_peta_risiko_mentah');
            $table->unsignedBigInteger('id_master_iku');
            $table->timestamps();

            $table->foreign('id_peta_risiko_mentah')->references('id')->on('peta_risiko_mentahs')->onDelete('cascade');
            $table->foreign('id_master_iku')->references('id')->on('master_ikus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('iku_peta');
    }
};
