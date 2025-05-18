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
        return $this->hasMany(Subject::class);
    }
    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }
    public function studentProgresses()
    {
        return $this->hasMany(StudentProgress::class);
    }
    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function studentExamAnalyses()
    {
        return $this->hasMany(StudentExamAnalysis::class);
    }
}
