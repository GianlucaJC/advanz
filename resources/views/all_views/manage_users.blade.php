@extends('all_views.viewmaster.index_a')

@section('title', 'Gestione Utenti')

@section('extra_style')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .form-switch .form-check-input {
            width: 2.5em;
            height: 1.25em;
        }
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right;
        }
    </style>
@endsection

@section('content_main')
<div class="appointment_section mt-2">
    <div class="container-fluid">
        <div class="appointment_box">
            <h1>Gestione Utenti</h1>
            <p>Da questa sezione puoi visualizzare, modificare i dati anagrafici e cambiare i ruoli degli utenti registrati.</p>

            <div class="table-responsive mt-4">
                <table id="users_table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Istituto</th>
                            <th>Tipo Utente</th>
                            <th>Operazioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr data-user-id="{{ $user->id }}">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->istituto }}</td>
                                <td>
                                    @if ($user->is_admin)
                                        <span class="badge bg-danger">Admin</span>
                                    @else
                                        <div class="form-check form-switch d-inline-block me-3">
                                            <input class="form-check-input role-switch" type="checkbox" role="switch" id="is_user_{{ $user->id }}" data-role="is_user" {{ $user->is_user ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_user_{{ $user->id }}">User</label>
                                        </div>
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input role-switch" type="checkbox" role="switch" id="is_pharma_{{ $user->id }}" data-role="is_pharma" {{ $user->is_pharma ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_pharma_{{ $user->id }}">Pharma</label>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" data-user='@json($user)'>
                                        <i class="fas fa-edit"></i> Modifica
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifica Utente -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Modifica Utente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_first_name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_last_name" class="form-label">Cognome</label>
                            <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_istituto" class="form-label">Istituto</label>
                        <input type="text" class="form-control" id="edit_istituto" name="istituto" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_position" class="form-label">Posizione</label>
                            <input type="text" class="form-control" id="edit_position" name="position" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_department" class="form-label">Dipartimento</label>
                            <input type="text" class="form-control" id="edit_department" name="department" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_shipping_address1" class="form-label">Indirizzo di Spedizione 1</label>
                        <input type="text" class="form-control" id="edit_shipping_address1" name="shipping_address1" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_shipping_address2" class="form-label">Indirizzo di Spedizione 2</label>
                        <input type="text" class="form-control" id="edit_shipping_address2" name="shipping_address2">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_city" class="form-label">Città</label>
                            <input type="text" class="form-control" id="edit_city" name="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_postal_code" class="form-label">Codice Postale</label>
                            <input type="text" class="form-control" id="edit_postal_code" name="postal_code" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_email_ref" class="form-label">Email di Riferimento</label>
                            <input type="email" class="form-control" id="edit_email_ref" name="email_ref" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_phone" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-primary" id="saveUserBtn">Salva Modifiche</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content_plugin')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    // Passa le rotte a JavaScript
    const CSRF_TOKEN = "{{ csrf_token() }}";
    const UPDATE_USER_URL = "{{ route('admin.update_user') }}";
    const UPDATE_USER_ROLE_URL = "{{ route('admin.update_user_role') }}";
</script>
<script src="{{ URL::asset('/') }}js/manage_users.js?ver=<?= time() ?>"></script>
@endsection