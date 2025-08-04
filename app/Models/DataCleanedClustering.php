<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCleanedClustering extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function prosesClustering(){
        return $this->belongsTo(ProsesClustering::class);

    }

     public function clustered()
    {
        return $this->hasOne(DataClusteredClustering::class, 'data_cleaned_id');
    }

    public function transformed()
    {
        return $this->hasOne(DataTransformedClustering::class, 'data_cleaned_id');
    }
}
