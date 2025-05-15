<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\TopicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [IndexController::class, 'index'])->name('index');

// Admin paneli
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return view('admin.index');
    })->name('index');

    // Exams
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
    Route::get('/exams/{exam}', [ExamController::class, 'show'])->name('exams.show');
    Route::get('/exams/{exam}/edit', [ExamController::class, 'edit'])->name('exams.edit');
    Route::put('/exams/{exam}', [ExamController::class, 'update'])->name('exams.update');
    Route::delete('/exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');
    Route::get('/exams-list', [ExamController::class, 'list'])->name('exams.list');

    // Subjects (Exam altına bağlı)
    Route::get('/exams/{exam}/subjects', [SubjectController::class, 'index'])->name('exams.subjects.index');
    Route::get('/exams/{exam}/subjects/create', [SubjectController::class, 'create'])->name('exams.subjects.create');
    Route::post('/exams/{exam}/subjects', [SubjectController::class, 'store'])->name('exams.subjects.store');
    Route::get('/exams/{exam}/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('exams.subjects.edit');
    Route::put('/exams/{exam}/subjects/{subject}', [SubjectController::class, 'update'])->name('exams.subjects.update');
    Route::delete('/exams/{exam}/subjects/{subject}', [SubjectController::class, 'destroy'])->name('exams.subjects.destroy');
    Route::get('/exams/{exam}/subjects/subjects-list', [SubjectController::class, 'ajaxList'])->name('exams.subjects.list');

    // Questions (Subject altına bağlı)
    Route::get('/exams/{exam}/subjects/{subject}/questions', [QuestionController::class, 'index'])->name('exams.subjects.questions.index');
    Route::get('/exams/{exam}/subjects/{subject}/questions/create', [QuestionController::class, 'create'])->name('exams.subjects.questions.create');
    Route::post('/exams/{exam}/subjects/{subject}/questions', [QuestionController::class, 'store'])->name('exams.subjects.questions.store');
    Route::get('/exams/{exam}/subjects/{subject}/questions/{question}', [QuestionController::class, 'show'])->name('exams.subjects.questions.show');
    Route::get('/exams/{exam}/subjects/{subject}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('exams.subjects.questions.edit');
    Route::put('/exams/{exam}/subjects/{subject}/questions/{question}', [QuestionController::class, 'update'])->name('exams.subjects.questions.update');
    Route::delete('/exams/{exam}/subjects/{subject}/questions/{question}', [QuestionController::class, 'destroy'])->name('exams.subjects.questions.destroy');

    // Topics (bağımsız)
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    Route::put('/topics/{topic}', [TopicController::class, 'update'])->name('topics.update');
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');
});
