@extends('admin.layouts.app')

@section('title', $subject->name . ' - Sorular')

@section('content')
    <div class="container">
        <h1>{{ $subject->name }} - Soru Listesi</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.exams.subjects.questions.create', [$examId, $subject->id]) }}" class="btn btn-primary mb-3">Yeni Soru Ekle</a>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Soru Metni</th>
                <th>Doğru Cevap</th>
                <th>Sıra No</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ Str::limit($question->question_text, 50) }}</td>
                    <td>{{ $question->correct_answer }}</td>
                    <td>{{ $question->order_number }}</td>
                    <td>
                        <a href="{{ route('admin.exams.subjects.questions.update', [$examId, $subject->id, $question->id]) }}" class="btn btn-warning btn-sm">Düzenle</a>

                        <form action="{{ route('admin.exams.subjects.questions.destroy', [$examId, $subject->id, $question->id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğine emin misin?')">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
