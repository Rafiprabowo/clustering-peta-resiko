<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaRisikoCluster extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_peta_risiko_mentah',
        'cluster',
    ];

    public function petaRisikoMentah(){
        return $this->belongsTo(PetaRisikoMentah::class, 'id_peta_risiko_mentah');
    }
}
