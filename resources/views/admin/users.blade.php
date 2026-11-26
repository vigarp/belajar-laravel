@extends('admin.template')
@section('title', 'Data Users')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3 py-3">
            <h3>Data Users</h3>
            <header class="justify-content-end">
                <button type="button" class="btn btn-primary" id="btnAddUser">Tambah User</button>
            </header>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered" id="table_user">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah / Edit User -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="userForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="user_id" name="user_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <small class="text-muted d-none" id="passwordHelp">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveUser">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@php
    $apiToken = session('api_token');
    if (! $apiToken && auth()->check()) {
        $apiToken = auth()->user()->createToken('auth_token')->plainTextToken;
        session(['api_token' => $apiToken]);
    }
@endphp
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function () {
        const apiToken = @json($apiToken);
        const userModal = new bootstrap.Modal(document.getElementById('userModal'));

        const escapeHtml = function (text) {
            return $('<div>').text(text ?? '').html();
        };

        const table = $('#table_user').DataTable({
            ajax: {
                url: "{{ route('list-users') }}",
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + apiToken,
                    'Accept': 'application/json'
                },
                dataSrc: 'data',
                error: function () {
                    toastr.error('Gagal memuat data users');
                }
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'name',
                    render: function (data) {
                        return escapeHtml(data);
                    }
                },
                {
                    data: 'email',
                    render: function (data) {
                        return escapeHtml(data);
                    }
                },
                {
                    data: 'phone',
                    render: function (data) {
                        return data ? escapeHtml(data) : '-';
                    }
                },
                {
                    data: 'address',
                    render: function (data) {
                        return data ? escapeHtml(data) : '-';
                    }
                },
                {
                    data: 'role',
                    render: function (data) {
                        return escapeHtml(data || 'user');
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (id) {
                        return `
                            <button type="button" class="btn btn-sm btn-warning btn-edit" data-id="${id}">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${id}">Hapus</button>
                        `;
                    }
                }
            ],
            initComplete: function (settings, json) {
                if (json && json.message) {
                    toastr.success(json.message);
                }
            }
        });

        $('#btnAddUser').on('click', function () {
            $('#userForm')[0].reset();
            $('#user_id').val('');
            $('#userModalLabel').text('Tambah User');
            $('#password').attr('required', true);
            $('#passwordHelp').addClass('d-none');
            userModal.show();
        });

        $('#table_user').on('click', '.btn-edit', function () {
            const id = $(this).data('id');

            $.ajax({
                url: "{{ url('/api/users') }}/" + id,
                type: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + apiToken,
                    'Accept': 'application/json'
                },
                success: function (res) {
                    const user = res.data;
                    $('#user_id').val(user.id);
                    $('#name').val(user.name);
                    $('#email').val(user.email);
                    $('#password').val('').removeAttr('required');
                    $('#passwordHelp').removeClass('d-none');
                    $('#phone').val(user.phone ?? '');
                    $('#address').val(user.address ?? '');
                    $('#role').val(user.role ?? 'user');
                    $('#userModalLabel').text('Edit User');
                    userModal.show();
                },
                error: function (xhr) {
                    const msg = xhr.responseJSON?.message || 'Gagal mengambil data user';
                    toastr.error(msg);
                }
            });
        });

        $('#userForm').on('submit', function (e) {
            e.preventDefault();

            const id = $('#user_id').val();
            const isEdit = Boolean(id);
            const url = isEdit ? "{{ url('/api/users') }}/" + id : "{{ url('/api/users') }}";
            const method = isEdit ? 'PUT' : 'POST';

            const payload = {
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                address: $('#address').val(),
                role: $('#role').val()
            };

            const password = $('#password').val();
            if (password) {
                payload.password = password;
            }

            $.ajax({
                url: url,
                type: method,
                headers: {
                    'Authorization': 'Bearer ' + apiToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(payload),
                success: function (res) {
                    userModal.hide();
                    toastr.success(res.message || 'Data user berhasil disimpan');
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        const firstError = Object.values(errors).flat()[0];
                        toastr.error(firstError);
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Gagal menyimpan data user');
                    }
                }
            });
        });

        $('#table_user').on('click', '.btn-delete', function () {
            const id = $(this).data('id');

            if (!confirm('Apakah Anda yakin menghapus user ini?')) {
                return;
            }

            $.ajax({
                url: "{{ url('/api/users') }}/" + id,
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + apiToken,
                    'Accept': 'application/json'
                },
                success: function (res) {
                    toastr.success(res.message || 'User berhasil dihapus');
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Gagal menghapus data user');
                }
            });
        });
    });
</script>
@endsection
