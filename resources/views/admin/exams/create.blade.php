@extends('admin.layouts.app')

@section('title', 'Yeni Sınav Ekle')

@section('content')
    <div class="container">
        <h1>Yeni Sınav Ekle</h1>

        <form action="{{ route('admin.exams.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Sınav Adı</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="duration">Sınav Süresi (Dakika)</label>
                <input type="number" class="form-control" id="duration" name="duration" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Kaydet</button>
        </form>
    </div>
@endsection
