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
        Schema::create('proses_clusterings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dataset_id')->nullable()->constrained('datasets')->onDelete('set null');
            $table->string('nama_file');
            $table->integer('jumlah_cluster')->nullable();
            $table->string('algoritma')->nullable();
            $table->integer('jumlah_data'); // Jumlah baris data yang digunakan
            $table->boolean('is_saved')->default(false);
            $table->float('akurasi')->nullable();
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
        Schema::dropIfExists('proses_clusterings');
    }
};
