<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\StudentAnswer;
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
    public function submit(Request $request, Exam $exam)
    {
        $user = auth()->user();
        $answers = $request->input('answers', []);

        $correctCount = 0;
        $wrongCount = 0;

        foreach ($exam->questions as $question) {
            $selectedChoiceId = $answers[$question->id] ?? null;

            // Kaydet
            \App\Models\StudentAnswer::create([
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'question_id' => $question->id,
                'selected_choice_id' => $selectedChoiceId,
                'given_answer' => $question->choices->where('id', $selectedChoiceId)->first()?->choice_label,
                'is_correct' => $selectedChoiceId
                    ? $question->choices->where('id', $selectedChoiceId)->first()?->choice_label === $question->correct_answer
                    : false,
            ]);

            if ($selectedChoiceId) {
                $selectedLabel = $question->choices->where('id', $selectedChoiceId)->first()?->choice_label;
                if ($selectedLabel === $question->correct_answer) {
                    $correctCount++;
                } else {
                    $wrongCount++;
                }
            }
        }

        // Öğrencinin genel performansı
        \App\Models\StudentProgress::updateOrCreate(
            ['user_id' => $user->id, 'exam_id' => $exam->id],
            ['correct_count' => $correctCount, 'wrong_count' => $wrongCount]
        );

        // TODO: Analiz ekranına yönlendir
        return redirect()->route('student.exams.analysis', $exam->id)
            ->with('success', 'Cevaplarınız kaydedildi ve analiz ediliyor!');
    }
    public function analysisList()
    {
        $user = auth()->user();
        $exams = Exam::whereHas('studentAnswers', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('student.exams.analysis', compact('exams'));
    }
    public function analysisDetail(Exam $exam)
    {
        $user = auth()->user();
        $answers = StudentAnswer::with(['question.topics'])
            ->where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->get();

        $correct = $answers->where('is_correct', true)->count();
        $wrong = $answers->where('is_correct', false)->count();
        $net = $correct - ($wrong / 4);

        return response()->json([
            'answers' => $answers,
            'correct' => $correct,
            'wrong' => $wrong,
            'net' => round($net, 2),
        ]);
    }
}
