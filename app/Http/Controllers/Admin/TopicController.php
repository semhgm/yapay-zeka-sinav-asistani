<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TopicController extends Controller
{
    public function index()
    {
        return view('admin.topics.index');
    }

    public function ajaxList()
    {
        $topics = Topic::query();

        return DataTables::of($topics)
            ->addColumn('actions', function ($topic) {
                return '
                    <button class="btn btn-warning btn-sm editTopic"
                        data-id="' . $topic->id . '"
                        data-name="' . $topic->name . '">Düzenle</button>
                    <button class="btn btn-danger btn-sm deleteTopic"
                        data-id="' . $topic->id . '">Sil</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $topic = Topic::create($request->only('name'));

        return response()->json([
            'success' => true,
            'topic' => $topic,
        ]);
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $topic->update($request->only('name'));

        return response()->json([
            'success' => true,
            'topic' => $topic,
        ]);
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return response()->json([
            'success' => true,
            'message' => 'Konu silindi.',
        ]);
    }
}
