<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{



    public function index(Request $request)
    {
        $query = auth()->user()->notes();

        if ($request->filled('tag')) {
            $query->where('tag', 'like', '%' . $request->tag . '%');
        }

        $notes = $query->latest()->get();

        return view('student.notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable|string',
            'tag' => 'nullable|string|max:50',
            'pdf' => 'nullable|mimes:pdf|max:2048' // PDF max 2MB
        ]);

        $data = $request->only('title', 'content', 'tag');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('notes', 'public');
        }

        Note::create($data);

        return redirect()->back()->with('success', 'Not başarıyla eklendi.');
    }

    public function destroy($id)
    {
        $note = auth()->user()->notes()->findOrFail($id);

        if ($note->pdf_path && Storage::disk('public')->exists($note->pdf_path)) {
            Storage::disk('public')->delete($note->pdf_path);
        }

        $note->delete();
        return back()->with('success', 'Not silindi.');
    }
}
