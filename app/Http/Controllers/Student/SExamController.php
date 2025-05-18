<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class SExamController extends Controller
{

    public function index()
    {
        // Şimdilik tüm sınavları listeliyoruz, ileride öğretmen ile eşleştirme yapılabilir
        $exams = Exam::all();
        return view('student.exams.index', compact('exams'));
    }
    public function start(Exam $exam)
    {
        $questions = $exam->questions()->with('choices')->get();
        $duration = $exam->duration;

        return view('student.exams.start', compact('exam', 'questions', 'duration'));
    }
}
