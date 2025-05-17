<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExamController extends Controller
{
    // Sınav listesi sayfası
    public function index()
    {
        return view('admin.exams.index');
    }

    // DataTables için JSON liste
    public function list()
    {
        $exams = Exam::query();

        return DataTables::of($exams)
            ->addColumn('detail', function ($exam) {
                return '
                    <button class="btn btn-warning btn-sm editExam" data-id="' . $exam->id . '" data-name="' . $exam->name . '" data-duration="' . $exam->duration . '">Düzenle</button>
                    <a href="/admin/exams/' . $exam->id . '/subjects" class="btn btn-info btn-sm">Dersleri yönet</a>
                    <button class="btn btn-danger btn-sm deleteExam" data-id="' . $exam->id . '">Sil</button>
                ';
            })
            ->rawColumns(['detail'])
            ->make(true);
    }

    // Sınav oluştur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
        ]);

        $exam = Exam::create($request->only('name', 'duration'));

        return response()->json([
            'success' => true,
            'exam' => $exam,
        ]);
    }

    // Sınav düzenleme formu (kullanılmıyorsa kaldırılabilir)
    public function edit(Exam $exam)
    {
        return view('admin.exams.edit', compact('exam'));
    }

    // Sınav güncelle
    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
        ]);

        $exam->update($request->only('name', 'duration'));

        return response()->json([
            'success' => true,
            'exam' => $exam,
        ]);
    }

    // Sınav sil
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sınav başarıyla silindi',
        ]);
    }
}
