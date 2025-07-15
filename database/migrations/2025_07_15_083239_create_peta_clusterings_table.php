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
        Schema::create('peta_clusterings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file')->index();
            $table->string('id_usulan')->nullable();
            $table->text('nama_kegiatan')->nullable();
            $table->double('iku')->nullable();
            $table->double('nilai_rab_usulan')->nullable();
            $table->double('tingkat_risiko')->nullable();
            $table->unsignedTinyInteger('cluster')->nullable(); // hasil cluster
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
        Schema::dropIfExists('peta_clusterings');
    }
};
