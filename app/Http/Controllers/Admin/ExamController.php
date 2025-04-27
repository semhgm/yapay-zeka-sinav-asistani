<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Subject;
class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::all();
        return view('admin.pages.exams.index', compact('exams'));
    }
    // Sınav ekleme formu gösterimi
    public function create()
    {
        $subjects = Subject::all(); // Tüm dersleri çekiyoruz
        return view('admin.pages.exams.create', compact('subjects'));
    }

    // Sınav kaydetme işlemi
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer',
            'selected_subjects' => 'required|array',
        ]);

        $exam = Exam::create([
            'name' => $request->name,
            'duration' => $request->duration,
        ]);

        $exam->subjects()->attach($request->selected_subjects);

        return redirect()->route('exams.index')->with('success', 'Sınav başarıyla oluşturuldu!');
    }

}
