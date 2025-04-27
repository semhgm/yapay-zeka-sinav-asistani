@extends('admin.layouts.app')

@section('title', 'Sınavlar')

@section('content')
    <div class="container">
        <h1>Sınavlar</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.exams.create') }}" class="btn btn-primary mb-3">Yeni Sınav Ekle</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Adı</th>
                <th>Süre (Dakika)</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($exams as $exam)
                <tr>
                    <td>{{ $exam->id }}</td>
                    <td>{{ $exam->name }}</td>
                    <td>{{ $exam->duration }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn btn-warning btn-sm">Düzenle</a>

                        <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Emin misin?')">Sil</button>
                        </form>

                        <a href="{{ route('admin.exams.subjects.index', $exam->id) }}" class="btn btn-info btn-sm">
                            Dersleri Yönet
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
