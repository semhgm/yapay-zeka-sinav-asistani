<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::latest()->get();
        return view('admin.exams.index', compact('exams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
        ]);

        $exam = Exam::create($request->only('name', 'duration'));

        return response()->json([
            'success' => true,
            'exam' => $exam
        ]);
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

        return response()->json([
            'success' => true,
            'exam' => $exam
        ]);
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sınav başarıyla silindi'
        ]);
    }
    public function list()
    {
        $exam = Exam::query();

        return DataTables::of($exam)
            ->addColumn('detail', function ($exam) {
                return '
        <button class="btn btn-warning btn-sm editExam"
                data-id="' . $exam->id . '"
                data-name="' . $exam->name . '"
                data-duration="' . $exam->duration . '">
            Düzenle
        </button>
        <a href="/admin/exams/' . $exam->id . '/subjects"
           class="btn btn-info btn-sm">
           Ders Ekle
        </a>
        <button class="btn btn-danger btn-sm deleteExam"
                data-id="' . $exam->id . '">
            Sil
        </button>
    ';
            })
            ->rawColumns(['detail'])
            ->make(true);
    }
}
