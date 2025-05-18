@extends('student.layouts.app')

@section('title', 'Sınav Başla')

@section('content')
    <div class="container">
        <h3 class="mb-3">{{ $exam->name }}</h3>

        <div class="alert alert-warning text-center fw-bold">
            <i class="fas fa-clock me-2"></i>
            <span id="timeLeft">Kalan süre: {{ $duration }} dakika</span>
        </div>

        <form method="POST" action="{{ route('student.exams.submit', $exam->id) }}" id="examForm">
            @csrf
            <div id="questionContainer">
                @foreach($questions as $index => $question)
                    <div class="card question-box mb-4" data-index="{{ $index }}" style="{{ $index !== 0 ? 'display:none;' : '' }}">
                        <div class="card-header bg-primary text-white">
                            Soru {{ $index + 1 }}
                        </div>
                        <div class="card-body">
                            <p>{{ $question->question_text }}</p>

                            @if($question->image_path)
                                <img src="{{ asset('storage/' . $question->image_path) }}"
                                     alt="Soru Görseli" class="img-fluid rounded mb-3 border" style="max-height: 300px;">
                            @endif

                            @foreach($question->choices as $choice)
                                <div class="form-check mb-2">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="answers[{{ $question->id }}]"
                                           value="{{ $choice->id }}"
                                           id="q{{ $question->id }}_{{ $choice->id }}">
                                    <label class="form-check-label" for="q{{ $question->id }}_{{ $choice->id }}">
                                        {{ $choice->choice_text }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary" id="prevBtn">
                    <i class="fas fa-arrow-left"></i> Geri
                </button>
                <button type="button" class="btn btn-outline-secondary" id="nextBtn">
                    İleri <i class="fas fa-arrow-right"></i>
                </button>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle me-1"></i> Sınavı Bitir
                </button>
            </div>
        </form>
    </div>

    <script>
        const totalQuestions = {{ $questions->count() }};
        let currentIndex = 0;

        function showQuestion(index) {
            $('.question-box').hide();
            $('.question-box[data-index="' + index + '"]').fadeIn();
        }

        $('#nextBtn').click(() => {
            if (currentIndex < totalQuestions - 1) {
                currentIndex++;
                showQuestion(currentIndex);
            }
        });

        $('#prevBtn').click(() => {
            if (currentIndex > 0) {
                currentIndex--;
                showQuestion(currentIndex);
            }
        });

        let seconds = {{ $duration * 60 }};
        const timer = setInterval(() => {
            seconds--;

            const minutesLeft = Math.floor(seconds / 60);
            const secondsLeft = seconds % 60;

            $('#timeLeft').text(`Kalan süre: ${minutesLeft} dakika ${secondsLeft} saniye`);

            if (seconds <= 0) {
                clearInterval(timer);
                $('#examForm').submit();
            }
        }, 1000);
    </script>
@endsection
