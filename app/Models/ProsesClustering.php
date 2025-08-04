<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesClustering extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dataset(){
        return $this->belongsTo(Dataset::class);
    }
    
    // ProsesClustering.php

    public function clusteredData()
    {
        return $this->hasManyThrough(
            DataClusteredClustering::class,
            DataCleanedClustering::class,
            'proses_clustering_id', // Foreign key di DataCleanedClustering
            'data_cleaned_id',      // Foreign key di DataClusteredClustering
            'id',                   // Local key di ProsesClustering
            'id'                    // Local key di DataCleanedClustering
        );
    }


    public function dataCleaneds(){
        return $this->hasMany(DataCleanedClustering::class, 'proses_clustering_id');
    }

    public function centroids(){
        return $this->hasMany(DataCentroidClustering::class, 'proses_clustering_id');
    }

    public function interpretations(){
        return $this->hasMany(DataInterpretationClustering::class, 'proses_clustering_id');
    }
}
