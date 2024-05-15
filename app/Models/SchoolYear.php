<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;

    public function levels()
    {
        return $this->hasMany(Level::class, 'id');
    }

    public function classes()
    {
        return $this->hasMany(Classe::class);
    }


}
