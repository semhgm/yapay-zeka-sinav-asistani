@extends('student.layouts.app')

@section('title', 'Bildirimler')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Timeline -->
                    <div class="timeline">

                        @php
                            $currentDate = null;
                        @endphp

                        @foreach($notifications as $note)
                            @php
                                $dateLabel = $note->created_at->format('d M. Y');
                            @endphp

                            @if ($currentDate !== $dateLabel)
                                <!-- Yeni bir tarih etiketi göster -->
                                <div class="time-label">
                                    <span class="bg-info">{{ $dateLabel }}</span>
                                </div>
                                @php $currentDate = $dateLabel; @endphp
                            @endif

                            <div>
                                <i class="fas {{ $note->type === 'exam' ? 'fa-pen-alt bg-blue' : 'fa-file-alt bg-green' }}"></i>
                                <div class="timeline-item">
                                <span class="time">
                                    <i class="fas fa-clock"></i> {{ $note->created_at->format('H:i') }}
                                </span>
                                    <h3 class="timeline-header">
                                        {{ $note->title }}
                                    </h3>
                                    @if($note->description)
                                        <div class="timeline-body">
                                            {{ $note->description }}
                                        </div>
                                    @endif
                                    <div class="timeline-footer">
                                        @if(!$note->is_read)
                                            <form action="{{ route('student.notifications.read', $note->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Okundu</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Bitiş -->
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
