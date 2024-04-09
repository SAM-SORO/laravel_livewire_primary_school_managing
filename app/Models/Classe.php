<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom','capacite', 'Effectif', 'idBat', 'idLevel', 'schoolYear_id',
    ];

    // Dans votre modèle Classe
    public function batiment()
    {
        return $this->belongsTo(Batiment::class, 'idBat');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'idLevel');
    }

}
