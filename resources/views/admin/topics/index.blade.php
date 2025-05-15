@extends('admin.layouts.app')
@section('title', 'Konu Listesi')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Card -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Konu Listesi</h3>
                        <button class="btn btn-primary" id="addTopicBtn" data-bs-toggle="modal" data-bs-target="#topicModal">
                            <i class="fas fa-plus-circle"></i> Yeni Konu Ekle
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="topicTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Konu Adı</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="topicModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="topicForm">
                @csrf
                <input type="hidden" id="topicId" name="id">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="topicModalLabel">Yeni Konu Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="topicName">Konu Adı</label>
                            <input type="text" class="form-control" id="topicName" name="name" required>
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let table = $('#topicTable').DataTable({
                ajax: '{{ route("admin.topics.ajaxList") }}',
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            $('#addTopicBtn').on('click', function () {
                $('#topicForm')[0].reset();
                $('#topicId').val('');
                $('#topicModalLabel').text('Yeni Konu Ekle');
            });

            $(document).on('click', '.editTopic', function () {
                $('#topicId').val($(this).data('id'));
                $('#topicName').val($(this).data('name'));
                $('#topicModalLabel').text('Konuyu Düzenle');
                $('#topicModal').modal('show');
            });

            $(document).on('submit', '#topicForm', function (e) {
                e.preventDefault();
                let id = $('#topicId').val();
                let method = id ? 'PUT' : 'POST';
                let url = id ? `/admin/topics/${id}` : `/admin/topics`;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: method,
                        name: $('#topicName').val()
                    },
                    success: function () {
                        $('#topicModal').modal('hide');
                        $('#topicForm')[0].reset();
                        $('#topicId').val('');
                        $('#topicModalLabel').text('Yeni Konu Ekle');
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Hata oluştu');
                    }
                });
            });

            $(document).on('click', '.deleteTopic', function () {
                if (!confirm('Bu konuyu silmek istediğine emin misin?')) return;

                const id = $(this).data('id');

                $.ajax({
                    url: `/admin/topics/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function () {
                        table.ajax.reload();
                    },
                    error: function () {
                        alert('Silinemedi');
                    }
                });
            });
        });
    </script>
@endpush
