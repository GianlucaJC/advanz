@extends('all_views.viewmaster.index_a')

@section('title', 'Gestione Categorie')

@section('extra_style')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /*
         * Ripristina la freccia del dropdown per gli elementi select
         * che potrebbero averla persa a causa di stili globali (es. appearance: none).
        */
        select.form-control {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 16px 12px;
            padding-right: 2.25rem; /* Aggiunge spazio per non sovrapporre il testo alla freccia */
        }

        /* Mantiene il bordo visibile anche quando la select è in focus */
        select.form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
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
                                        <select class="form-control" id="packaging_to_add_select">
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
                                            <select class="form-control" id="pack_qty_to_add_select">
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