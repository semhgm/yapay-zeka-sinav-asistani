<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'duration',
    ];
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function studentProgresses()
    {
        return $this->hasMany(StudentProgress::class);
    }

    public function studentExamAnalyses()
    {
        return $this->hasMany(StudentExamAnalysis::class);
    }
}
