<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Exam $exam)
    {
        $subjects = $exam->subjects()->get();
        return view('admin.exams.subjects.index', compact('exam', 'subjects'));
    }

    public function list()
    {
        $subjects = Subject::with('exam')->get();
        return view('admin.subjects.index', compact('subjects'));
    }
    public function create(Exam $exam)
    {
        return view('admin.exams.subjects.create', compact('exam'));
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $exam->subjects()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.exams.subjects.index', $exam->id)
            ->with('success', 'Ders başarıyla eklendi!');
    }

    public function edit(Exam $exam, Subject $subject)
    {
        return view('admin.exams.subjects.edit', compact('exam', 'subject'));
    }

    public function update(Request $request, Exam $exam, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.exams.subjects.index', $exam->id)
            ->with('success', 'Ders başarıyla güncellendi!');
    }

    public function destroy(Exam $exam, Subject $subject)
    {
        $subject->delete();

        return redirect()->route('admin.exams.subjects.index', $exam->id)
            ->with('success', 'Ders başarıyla silindi!');
    }
}
