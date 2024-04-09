<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscrire extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'etatAffectation',
        'level_id',
        'schoolYear_id',
    ];

    // Relation avec le modèle Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relation avec le modèle Level
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
}
