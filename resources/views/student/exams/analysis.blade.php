@extends('student.layouts.app')
@section('title', 'Sınav Analizleri')
<style>
    .modal-body table td, .modal-body table th {
        vertical-align: middle !important;
    }
</style>

@section('content')
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-chart-bar"></i> Sınav Analizleri</h3>
            </div>
            <div class="card-body">
                <table id="examTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sınav Adı</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $exam->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary show-analysis" data-id="{{ $exam->id }}">
                                    <i class="fas fa-eye"></i> Detay
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="analysisModal" tabindex="-1" aria-labelledby="analysisModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="analysisModalLabel"><i class="fas fa-chart-line"></i> Sınav Analizi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="analysisContent">
                    Yükleniyor...
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="analyzeWithAI"><i class="fas fa-robot"></i> Yapay Zeka ile Yorumla</button>
                    <a href="{{route('student.exams.analysis')}}" class="btn btn-secondary" data-dismiss="modal">Kapat</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('#examTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json'
                }
            });

            $(document).on('click', '.show-analysis', function () {
                const examId = $(this).data('id');
                $('#analysisModal').modal('show');
                $('#analysisContent').html('<div class="text-center p-4">Yükleniyor...</div>');

                $.get(`/student/analyses/${examId}`, function (data) {
                    let html = `<table class="table table-bordered table-sm">
                    <thead><tr>
                        <th>Soru</th>
                        <th>Konu(lar)</th>
                        <th>Cevabın</th>
                        <th>Doğru Cevap</th>
                        <th>Durum</th>
                    </tr></thead><tbody>`;

                    data.answers.forEach(ans => {
                        html += `<tr>
                        <td>${ans.question.question_text.substring(0, 60)}...</td>
                        <td>${ans.question.topics.map(t => `<span class="badge badge-info">${t.name}</span>`).join(' ')}</td>
                        <td>${ans.given_answer ?? '-'}</td>
                        <td>${ans.question.correct_answer}</td>
                        <td>${ans.is_correct ? '<span class="badge badge-success">Doğru</span>' : '<span class="badge badge-danger">Yanlış</span>'}</td>
                    </tr>`;
                    });

                    html += `</tbody></table>
                    <div class="alert alert-info text-center mt-3">
                        <strong>Toplam:</strong> ${data.answers.length} |
                        <strong>Doğru:</strong> ${data.correct} |
                        <strong>Yanlış:</strong> ${data.wrong} |
                        <strong>Net:</strong> ${data.net}
                    </div>`;

                    $('#analysisContent').html(html);
                });
            });

            $(document).on('click', '#analyzeWithAI', function () {
                alert("Yapay Zeka butonuna basıldı. API entegrasyonu buraya.");
            });
        });
    </script>
@endpush
