@extends('admin.layouts.app')

@section('title', 'Soru Düzenle')

@section('content')
    <div class="container">
        <h1>{{ $subject->name }} - Soru Düzenle</h1>

        {{-- Başarı Mesajı --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.exams.subjects.questions.update', [$examId, $subject->id, $question->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Soru Metni --}}
            <div class="form-group mb-3">
                <label for="question_text">Soru Metni</label>
                <textarea name="question_text" id="question_text" class="form-control" rows="4" required>{{ old('question_text', $question->question_text) }}</textarea>
            </div>

            {{-- Var Olan Soru Resmi --}}
            @if($question->image_path)
                <div class="form-group mb-3">
                    <label>Mevcut Soru Resmi:</label><br>
                    <img src="{{ asset('storage/' . $question->image_path) }}" alt="Soru Resmi" style="max-width: 300px; height: auto; margin-bottom:10px;">
                </div>
            @endif

            {{-- Yeni Soru Resmi Yükle --}}
            <div class="form-group mb-3">
                <label for="image">Yeni Soru Resmi (Opsiyonel)</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>

            {{-- Şıklar --}}
            <div class="form-group mb-3">
                <label>Şıklar</label>
                @foreach(['A', 'B', 'C', 'D', 'E'] as $choice)
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="correct_answer" value="{{ $choice }}" {{ old('correct_answer', $question->correct_answer) == $choice ? 'checked' : '' }}>
                            </div>
                        </div>
                        <input type="text" name="choices[{{ $choice }}]" class="form-control" placeholder="{{ $choice }} Şıkkı"
                               value="{{ old('choices.' . $choice, $question->choices[$choice] ?? '') }}">
                    </div>
                @endforeach
                <small class="form-text text-muted">Doğru şıkkı seçmeyi unutma!</small>
            </div>

            {{-- Sıra Numarası --}}
            <div class="form-group mb-3">
                <label for="order_number">Sıra Numarası (Opsiyonel)</label>
                <input type="number" name="order_number" id="order_number" class="form-control" value="{{ old('order_number', $question->order_number) }}">
            </div>

            <button type="submit" class="btn btn-success">Güncelle</button>
        </form>
    </div>
@endsection
