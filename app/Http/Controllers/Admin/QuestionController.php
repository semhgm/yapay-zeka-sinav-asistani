<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class QuestionController extends Controller
{
    public function index($examId, Subject $subject)
    {
        $topics = Topic::all();
        return view('admin.questions.index', compact('examId', 'subject', 'topics'));
    }

    public function ajaxList($examId, Subject $subject)
    {
        $questions = $subject->questions()->with('topics')->get();

        return DataTables::of($questions)
            // Görselin tam asset yolu döndürülüyor
            ->addColumn('image_path', function ($q) {
                return $q->image_path ? asset('storage/' . $q->image_path) : null;
            })

            // İşlem butonları
            ->addColumn('actions', function ($q) use ($examId, $subject) {
                return '
                <button class="btn btn-warning btn-sm editQuestion"
                    data-id="' . $q->id . '"
                    data-text="' . e($q->question_text) . '"
                    data-correct="' . $q->correct_answer . '"
                    data-order="' . $q->order_number . '"
                    data-image="' . ($q->image_path ? asset('storage/' . $q->image_path) : '') . '">
                    Düzenle
                </button>
                <button class="btn btn-danger btn-sm deleteQuestion"
                    data-id="' . $q->id . '">Sil</button>
            ';
            })

            // Soru metnini kısaltıyoruz
            ->editColumn('question_text', fn($q) => \Str::limit($q->question_text, 80))

            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request, Exam $exam, Subject $subject)    {
        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|max:255',
            'order_number' => 'nullable|integer',
            'choices' => 'required|array',
            'topics' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $question = $subject->questions()->create([
            'question_text' => $request->question_text,
            'correct_answer' => $request->correct_answer,
            'order_number' => $request->order_number,
            'exam_id' => $exam->id, // 👈 BURAYI EKLE

        ]);

        foreach ($request->choices as $label => $text) {
            $question->choices()->create([
                'choice_label' => $label,
                'choice_text' => $text,
            ]);
        }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('questions', 'public');
            $question->update(['image_path' => $path]);
        }

        $question->topics()->attach($request->topics);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $examId, Subject $subject, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|max:255',
            'order_number' => 'nullable|integer',
            'choices' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        $question->update([
            'question_text' => $request->question_text,
            'correct_answer' => $request->correct_answer,
            'order_number' => $request->order_number,
        ]);

        // Yeni görsel varsa yükle, eskiyi sil
        if ($request->hasFile('image')) {
            if ($question->image_path) {
                \Storage::disk('public')->delete($question->image_path);
            }

            $path = $request->file('image')->store('questions', 'public');
            $updateData['image_path'] = $path;
        }
        $question->choices()->delete();

        foreach ($request->choices as $label => $text) {
            $question->choices()->create([
                'choice_label' => $label,
                'choice_text' => $text,
            ]);
        }

        if ($request->filled('topics')) {
            $question->topics()->sync($request->topics);
        }

        return response()->json(['success' => true]);
    }

    public function destroy($examId, Subject $subject, Question $question)
    {
        $question->choices()->delete();
        $question->topics()->detach();
        $question->delete();

        return response()->json(['success' => true]);
    }

    public function show($examId, Subject $subject, Question $question)
    {
        return response()->json($question->load('choices', 'topics'));
    }

    public function edit($examId, Subject $subject, Question $question)
    {
        return $this->show($examId, $subject, $question);
    }
}
