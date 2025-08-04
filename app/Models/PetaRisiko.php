<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaRisiko extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

}
