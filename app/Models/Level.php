<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public function classes()
    {
        return $this->hasMany(Classe::class, 'idLevel');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'id');
    }

    public function inscrire()
    {
        return $this->hasMany(Inscrire::class, 'id');
    }

}
