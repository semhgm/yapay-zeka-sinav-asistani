@extends('admin.layouts.app')

@section('title', 'Ders Düzenle')

@section('content')
    <div class="container">
        <h1>{{ $exam->name }} - Ders Düzenle</h1>

        <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Ders Adı</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $subject->name }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Güncelle</button>
        </form>
    </div>
@endsection
