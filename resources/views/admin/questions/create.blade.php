@extends('admin.layouts.app')

@section('title', 'Yeni Soru Ekle')

@section('content')
    <div class="container">
        <h1>{{ $subject->name }} - Yeni Soru Ekle</h1>

        <form action="{{ route('admin.exams.subjects.questions.store', [$examId, $subject->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Soru Metni --}}
            <div class="form-group mb-3">
                <label for="question_text">Soru Metni</label>
                <textarea name="question_text" id="question_text" class="form-control" rows="4" required>{{ old('question_text') }}</textarea>
            </div>

            {{-- Soru Resmi (Varsa) --}}
            <div class="form-group mb-3">
                <label for="image">Soru Resmi (Opsiyonel)</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>

            {{-- Şıklar --}}
            <div class="form-group mb-3">
                <label>Şıklar</label>

                @foreach(['A', 'B', 'C', 'D', 'E'] as $choice)
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="correct_answer" value="{{ $choice }}">
                            </div>
                        </div>
                        <input type="text" name="choices[{{ $choice }}]" class="form-control" placeholder="{{ $choice }} Şıkkı">
                    </div>
                @endforeach
                <small class="form-text text-muted">Doğru şıkkı seçmeyi unutma!</small>
            </div>

            {{-- Sıra Numarası (İsteğe Bağlı) --}}
            <div class="form-group mb-3">
                <label for="order_number">Sıra Numarası (Opsiyonel)</label>
                <input type="number" name="order_number" id="order_number" class="form-control" value="{{ old('order_number') }}">
            </div>

            {{-- Kaydet Butonu --}}
            <button type="submit" class="btn btn-success">Soru Ekle</button>
        </form>
    </div>
@endsection
