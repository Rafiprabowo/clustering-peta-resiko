<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataClusteredClustering extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function prosesClustering()
    {
        return $this->belongsTo(ProsesClustering::class);
    }

    public function cleaned()
    {
        return $this->belongsTo(DataCleanedClustering::class, 'data_cleaned_id');
    }
}
