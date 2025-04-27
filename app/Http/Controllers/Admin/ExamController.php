<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::latest()->get();
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        return view('admin.exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
        ]);

        Exam::create($request->only('name', 'duration'));

        return redirect()->route('admin.exams.index')->with('success', 'Sınav başarıyla oluşturuldu!');
    }

    public function edit(Exam $exam)
    {
        return view('admin.exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
        ]);

        $exam->update($request->only('name', 'duration'));

        return redirect()->route('admin.exams.index')->with('success', 'Sınav başarıyla güncellendi!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('admin.exams.index')->with('success', 'Sınav başarıyla silindi!');
    }
}
