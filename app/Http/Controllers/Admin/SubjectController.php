<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{
    // Derslerin listelendiği sayfa (görsel HTML için)
    public function index(Exam $exam)
    {
        return view('admin.exams.subjects.index', compact('exam'));
    }

    // DataTables için JSON endpoint
    public function ajaxList(Exam $exam)
    {
        return DataTables::of($exam->subjects()->select(['id', 'name']))
            ->addColumn('detail', function ($subject) use ($exam) {
                return '
                    <button class="btn btn-warning btn-sm editSubject" data-id="' . $subject->id . '" data-name="' . $subject->name . '">Düzenle</button>
                    <button class="btn btn-danger btn-sm deleteSubject" data-id="' . $subject->id . '">Sil</button>
                    <a href="/admin/exams/' . $exam->id . '/subjects/' . $subject->id . '/questions" class="btn btn-info btn-sm">Soruları Yönet</a>
                ';
            })
            ->rawColumns(['detail'])
            ->make(true);
    }

    // Yeni ders ekle (AJAX)
    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject = $exam->subjects()->create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'subject' => $subject,
        ]);
    }

    // Ders güncelleme (AJAX)
    public function update(Request $request, Exam $exam, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'subject' => $subject,
        ]);
    }

    // Ders silme (AJAX)
    public function destroy(Exam $exam, Subject $subject)
    {
        $subject->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ders başarıyla silindi!',
        ]);
    }
}
