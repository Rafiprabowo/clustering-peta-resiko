<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaCleaned extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_peta_awal',
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
    ];

    public function awal(){
        return $this->belongsTo(PetaAwal::class, 'id_peta_awal');
    }

    public function cluster(){
        return $this->hasOne(ClusterPeta::class, 'id_peta_cleaned');
    }

}
