<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'exam_id',
        'name',
    ];

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
