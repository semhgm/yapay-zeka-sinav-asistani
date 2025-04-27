<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index($examId, Subject $subject)
    {
        $questions = $subject->questions;
        return view('admin.questions.index', compact('examId', 'subject', 'questions'));
    }


    public function create($examId, Subject $subject)
    {
        return view('admin.questions.create', compact('examId', 'subject'));
    }

    public function store(Request $request, $examId, Subject $subject)
    {
        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|max:255',
            'order_number' => 'nullable|integer',
        ]);

        $question = $subject->questions()->create([
            'question_text' => $request->input('question_text'),
            'correct_answer' => $request->input('correct_answer'),
            'order_number' => $request->input('order_number'),
        ]);

        return redirect()->route('admin.exams.subjects.questions.index', [$examId, $subject->id])
            ->with('success', 'Soru başarıyla eklendi!');
    }


    public function edit($examId, Subject $subject, Question $question)
    {
        return view('admin.questions.edit', compact('examId', 'subject', 'question'));
    }

    public function show($examId, Subject $subject, Question $question)
    {
        return redirect()->route('admin.exams.subjects.questions.index', [$examId, $subject->id]);
    }
    public function update(Request $request, $examId, Subject $subject, Question $question)
    {
        // Validasyon (her zamanki gibi)
        $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|max:255',
            'order_number' => 'nullable|integer',
            'choices' => 'required|array', // Şıklar zorunlu
            'choices.*' => 'required|string', // Her bir şık zorunlu
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Resim varsa validasyon
        ]);

        // Soru güncellemesi
        $updateData = [
            'question_text' => $request->input('question_text'),
            'correct_answer' => $request->input('correct_answer'),
            'order_number' => $request->input('order_number'),
        ];

        // Eğer yeni resim seçilmişse
        if ($request->hasFile('image')) {
            // Mevcut resmi silebilirsin (isteğe bağlı)
            if ($question->image_path) {
                \Storage::delete($question->image_path);
            }

            // Yeni resmi yükle
            $path = $request->file('image')->store('questions'); // public/questions içine kaydeder
            $updateData['image_path'] = $path;
        }

        // Soruyu güncelle
        $question->update($updateData);

        // Şıkları önce silip sonra yeniden oluşturuyoruz (daha temiz yöntem)
        $question->choices()->delete();

        foreach ($request->input('choices') as $label => $choiceText) {
            $question->choices()->create([
                'choice_label' => $label,
                'choice_text' => $choiceText,
            ]);
        }

        return redirect()->route('admin.exams.subjects.questions.index', [$examId, $subject->id])
            ->with('success', 'Soru başarıyla güncellendi!');
    }


    public function destroy($examId, Subject $subject, Question $question)
    {
        $question->delete();

        return redirect()->route('admin.exams.subjects.questions.index', [$examId, $subject->id])
            ->with('success', 'Soru başarıyla silindi!');
    }

}
