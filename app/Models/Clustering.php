<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clustering extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function centroids(){
        return $this->hasMany(Centroid::class, 'id_clustering');
    }
}
