@extends('student.layouts.app')
<!-- exam.store route'u JS'e taşımak için -->
@section('title', 'Sınavlar')

@section('content')
    <div class="container">
        <h3>Sınavlarım</h3>
        <div class="row">
            @forelse($exams as $exam)
                <div class="col-md-3">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $exam->name }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Süre: {{ $exam->duration }} dakika</p>
                            <a href="{{ route('student.exams.start', $exam->id) }}" class="btn btn-primary">Sınava Başla</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>Henüz tanımlı bir sınav yok.</p>
                </div>
            @endforelse
        </div>    </div>
@endsection
