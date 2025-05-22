<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $tasksByDay = Task::where('user_id', Auth::id())
            ->orderBy('day')
            ->get()
            ->groupBy('day');
        return view('student.workschedule.index',compact('tasksByDay'));
    }
    public function store (Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|string',
            'title'=>'required|string',
            'subject'=>'required|string',
            'duration'=>'required|integer',
        ]);
        $validated['user_id'] = Auth::id();
        Task::create($validated);
        return redirect()->back()->with('success','Görev başarıyla eklendi!');
    }
    // Görev sil
    public function destroy(Task $task)
    {
        if ($task->user_id === Auth::id()) {
            $task->delete();
        }

        return redirect()->back()->with('success', 'Görev silindi!');
    }

    // Tamamlanma durumu değiştir
    public function toggleComplete(Task $task)
    {
        if ($task->user_id === Auth::id()) {
            $task->is_completed = !$task->is_completed;
            $task->save();
        }

        return redirect()->back();
    }
}
