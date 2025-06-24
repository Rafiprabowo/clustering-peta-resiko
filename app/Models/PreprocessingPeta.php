<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreprocessingPeta extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_peta_cleaned',
        'transform',
        'normalisasi'
    ];
}
