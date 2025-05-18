<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


        public function run(): void
    {
        $exams = [
            ['name' => 'TYT Genel Deneme 01', 'duration' => 165],
            ['name' => 'TYT Genel Deneme 02', 'duration' => 165],
            ['name' => 'Türkçe Denemesi', 'duration' => 90],
        ];

        foreach ($exams as $exam) {
            Exam::firstOrCreate(['name' => $exam['name']], ['duration' => $exam['duration']]);
        }
    }
}
