<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaAwal extends Model
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
    ];

    public function cleaned(){
        return $this->hasOne(PetaCleaned::class, 'id_peta_awal');
    }
}
