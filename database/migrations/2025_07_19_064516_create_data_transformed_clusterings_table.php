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
        Schema::create('data_transformed_clusterings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proses_clustering_id')->constrained('proses_clusterings')->onDelete('cascade');
            $table->foreignId('data_cleaned_id')->constrained('data_cleaned_clusterings')->onDelete('cascade');
            $table->integer('iku');
            $table->decimal('nilai_rab_usulan', 20, 2);
            $table->integer('dampak');
            $table->integer('probabilitas');
            $table->integer('skor_risiko');
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
        Schema::dropIfExists('data_transformed_clusterings');
    }
};
