<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'backgroundColor' => 'nullable|string|max:7',
            'borderColor' => 'nullable|string|max:7',
            'textColor' => 'nullable|string|max:7',
        ]);

        $event = CalendarEvent::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'backgroundColor' => $request->backgroundColor,
            'borderColor' => $request->borderColor,
            'textColor' => $request->textColor,
        ]);

        return response()->json($event);
    }

    public function update(Request $request, CalendarEvent $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'backgroundColor' => 'nullable|string|max:7',
            'borderColor' => 'nullable|string|max:7',
            'textColor' => 'nullable|string|max:7',
        ]);

        $event->update($request->all());

        return response()->json($event);
    }

    public function destroy(CalendarEvent $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
} 