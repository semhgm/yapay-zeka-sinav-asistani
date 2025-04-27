@extends('admin.layouts.app')

@section('title', 'Sınav Düzenle')

@section('content')
    <div class="container">
        <h1>Sınavı Düzenle</h1>

        <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Sınav Adı</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $exam->name }}" required>
            </div>

            <div class="form-group">
                <label for="duration">Sınav Süresi (Dakika)</label>
                <input type="number" class="form-control" id="duration" name="duration" value="{{ $exam->duration }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Güncelle</button>
        </form>
    </div>
@endsection
