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
        Schema::create('clustering_runs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file');
            $table->string('metode')->default('K-Means');
            $table->timestamp('waktu_proses')->nullable();
            $table->float('silhouette_score')->nullable();
            $table->integer('tahun');
            $table->integer('jumlah_cluster')->nullable();
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
        Schema::dropIfExists('clustering_runs');
    }
};
