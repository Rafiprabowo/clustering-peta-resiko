<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterLabel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_file',
        'cluster',
        'skor_iku',
        'anggaran',
        'skor_kemungkinan',
        'skor_dampak',
        'prioritas_score',
        'label'
    ];

}
