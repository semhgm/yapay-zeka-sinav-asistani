@extends('admin.layouts.app')

@section('title', $subject->name . ' - Sorular')

@section('content')<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">{{ $subject->name }} - Soru Listesi</h3>
            <button class="btn btn-primary" id="addQuestionBtn" data-bs-toggle="modal" data-bs-target="#questionModal">
                <i class="fas fa-plus-circle"></i> Yeni Soru Ekle
            </button>
        </div>
        <div class="card-body">
            <table id="questionTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Soru Metni</th>
                    <th>Görsel</th>
                    <th>Doğru Cevap</th>
                    <th>Sıra No</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="questionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="questionForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="question_id" id="questionId">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="questionModalLabel">Yeni Soru Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Soru Metni -->
                        <div class="mb-3">
                            <label>Soru Metni</label>
                            <textarea name="question_text" id="questionText" class="form-control" rows="4" required></textarea>
                        </div>

                        <!-- Soru Resmi -->
                        <div class="mb-3">
                            <label for="image">Soru Görseli (opsiyonel)</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        </div>

                        <!-- Var olan resmi göster (düzenleme için) -->
                        <div class="mb-3" id="imagePreviewWrapper" style="display: none;">
                            <label>Mevcut Görsel:</label>
                            <div>
                                <img id="imagePreview" src="" alt="Soru Görseli" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                        <!-- Şıklar -->
                        <div class="mb-3">
                            <label>Şıklar</label>
                            @foreach(['A', 'B', 'C', 'D', 'E'] as $choice)
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_answer" value="{{ $choice }}">
                                    </div>
                                    <input type="text" name="choices[{{ $choice }}]" class="form-control" placeholder="{{ $choice }} Şıkkı">
                                </div>
                            @endforeach
                        </div>

                        <!-- Konu Seçimi -->
                        <div class="mb-3">
                            <label>Konular</label>
                            <select id="topics" name="topics[]" multiple class="form-control" required>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sıra No -->
                        <div class="mb-3">
                            <label>Sıra Numarası (opsiyonel)</label>
                            <input type="number" class="form-control" name="order_number" id="orderNumber">
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

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        const examId = {{ $examId }};
        const subjectId = {{ $subject->id }};

        // DataTable başlat
        const table = $('#questionTable').DataTable({
            ajax: `/admin/exams/${examId}/subjects/${subjectId}/questions/ajax-list`,
            columns: [
                { data: 'id' },
                { data: 'question_text' },
                {
                    data: 'image_path',
                    render: function (data) {
                        if (!data) return '-';
                        return `<img src="${data}" alt="soru görseli" style="max-height: 60px;">`;                    },
                    orderable: false,
                    searchable: false
                },
                { data: 'correct_answer' },
                { data: 'order_number' },
                { data: 'actions', orderable: false, searchable: false }
            ]
        });

        // Konu seçimi için choices.js
        const topicSelect = document.getElementById('topics');
        new Choices(topicSelect, {
            removeItemButton: true,
            placeholderValue: 'Konuları seçiniz',
            searchPlaceholderValue: 'Konu ara...',
        });

        // Yeni Soru Ekle butonu
        $('#addQuestionBtn').on('click', function () {
            $('#questionForm')[0].reset();
            $('#questionId').val('');
            $('#imagePreviewWrapper').hide();
            $('#imagePreview').attr('src', '');
            $('#questionModalLabel').text('Yeni Soru Ekle');
            $('#questionModal').modal('show');
        });

        // Düzenle butonu
        $(document).on('click', '.editQuestion', function () {
            $('#questionForm')[0].reset();
            $('#questionId').val($(this).data('id'));
            $('#questionText').val($(this).data('text'));
            $('#orderNumber').val($(this).data('order'));
            $('input[name="correct_answer"][value="' + $(this).data('correct') + '"]').prop('checked', true);

            const imagePath = $(this).data('image');
            if (imagePath) {
                $('#imagePreviewWrapper').show();
                $('#imagePreview').attr('src', imagePath);
            } else {
                $('#imagePreviewWrapper').hide();
                $('#imagePreview').attr('src', '');
            }

            $('#questionModalLabel').text('Soruyu Düzenle');
            $('#questionModal').modal('show');
        });

        // Silme işlemi
        $(document).on('click', '.deleteQuestion', function () {
            if (!confirm('Bu soruyu silmek istediğinize emin misiniz?')) return;

            const id = $(this).data('id');

            $.ajax({
                url: `/admin/exams/${examId}/subjects/${subjectId}/questions/${id}`,
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

        // Form Submit (Ekle / Güncelle)
        $(document).on('submit', '#questionForm', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = $('#questionId').val();
            const url = id
                ? `/admin/exams/${examId}/subjects/${subjectId}/questions/${id}`
                : `/admin/exams/${examId}/subjects/${subjectId}/questions`;

            if (id) formData.append('_method', 'PUT');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function () {
                    $('#questionModal').modal('hide');
                    table.ajax.reload();
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Bir hata oluştu');
                }
            });
        });
    </script>
@endpush
@endsection

