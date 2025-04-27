@extends('admin.layouts.app')

@section('title', 'Konu Listesi')

@section('content')
    <div class="container">
        <h1>Konu Listesi</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.topics.create') }}" class="btn btn-primary mb-3">Yeni Konu Ekle</a>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Konu Adı</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($topics as $topic)
                <tr>
                    <td>{{ $topic->id }}</td>
                    <td>{{ $topic->name }}</td>
                    <td>
                        <a href="{{ route('admin.topics.edit', $topic->id) }}" class="btn btn-warning btn-sm">Düzenle</a>
                        <form action="{{ route('admin.topics.destroy', $topic->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu konuyu silmek istediğine emin misin?')">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
