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
        Schema::create('cluster_petas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peta_cleaned');
            $table->unsignedBigInteger('id_clustering_run');
            $table->integer('cluster');
            $table->timestamps();

            $table->foreign('id_peta_cleaned')->references('id')->on('peta_cleaneds')->onDelete('cascade');
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
        Schema::dropIfExists('cluster_petas');
    }
};
