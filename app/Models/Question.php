<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'exam_id',
        'subject_id',
        'question_text',
        'image_path',
        'correct_answer',
        'order_number',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'question_topics');
    }

}
