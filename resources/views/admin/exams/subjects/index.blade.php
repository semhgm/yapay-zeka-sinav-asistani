@extends('admin.layouts.app')

@section('title', $exam->name . ' - Dersler')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Card Başlangıç -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ $exam->name }} - Dersler</h3>
                        <button class="btn btn-primary" id="addSubjectBtn" data-bs-toggle="modal" data-bs-target="#subjectModal">
                            <i class="fas fa-plus-circle"></i> Yeni Ders Ekle
                        </button>
                    </div>

                    <div class="card-body">
                        <table id="subjectTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ders Adı</th>
                                <th>İşlemler</th>
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
    <div class="modal fade" id="subjectModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="subjectForm">
                @csrf
                <input type="hidden" id="subjectId" name="id">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="subjectModalLabel">Yeni Ders Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="subjectName" class="form-label">Ders Adı</label>
                            <input type="text" class="form-control" id="subjectName" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    @push('scripts')
        <script>
            const examId = {{ $exam->id }};
            const storeUrl = `/admin/exams/${examId}/subjects`;

            const subjectModalEl = document.getElementById('subjectModal');
            const subjectModal = new bootstrap.Modal(subjectModalEl);

            let table = $('#subjectTable').DataTable({
                ajax: `/admin/exams/${examId}/subjects/subjects-list`,
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'detail', orderable: false, searchable: false }
                ]
            });

            // Form Submit
            $(document).on('submit', '#subjectForm', function (e) {
                e.preventDefault();

                let id = $('#subjectId').val();
                let url = id ? `/admin/exams/${examId}/subjects/${id}` : storeUrl;
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
                        subjectModal.hide();
                        $('#subjectForm')[0].reset();
                        $('#subjectId').val('');
                        $('#subjectModalLabel').text('Yeni Ders Ekle');
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert("Bir hata oluştu.");
                    }
                });
            });

            // Yeni Ders Butonu
            $('#addSubjectBtn').on('click', function () {
                $('#subjectForm')[0].reset();
                $('#subjectId').val('');
                $('#subjectModalLabel').text('Yeni Ders Ekle');
                subjectModal.show();
            });

            // Düzenle Butonu
            $(document).on('click', '.editSubject', function () {
                $('#subjectId').val($(this).data('id'));
                $('#subjectName').val($(this).data('name'));
                $('#subjectModalLabel').text('Dersi Düzenle');
                subjectModal.show();
            });

            // Sil Butonu
            $(document).on('click', '.deleteSubject', function () {
                if (confirm('Emin misin?')) {
                    let id = $(this).data('id');

                    $.ajax({
                        url: `/admin/exams/${examId}/subjects/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function () {
                            table.ajax.reload();
                        },
                        error: function () {
                            alert("Silinemedi.");
                        }
                    });
                }
            });

            // Modal kapandığında formu resetle
            subjectModalEl.addEventListener('hidden.bs.modal', function () {
                $('#subjectForm')[0].reset();
                $('#subjectId').val('');
                $('#subjectModalLabel').text('Yeni Ders Ekle');
            });
        </script>    @endpush
@endsection

