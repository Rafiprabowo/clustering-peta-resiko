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
    //     Schema::create('cluster_labels', function (Blueprint $table) {
    //     $table->id();
    //     $table->unsignedBigInteger('id_file'); // relasi ke tabel file
    //     $table->integer('cluster')->unsigned();
    //     $table->decimal('skor_iku', 8 , 4);
    //     $table->decimal('anggaran', 20, 2);
    //     $table->decimal('skor_kemungkinan', 4, 2);
    //     $table->decimal('skor_dampak', 4, 2);
    //     $table->decimal('prioritas_score', 20, 4);
    //     $table->string('label');
    //     $table->timestamps();

    //     $table->foreign('id_file')->references('id')->on('peta_risiko_files')->onDelete('cascade');
    // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('cluster_labels');
    }
};
