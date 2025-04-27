@extends('admin.layouts.app')

@section('title', 'Konu Düzenle')

@section('content')
    <div class="container">
        <h1>Konu Düzenle</h1>

        <form action="{{ route('admin.topics.update', $topic->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Konu Adı</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $topic->name) }}" required>
            </div>

            <button type="submit" class="btn btn-success">Güncelle</button>
        </form>
    </div>
@endsection
