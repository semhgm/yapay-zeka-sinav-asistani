@extends('admin.layouts.app')

@section('title', $exam->name . ' - Dersler')

@section('content')
    <div class="container">
        <h1>{{ $exam->name }} - Dersler</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.exams.subjects.create', $exam->id) }}" class="btn btn-primary mb-3">Yeni Ders Ekle</a>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ders Adı</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($subjects as $subject)
                <tr>
                    <td>{{ $subject->id }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>
                        <a href="{{ route('admin.exams.subjects.edit', [$exam->id, $subject->id]) }}" class="btn btn-warning btn-sm">Düzenle</a>

                        <form action="{{ route('admin.exams.subjects.destroy', [$exam->id, $subject->id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğine emin misin?')">Sil</button>
                        </form>

                        <a href="{{ route('admin.exams.subjects.questions.index', [$exam->id, $subject->id]) }}" class="btn btn-info btn-sm">Soruları Yönet</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
