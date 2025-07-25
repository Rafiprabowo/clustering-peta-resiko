<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function Level_menu()
    {
        return $this->hasMany(Level_menu::class, 'id_level');
    }
    public function User()
    {
        return $this->hasMany(User::class, 'id_level');
    }
}
