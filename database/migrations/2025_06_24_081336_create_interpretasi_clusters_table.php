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
        Schema::create('interpretasi_clusters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_clustering_run');
            $table->integer('cluster');
            $table->json('centroid')->nullable();
            $table->text('interpretasi')->nullable();
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
        Schema::dropIfExists('interpretasi_clusters');
    }
};
