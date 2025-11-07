@extends('all_views.viewmaster.index_a')

@section('title', 'Gestione Allestimento')

@section('extra_style')
    {{-- Stili per DataTables e SweetAlert2 --}}
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .loading-spinner {
            display: none;
            margin-left: 10px;
            color: #007bff; /* Bootstrap primary color */
        }
    </style>
@endsection

@section('content_main')
    <div class="appointment_section mt-2">
        <div class="container">
            <div class="appointment_box">
                <h1>Gestione Allestimento</h1>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="molecola_select">Seleziona Molecola:</label>
                            <select class="form-control" id="molecola_select">
                                <option value="">-- Seleziona --</option>
                                @foreach ($molecole as $molecola)
                                    <option value="{{ $molecola->id }}">{{ $molecola->descrizione }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="packaging_select">Seleziona Packaging:</label>
                            <select class="form-control" id="packaging_select" disabled>
                                <option value="">-- Seleziona --</option>
                            </select>
                            <span class="loading-spinner" id="packaging_spinner"><i class="fas fa-spinner fa-spin"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pack_qty_select">Seleziona Quantità Packaging:</label>
                            <select class="form-control" id="pack_qty_select" disabled>
                                <option value="">-- Seleziona --</option>
                            </select>
                            <span class="loading-spinner" id="pack_qty_spinner"><i class="fas fa-spinner fa-spin"></i></span>
                        </div>
                    </div>
                </div>

                <hr>

                <div id="allestimento_results" class="mt-4">
                    <h3>Dettagli Allestimento</h3>
                    <div class="table-responsive">
                        <table id="tbl_allestimento" class="display nowrap table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Codice Liofilchem</th>
                                    <th>Descrizione</th>
                                    <th>Stock</th>
                                    <th>Refill</th>
                                    <th>Remaining</th>
                                    <th>Operazioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- I dati verranno caricati qui tramite AJAX --}}
                            </tbody>
                        </table>
                    </div>
                    <div id="no_data_message" class="alert alert-info mt-3" style="display:none;">
                        Nessun dato di allestimento trovato per le selezioni correnti.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_plugin')
    {{-- Script per DataTables --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>

    {{-- Script personalizzato per la gestione dell'allestimento --}}
    <script src="{{ URL::asset('/') }}js/manage_allestimento.js?ver=<?= time() ?>"></script>
    <script>
        // Passa il token CSRF e gli URL delle rotte a JavaScript
        const CSRF_TOKEN = "{{ csrf_token() }}";
        const GET_PACKAGING_URL = "{{ route('allestimento.getPackaging') }}";
        const GET_PACK_QTY_URL = "{{ route('allestimento.getPackQty') }}";
        const GET_ALLESTIMENTO_URL = "{{ route('allestimento.getData') }}";
        const REFILL_ALLESTIMENTO_URL = "{{ route('allestimento.refill') }}";
        const SAVE_ALLESTIMENTO_URL = "{{ route('allestimento.save') }}";

        // Funzioni globali per refill/salvataggio, simili alla struttura esistente
        window.refill_art = function(artId) {
            const refillQty = $(`#refill_${artId}`).val();
            if (refillQty <= 0) {
                Swal.fire('Attenzione', 'La quantità di refill deve essere maggiore di zero.', 'warning');
                return;
            }

            $('#spin_art_' + artId).show();
            $.ajax({
                url: REFILL_ALLESTIMENTO_URL,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    id: artId,
                    refill_qty: refillQty
                },
                success: function(response) {
                    $('#spin_art_' + artId).hide();
                    if (response.success) {
                        $(`#stock_val_${artId}`).text(response.new_stock);
                        $(`#remaining_val_${artId}`).text(response.new_remaining);
                        $(`#refill_${artId}`).val(0);
                        Swal.fire('Successo', 'Stock aggiornato con successo!', 'success');
                    } else {
                        Swal.fire('Errore', 'Si è verificato un errore durante l\'aggiornamento.', 'error');
                    }
                },
                error: function(xhr) {
                    $('#spin_art_' + artId).hide();
                    Swal.fire('Errore', 'Impossibile completare la richiesta.', 'error');
                    console.error(xhr.responseText);
                }
            });
        };

        window.save_art_liof = function(artId) {
            const codLiof = $(`#cod_liof_${artId}`).val();
            const description = $(`#description_${artId}`).val();
            
            $('#spin_art_' + artId).show();
            $.ajax({
                url: SAVE_ALLESTIMENTO_URL,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    id: artId,
                    cod_liof: codLiof,
                    description: description
                },
                success: function(response) {
                    $('#spin_art_' + artId).hide();
                    if (response.success) {
                        Swal.fire('Successo', 'Dati salvati con successo!', 'success');
                    } else {
                        Swal.fire('Errore', 'Si è verificato un errore durante il salvataggio.', 'error');
                    }
                },
                error: function(xhr) {
                    $('#spin_art_' + artId).hide();
                    Swal.fire('Errore', 'Impossibile completare la richiesta.', 'error');
                    console.error(xhr.responseText);
                }
            });
        };
    </script>
@endsection