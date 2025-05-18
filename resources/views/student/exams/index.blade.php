@extends('student.layouts.app')
<!-- exam.store route'u JS'e taşımak için -->
@section('title', 'Sınavlar')

@section('content')
    <div class="container">
        <h3>Sınavlarım</h3>
        <div class="row">
            @forelse($exams as $exam)
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $exam->name }}</h5>
                            <p class="card-text">Süre: {{ $exam->duration }} dakika</p>
                            <a href="{{ route('student.exams.start', $exam->id) }}" class="btn btn-primary">Sınava Başla</a>                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>Henüz tanımlı bir sınav yok.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
