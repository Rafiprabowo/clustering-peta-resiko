<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterIku extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_iku',
        'uraian'
    ];

    public function petaRisikos(){
        return $this->belongsToMany(PetaRisikoMentah::class, 'iku_peta', 'id_master_iku', 'id_peta_risiko_mentah');
    }
}
