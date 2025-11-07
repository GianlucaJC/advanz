$(document).ready(function() {
    let allestimentoTable;

    // Inizializza DataTable per i risultati dell'allestimento
    function initializeDataTable() {
        if ($.fn.DataTable.isDataTable('#tbl_allestimento')) {
            allestimentoTable.destroy();
        }
        allestimentoTable = $('#tbl_allestimento').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Italian.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": [0, 1, 3, 5] } // Disabilita l'ordinamento per campi input e bottoni
            ]
        });
    }

    initializeDataTable(); // Inizializza al caricamento della pagina, anche se vuota

    $('#molecola_select').on('change', function() {
        const molecolaId = $(this).val();
        $('#packaging_select').prop('disabled', true).html('<option value="">-- Seleziona --</option>');
        $('#pack_qty_select').prop('disabled', true).html('<option value="">-- Seleziona --</option>');
        $('#allestimento_results tbody').empty();
        $('#no_data_message').hide();
        initializeDataTable(); // Re-inizializza per cancellare i dati esistenti

        if (molecolaId) {
            $('#packaging_spinner').show();
            $.ajax({
                url: GET_PACKAGING_URL,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    molecola_id: molecolaId
                },
                success: function(response) {
                    $('#packaging_spinner').hide();
                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            $('#packaging_select').append('<option value="' + value.id + '">' + value.descrizione + '</option>');
                        });
                        $('#packaging_select').prop('disabled', false);
                    } else {
                        Swal.fire('Attenzione', 'Nessun packaging trovato per la molecola selezionata.', 'warning');
                    }
                },
                error: function(xhr) {
                    $('#packaging_spinner').hide();
                    Swal.fire('Errore', 'Impossibile caricare i packaging.', 'error');
                    console.error(xhr.responseText);
                }
            });
        }
    });

    $('#packaging_select').on('change', function() {
        const packId = $(this).val();
        $('#pack_qty_select').prop('disabled', true).html('<option value="">-- Seleziona --</option>');
        $('#allestimento_results tbody').empty();
        $('#no_data_message').hide();
        initializeDataTable(); // Re-inizializza per cancellare i dati esistenti

        if (packId) {
            $('#pack_qty_spinner').show();
            $.ajax({
                url: GET_PACK_QTY_URL,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    pack_id: packId
                },
                success: function(response) {
                    $('#pack_qty_spinner').hide();
                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            $('#pack_qty_select').append('<option value="' + value.id + '">' + value.descrizione + '</option>');
                        });
                        $('#pack_qty_select').prop('disabled', false);
                    } else {
                        Swal.fire('Attenzione', 'Nessuna quantità di packaging trovata per il packaging selezionato.', 'warning');
                    }
                },
                error: function(xhr) {
                    $('#pack_qty_spinner').hide();
                    Swal.fire('Errore', 'Impossibile caricare le quantità di packaging.', 'error');
                    console.error(xhr.responseText);
                }
            });
        }
    });

    $('#pack_qty_select').on('change', function() {
        loadAllestimentoData();
    });

    function loadAllestimentoData() {
        const molecolaId = $('#molecola_select').val();
        const packId = $('#packaging_select').val();
        const packQtyId = $('#pack_qty_select').val();

        $('#allestimento_results tbody').empty();
        $('#no_data_message').hide();
        initializeDataTable(); // Re-inizializza per cancellare i dati esistenti

        if (molecolaId && packId && packQtyId) {
            $.ajax({
                url: GET_ALLESTIMENTO_URL,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    molecola_id: molecolaId,
                    pack_id: packId,
                    pack_qty_id: packQtyId
                },
                success: function(response) {
                    if (response.length > 0) {
                        allestimentoTable.clear().draw(); // Cancella i dati esistenti da DataTable
                        $.each(response, function(key, art) {
                            const row = `<tr><td><input type='text' class='form-control' id='cod_liof_${art.id}' style='width:150px' maxlength=20 value="${art.cod_liof || ''}"></td><td><input type='text' class='form-control' id='description_${art.id}' style='width:150px' value="${art.descrizione || ''}"></td><td><span id='stock_val_${art.id}'>${art.stock || 0}</span></td><td><input type='number' class='form-control' id='refill_${art.id}' style='width:100px' value="0" min="1"></td><td><span id='remaining_val_${art.id}'>${art.remaining || 0}</span></td><td><span id='spin_art_${art.id}' style='display:inline;' hidden><i class='fas fa-spinner fa-spin'></i></span><button type="button" onclick="refill_art(${art.id})" class="btn btn-primary btn-sm">Refill</button> <button type="button" onclick="save_art_liof(${art.id})" class="btn btn-success btn-sm">Save</button></td></tr>`;
                            allestimentoTable.row.add($(row)).draw(false); // Aggiungi riga a DataTable
                        });
                        allestimentoTable.columns.adjust().draw(); // Adatta le colonne e ridisegna
                    } else {
                        $('#no_data_message').show();
                    }
                },
                error: function(xhr) {
                    Swal.fire('Errore', 'Impossibile caricare i dati di allestimento.', 'error');
                    console.error(xhr.responseText);
                }
            });
        }
    }
});