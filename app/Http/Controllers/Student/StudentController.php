<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\StudentExamAnalysis;
use App\Models\Note;
use App\Models\Task;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get exam statistics
        $totalExams = Exam::count();
        $completedExams = Exam::whereHas('studentAnswers', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
        $totalNotes = Note::where('user_id', $user->id)->count();
        $totalTasks = Task::where('user_id', $user->id)->count();

        // Get exam analysis data for charts
        $examAnalyses = \App\Models\StudentProgress::where('user_id', $user->id)
            ->with('exam')
            ->orderBy('created_at', 'desc')
            ->take(7)
            ->get();

        // Get tasks for the todo list
        $tasks = Task::where('user_id', $user->id)
            ->orderBy('day', 'asc')
            ->get();

        // Get calendar events
        $calendarEvents = CalendarEvent::where('user_id', $user->id)
            ->get()
            ->map(function ($event) {
                return [
                    'title' => $event->title,
                    'start' => $event->start,
                    'end' => $event->end,
                    'backgroundColor' => $event->backgroundColor,
                    'borderColor' => $event->borderColor,
                    'textColor' => $event->textColor
                ];
            });

        return view('student.index', compact(
            'totalExams',
            'completedExams',
            'totalNotes',
            'totalTasks',
            'examAnalyses',
            'tasks',
            'calendarEvents'
        ));
    }
}
