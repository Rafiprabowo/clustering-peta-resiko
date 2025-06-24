<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaRisikoMentah extends Model
{
    use HasFactory;
    protected $fillable = [
        'idUsulan',
        'iku',
        'nmKegiatan',
        'nilRabUsulan',
        'nmUnit',
        'pernyataanRisiko',
        'uraianDampak',
        'pengendalian',
        'Resiko',
        'dampak',
        'probaBilitas',
        'id_file_peta_risiko',
        'id_clustering'


    ];

    public function clustering(){
        return $this->belongsTo(ClusteringRun::class, 'id_clustering');
    }

    public function cluster(){
        return $this->hasOne(PetaRisikoCluster::class, 'id_peta_risiko_mentah');
    }

    public function ikus(){
        return $this->belongsToMany(MasterIku::class, 'iku_peta', 'id_peta_risiko_mentah', 'id_master_iku');
    }
}
