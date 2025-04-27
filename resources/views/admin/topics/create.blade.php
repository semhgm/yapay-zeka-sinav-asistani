@extends('admin.layouts.app')

@section('title', 'Yeni Konu Ekle')

@section('content')
    <div class="container">
        <h1>Yeni Konu Ekle</h1>

        <form action="{{ route('admin.topics.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="name">Konu Adı</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Kaydet</button>
        </form>
    </div>
@endsection
