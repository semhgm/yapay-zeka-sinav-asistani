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
            {{-- Konu Seçimi --}}
            <div class="form-group mb-3">
                <label for="topics">Bu Soru Hangi Konulara Ait?</label>
                <select id="topics" name="topics[]" multiple class="form-control" required>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Birden fazla konu seçebilirsiniz. (Arama da yapabilirsiniz.)</small>
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
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <style>
        .choices__inner {
            min-height: 45px;
            border-radius: 0.5rem;
            padding: 8px 12px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            font-size: 0.95rem;
        }
        .choices__list--multiple .choices__item {
            background-color: #0d6efd;
            color: #fff;
            border-radius: 0.75rem;
            padding: 5px 10px;
            margin: 3px;
            font-size: 0.85rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const topicSelect = document.getElementById('topics');
            new Choices(topicSelect, {
                removeItemButton: true,
                placeholderValue: 'Konuları seçiniz',
                searchPlaceholderValue: 'Konu ara...',
                noResultsText: 'Konu bulunamadı',
                itemSelectText: '',
                shouldSort: false,
            });
        });
    </script>
@endpush

