<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function clusters(){
        return $this->hasMany(ClusterPeta::class, 'id_clustering_run');
    }
}
