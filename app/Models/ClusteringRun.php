<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class ClusteringRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_file',
        'metode',
        'waktu_proses',
        'tahun',
        'silhouette_score'
    ];

    public function petaAwals(){
        return $this->hasMany(PetaAwal::class, 'id_clustering_run');
    }

    public function petaCleaneds(){
        return $this->hasMany(PetaCleaned::class, 'id_clustering_run');
    }

    public function clusters(){
        return $this->hasMany(ClusterPeta::class, 'id_clustering_run');
    }

    public function interpretasi(){
        return $this->hasMany(InterpretasiCluster::class, 'id_clustering_run');
    }
}
