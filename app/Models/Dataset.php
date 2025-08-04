<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function petaRisiko()
    {
        return $this->hasMany(PetaRisiko::class);
    }

    public function prosesClusterings(){
        return $this->hasMany(ProsesClustering::class, 'dataset_id');
    }

}
