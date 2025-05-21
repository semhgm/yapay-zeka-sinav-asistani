<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Student\NotesController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Student\SExamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [IndexController::class, 'index'])->name('index');



Route::get('/login',[LoginController::class,'showLoginForm'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login.submit');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');
// Admin paneli
// Admin paneli
Route::middleware('auth','role:superadmin')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Exams
    Route::prefix('exams')->name('exams.')->group(function () {

        Route::get('/', [ExamController::class, 'index'])->name('index');
        Route::get('/create', [ExamController::class, 'create'])->name('create');
        Route::post('/', [ExamController::class, 'store'])->name('store');
        Route::get('/{exam}/edit', [ExamController::class, 'edit'])->name('edit');
        Route::put('/{exam}', [ExamController::class, 'update'])->name('update');
        Route::delete('/{exam}', [ExamController::class, 'destroy'])->name('destroy');
        Route::get('/list', [ExamController::class, 'list'])->name('list');

        // Subjects (Exam altına bağlı)
        Route::prefix('/{exam}/subjects')->name('subjects.')->group(function () {
            Route::get('/', [SubjectController::class, 'index'])->name('index');
            Route::get('/create', [SubjectController::class, 'create'])->name('create');
            Route::post('/', [SubjectController::class, 'store'])->name('store');
            Route::get('/{subject}/edit', [SubjectController::class, 'edit'])->name('edit');
            Route::put('/{subject}', [SubjectController::class, 'update'])->name('update');
            Route::delete('/{subject}', [SubjectController::class, 'destroy'])->name('destroy');
            Route::get('/subjects-list', [SubjectController::class, 'ajaxList'])->name('list');

            // Questions (Subject altına bağlı)
            Route::prefix('{subject}/questions')->name('questions.')->group(function () {
                Route::get('/ajax-list', [QuestionController::class, 'ajaxList'])->name('ajaxList');
                Route::get('/', [QuestionController::class, 'index'])->name('index');
                Route::get('/create', [QuestionController::class, 'create'])->name('create');
                Route::post('/', [QuestionController::class, 'store'])->name('store');
                Route::get('/{question}', [QuestionController::class, 'show'])->name('show');
                Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('edit');
                Route::put('/{question}', [QuestionController::class, 'update'])->name('update');
                Route::delete('/{question}', [QuestionController::class, 'destroy'])->name('destroy');
            });
        });
    });

    // Topics
    Route::prefix('topics')->name('topics.')->group(function () {
        Route::get('/', [TopicController::class, 'index'])->name('index');
        Route::get('/ajax-list', [TopicController::class, 'ajaxList'])->name('ajaxList');
        Route::post('/', [TopicController::class, 'store'])->name('store');
        Route::put('/{topic}', [TopicController::class, 'update'])->name('update');
        Route::delete('/{topic}', [TopicController::class, 'destroy'])->name('destroy');
    });

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/users-list', [UserController::class, 'ajaxList'])->name('ajax');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});
Route::middleware('auth','role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/', [TeacherController::class, 'index'])->name('index');

});
Route::middleware('auth','role:student')->prefix('student')->name('student.')->group(function () {

    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('/exams',[SExamController::class,'index'])->name('exams.index');
    Route::get('/exams/{exam}/start', [SExamController::class, 'start'])->name('exams.start');
    Route::post('/exams/{exam}/submit', [SExamController::class, 'submit'])->name('exams.submit');

    Route::get('analyses', [SExamController::class, 'analysisList'])->name('exams.analysis');
    Route::get('/analyses/{exam}', [SExamController::class, 'analysisDetail'])->name('exams.analysis.detail');
    // PDF olarak dışa aktar ve AI API'ye gönder
    Route::post('/ai-analysis', [SExamController::class, 'aiAnalysis'])->name('ai.analysis');

    Route::prefix('/notes')->name('notes.')->group(function () {
        Route::get('/', [NotesController::class, 'index'])->name('index');
        Route::post('/', [NotesController::class, 'store'])->name('store');
        Route::get('/{note}', [NotesController::class, 'destroy'])->name('destroy');
    });

});

