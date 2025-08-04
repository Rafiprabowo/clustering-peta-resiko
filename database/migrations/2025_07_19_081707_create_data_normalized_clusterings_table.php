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
        Schema::create('data_normalized_clusterings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proses_clustering_id')->constrained('proses_clusterings')->onDelete('cascade');
            $table->foreignId('data_cleaned_id')->constrained('data_cleaned_clusterings')->onDelete('cascade');
            $table->decimal('iku', 20, 18);
            $table->decimal('nilai_rab_usulan', 20, 18);
            $table->decimal('skor_risiko', 20, 18);
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
        Schema::dropIfExists('data_normalized_clusterings');
    }
};
