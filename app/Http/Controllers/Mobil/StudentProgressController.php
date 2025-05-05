<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentProgress;


class StudentProgressController extends Controller
{

    public function show($user_id)
    {
        return StudentProgress::where('user_id', $user_id)->get();
    }
}
