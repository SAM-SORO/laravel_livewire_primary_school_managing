<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Relation avec le modèle affecter
    public function affecter()
    {
        return $this->belongsTo(Affecter::class);
    }

    // Relation avec le modèle inscrire
    public function inscrire()
    {
        return $this->belongsTo(Inscrire::class, 'id');
    }

    // Relation avec le modèle Parents
    public function parents()
    {
        return $this->belongsToMany(Parents::class, 'student_parent', 'student_id', 'parent_id');
    }


}
