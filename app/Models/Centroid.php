<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centroid extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function clustering(){
        return $this->belongsTo(Clustering::class, 'id_clustering');
    }
}
