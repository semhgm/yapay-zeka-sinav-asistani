@extends('admin.layouts.app')

@section('title', 'Ders Ekle')

@section('content')
    <div class="container">
        <h1>{{ $exam->name }} - Ders Ekle</h1>

        <form action="{{ route('admin.exams.subjects.store', $exam->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Ders Adı</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Kaydet</button>
        </form>
    </div>
@endsection
