<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function index(){
        return view('student.calendar.index');
    }
    public function events()
    {
        $events = \App\Models\CalendarEvent::where('user_id', auth()->id())
            ->get(['id', 'title', 'start', 'end', 'backgroundColor', 'borderColor', 'textColor']);

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $event = CalendarEvent::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'backgroundColor' => $request->backgroundColor,
            'borderColor' => $request->borderColor,
            'textColor' => $request->textColor,
        ]);

        return response()->json(['success' => true, 'event' => $event]);
    }

    public function destroy($id)
    {
        $event = CalendarEvent::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Event not found'], 404);
        }

        $event->delete();
        return response()->json(['success' => true]);
    }

    public function destroyAll()
    {
        $deleted = CalendarEvent::where('user_id', auth()->id())->delete();
        return response()->json(['success' => true, 'count' => $deleted]);
    }
}
