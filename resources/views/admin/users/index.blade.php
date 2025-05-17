@extends('admin.layouts.app')

@section('title', 'Kullanıcı Yönetimi')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Kullanıcı Listesi</h3>
                <button class="btn btn-primary" id="addUserBtn" data-bs-toggle="modal" data-bs-target="#userModal">
                    <i class="fas fa-plus-circle"></i> Yeni Kullanıcı
                </button>
            </div>
            <div class="card-body">
                <table id="userTable" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>İsim</th>
                        <th>Email</th>
                        <th>Roller</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="userForm">
                @csrf
                <input type="hidden" name="user_id" id="userId">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="userModalLabel">Yeni Kullanıcı</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>İsim</label>
                            <input type="text" name="name" class="form-control" id="userName" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" id="userEmail" required>
                        </div>
                        <div class="mb-3">
                            <label>Şifre</label>
                            <input type="password" name="password" class="form-control" id="userPassword">
                            <small class="text-muted">Boş bırakılırsa değiştirilmez.</small>
                        </div>
                        <div class="mb-3">
                            <label>Roller</label>
                            <select id="userRoles" name="roles[]" multiple required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
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
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
        <script>
            const table = $('#userTable').DataTable({
                ajax: '{{ route('admin.users.ajax') }}',
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'roles' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            const roleSelect = new Choices('#userRoles', {
                placeholderValue: 'Rol seçiniz',
                searchPlaceholderValue: 'Rol ara...',
                shouldSort: false,
            });

            $('#addUserBtn').on('click', function () {
                $('#userForm')[0].reset();
                $('#userId').val('');
                roleSelect.removeActiveItems();
                $('#userModalLabel').text('Yeni Kullanıcı');
            });

            $(document).on('click', '.editUser', function () {
                const roles = $(this).data('roles').toString().split(',');

                $('#userId').val($(this).data('id'));
                $('#userName').val($(this).data('name'));
                $('#userEmail').val($(this).data('email'));
                $('#userPassword').val('');
                roleSelect.removeActiveItems();
                roles.forEach(role => roleSelect.setChoiceByValue(role));
                $('#userModalLabel').text('Kullanıcıyı Düzenle');
                $('#userModal').modal('show');
            });

            $('#userForm').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const id = $('#userId').val();
                const url = id ? `/admin/users/${id}` : `/admin/users`;

                if (id) formData.append('_method', 'PUT');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        $('#userModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert("Hata oluştu.");
                    }
                });
            });

            $(document).on('click', '.deleteUser', function () {
                if (!confirm("Bu kullanıcıyı silmek istediğinize emin misiniz?")) return;
                const id = $(this).data('id');

                $.ajax({
                    url: `/admin/users/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function () {
                        table.ajax.reload();
                    },
                    error: function () {
                        alert("Silinemedi.");
                    }
                });
            });
        </script>
    @endpush
@endsection

