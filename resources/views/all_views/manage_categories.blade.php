@extends('all_views.viewmaster.index_a')

@section('title', 'Gestione Categorie')

@section('extra_style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .375rem .75rem;
        }
        .loading-spinner {
            display: none;
            margin-left: 10px;
            color: #007bff;
        }
        .card-body {
            min-height: 150px;
        }
    </style>
@endsection

@section('content_main')
<div class="appointment_section mt-2">
    <div class="container-fluid">
        <div class="appointment_box">
            <h1>Gestione Categorie</h1>
            <p>Seleziona una molecola per gestire i packaging e le quantità associate.</p>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="molecola_select">Seleziona Molecola:</label>
                        <select class="form-control" id="molecola_select">
                            <option value="">-- Seleziona una Molecola --</option>
                            @foreach ($molecole as $molecola)
                                <option value="{{ $molecola->id }}">{{ $molecola->descrizione }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            <div id="management_forms" style="display:none;">
                <div class="row">
                    <!-- Packaging Management -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Packaging per <span id="selected_molecola_name_pack"></span></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <span class="loading-spinner" id="packaging_spinner"><i class="fas fa-spinner fa-spin"></i></span>
                                    <h6>Packaging Associati</h6>
                                    <ul class="list-group" id="associated_packaging_list">
                                        <!-- Contenuto caricato via AJAX -->
                                    </ul>
                                    <p id="no_packaging_message" class="text-muted" style="display:none;">Nessun packaging associato.</p>
                                </div>
                                <hr>
                                <div class="form-group mt-3">
                                    <label for="packaging_to_add_select">Aggiungi Packaging Esistente:</label>
                                    <div class="input-group">
                                        <select class="form-control" id="packaging_to_add_select" style="width: 80%;">
                                            <!-- Opzioni caricate via AJAX -->
                                        </select>
                                        <button type="button" class="btn btn-primary" id="associate_packaging_btn">Aggiungi</button>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="new_packaging_description">Nuovo Packaging:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="new_packaging_description" placeholder="Descrizione nuovo packaging">
                                        <button type="button" class="btn btn-success" id="add_new_packaging_btn">Crea e Associa</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Pack Qty Management -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Quantità per Packaging Selezionato</h5>
                            </div>
                            <div class="card-body" id="pack_qty_card_body">
                                <p id="pack_qty_placeholder">Seleziona un packaging dalla lista a sinistra per gestirne le quantità.</p>
                                <div id="pack_qty_form" style="display:none;">
                                    <h6>Quantità Associate per <span id="selected_packaging_name_qty" class="fw-bold"></span>:</h6>
                                    <div class="form-group">
                                        <span class="loading-spinner" id="pack_qty_spinner"><i class="fas fa-spinner fa-spin"></i></span>
                                        <ul class="list-group" id="associated_pack_qty_list">
                                            <!-- Contenuto caricato via AJAX -->
                                        </ul>
                                        <p id="no_pack_qty_message" class="text-muted" style="display:none;">Nessuna quantità associata.</p>
                                    </div>
                                    <hr>
                                    <div class="form-group mt-3">
                                        <label for="pack_qty_to_add_select">Aggiungi Quantità Esistente:</label>
                                        <div class="input-group">
                                            <select class="form-control" id="pack_qty_to_add_select" style="width: 80%;">
                                                <!-- Opzioni caricate via AJAX -->
                                            </select>
                                            <button type="button" class="btn btn-primary" id="associate_pack_qty_btn">Aggiungi</button>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="new_pack_qty_description">Nuova Quantità Packaging:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="new_pack_qty_description" placeholder="Descrizione nuova quantità">
                                            <button type="button" class="btn btn-success" id="add_new_pack_qty_btn">Crea e Associa</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('content_plugin')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Pass constants to JavaScript
    const CSRF_TOKEN = "{{ csrf_token() }}";
    const GET_PACKAGING_URL = "{{ route('categories.getPackaging') }}"; // This should be a GET route
    const GET_PACK_QTY_URL = "{{ route('categories.getPackQty') }}";
    const ASSOCIATE_PACKAGING_URL = "{{ route('categories.associatePackaging') }}";
    const DISSOCIATE_PACKAGING_URL = "{{ route('categories.dissociatePackaging') }}";
    const STORE_PACKAGING_URL = "{{ route('categories.storePackaging') }}";
    const ASSOCIATE_PACK_QTY_URL = "{{ route('categories.associatePackQty') }}";
    const DISSOCIATE_PACK_QTY_URL = "{{ route('categories.dissociatePackQty') }}";
    const STORE_PACK_QTY_URL = "{{ route('categories.storePackQty') }}";
</script>
<script src="{{ URL::asset('/') }}js/manage_categories.js?ver=<?= time() ?>"></script>
@endsection