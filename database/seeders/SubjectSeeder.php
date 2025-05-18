<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $turkce = ['Türkçe'];
        $sosyal = ['Tarih', 'Coğrafya', 'Felsefe', 'Din Kültürü'];
        $matematik = ['Temel Matematik'];
        $fen = ['Fizik', 'Kimya', 'Biyoloji'];

        $exam = Exam::where('name', 'TYT Genel Deneme 01')->first();

        if ($exam) {
            foreach (array_merge($turkce, $sosyal, $matematik, $fen) as $subjectName) {
                Subject::firstOrCreate([
                    'exam_id' => $exam->id,
                    'name' => $subjectName,
                ]);
            }
        }
    }
}


