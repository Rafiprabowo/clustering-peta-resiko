<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterIku extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_iku',
        'uraian'
    ];

}
