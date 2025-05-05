<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StudentProgress;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Exam;

class FullMobilTestSeeder extends Seeder
{
    public function run()
    {
        // Rolleri ekle
        $admin = Role::create(['name' => 'superadmin']);
        $hoca = Role::create(['name' => 'teacher']);
        $ogrenci = Role::create(['name' => 'student']);

        // Kullanıcıları ekle
        $adminUser = User::create([
            'name' => 'Admin Abi',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456')
        ]);
        $teacherUser = User::create([
            'name' => 'Mehmet Hoca',
            'email' => 'hoca@example.com',
            'password' => Hash::make('123456')
        ]);
        $studentUser = User::create([
            'name' => 'Ayşe Öğrenci',
            'email' => 'ogrenci@example.com',
            'password' => Hash::make('123456')
        ]);

        // Rollerle ilişkilendir
        $adminUser->roles()->attach($admin->id);
        $teacherUser->roles()->attach($hoca->id);
        $studentUser->roles()->attach($ogrenci->id);

        $exam1 = Exam::create([
            'name' => 'Yapay Zeka Deneme Sınavı',
            'duration' => 60
        ]);StudentProgress::create([
        'user_id' => $studentUser->id,
        'exam_id' => $exam1->id,
        'correct_count' => 8,
        'wrong_count' => 2
    ]);


    }
}
