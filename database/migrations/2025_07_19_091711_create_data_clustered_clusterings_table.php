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
        Schema::create('data_clustered_clusterings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proses_clustering_id')->constrained('proses_clusterings')->onDelete('cascade');
            $table->foreignId('data_cleaned_id')->constrained('data_cleaned_clusterings')->onDelete('cascade');
            $table->unsignedInteger('cluster');
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
        Schema::dropIfExists('data_clustered_clusterings');
    }
};
