<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentExamAnalysis;

class StudentAnalysisController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $analyses = StudentExamAnalysis::with('exam') // ilişkili exam adı lazımsa
        ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($analyses);
    }
}
