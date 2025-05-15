@extends('admin.layouts.app')
<!-- exam.store route'u JS'e taşımak için -->
@section('title', 'Sınavlar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Card Başlangıç -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Sınavlar</h3>
                        <button id="addExamBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#examModal">
                            <i class="fas fa-plus-circle"></i> Yeni Sınav Ekle
                        </button>
                    </div>

                    <div class="card-body">
                        <table id="examTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Adı</th>
                                <th>Süre (Dakika)</th>
                                <th>Detay</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- Card Bitiş -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="examModal" tabindex="-1" aria-labelledby="examModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="examForm">
                @csrf
                <input type="hidden" name="id" id="examId">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="examModalLabel">Yeni Sınav Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="examName">Sınav Adı</label>
                            <input type="text" class="form-control" id="examName" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="examDuration">Süre (Dakika)</label>
                            <input type="number" class="form-control" id="examDuration" name="duration" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table = $('#examTable').DataTable({
            ajax: '{{ route("admin.exams.list") }}',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'duration' },
                { data: 'detail' },
            ]
        });

            // Bootstrap 5 modal objesini al
            const examModalEl = document.getElementById('examModal');
            const examModal = new bootstrap.Modal(examModalEl);

            // Route store URL'yi meta'dan al
            const storeUrl = document.querySelector('meta[name="route-exams-store"]').getAttribute('content');

            // Form Submit
            $(document).on('submit', '#examForm', function (e) {
                e.preventDefault();
                console.log("Form gönderildi");

                let id = $('#examId').val();
                let url = id ? `/admin/exams/${id}` : storeUrl;
                let method = 'POST';
                let formData = $(this).serialize();

                if (id) {
                    formData += '&_method=PUT';
                }

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function () {
                        examModal.hide();
                        $('#examForm')[0].reset();
                        $('#examId').val('');
                        $('#examModalLabel').text('Yeni Sınav Ekle');
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert("Bir hata oluştu.");
                    }
                });
            });

            // Yeni Sınav butonu
            $('#addExamBtn').on('click', function () {
                $('#examForm')[0].reset();
                $('#examId').val('');
                $('#examModalLabel').text('Yeni Sınav Ekle');
                examModal.show();
            });

            // Düzenle butonu
            $(document).on('click', '.editExam', function () {
                $('#examId').val($(this).data('id'));
                $('#examName').val($(this).data('name'));
                $('#examDuration').val($(this).data('duration'));
                $('#examModalLabel').text('Sınavı Düzenle');
                examModal.show();
            });

            // Sil butonu
            $(document).on('click', '.deleteExam', function () {
                if (confirm('Emin misiniz?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `/admin/exams/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function () {
                            table.ajax.reload();
                        },
                        error: function () {
                            alert("Silme işlemi başarısız.");
                        }
                    });
                }
            });

            // Modal kapandığında formu sıfırla
            examModalEl.addEventListener('hidden.bs.modal', function () {
                $('#examForm')[0].reset();
                $('#examId').val('');
                $('#examModalLabel').text('Yeni Sınav Ekle');
            });

    </script>
@endpush
