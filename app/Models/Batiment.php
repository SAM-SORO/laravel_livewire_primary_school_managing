<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batiment extends Model
{
    use HasFactory;

    protected $fillable = ['nomBat', 'dateBat'];

    public function classes()
    {
        return $this->hasMany(Classe::class, 'idBat');
    }

}
