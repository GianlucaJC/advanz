$(document).ready(function() {
    let selectedMolecolaId = null;
    let selectedPackId = null;

    // Event handler for molecule selection
    $('#molecola_select').on('change', function() {
        selectedMolecolaId = $(this).val();
        const molecolaName = $(this).find('option:selected').text();
        
        $('#pack_qty_form').hide();
        $('#pack_qty_placeholder').show();
        selectedPackId = null;

        if (selectedMolecolaId) {
            $('#management_forms').show();
            $('#selected_molecola_name_pack').text(molecolaName);
            loadPackaging(selectedMolecolaId);
        } else {
            $('#management_forms').hide();
        }
    });

    function loadPackaging(molecolaId) {
        if (!molecolaId) return;
        $('#packaging_spinner').show();
        $('#associated_packaging_list').empty();
        $('#packaging_to_add_select').empty().append(new Option('-- Seleziona per aggiungere --', ''));

        $.ajax({
            url: GET_PACKAGING_URL,
            type: 'GET',
            data: { _token: CSRF_TOKEN, molecola_id: molecolaId },
            success: function(data) {
                // Popola lista associati
                if (data.associated.length > 0) {
                    $('#no_packaging_message').hide();
                    data.associated.forEach(function(pack) {
                        const listItem = `
                            <li class="list-group-item d-flex justify-content-between align-items-center" data-pack-id="${pack.id}">
                                <span class="packaging-name">${pack.descrizione}</span>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary manage-qty-btn">Gestisci Quantità</button>
                                    
                                </div>
                            </li>`;
                            //<button class="btn btn-sm btn-danger dissociate-pack-btn"><i class="fas fa-trash-alt"></i></button>                            
                        $('#associated_packaging_list').append(listItem);
                    });
                } else {
                    $('#no_packaging_message').show();
                }

                // Popola select per aggiungere
                data.available.forEach(function(pack) {
                    $('#packaging_to_add_select').append(new Option(pack.descrizione, pack.id));
                });
                $('#packaging_to_add_select').trigger('change');
            },
            error: function() {
                Swal.fire('Errore', 'Impossibile caricare i packaging associati.', 'error');
            },
            complete: () => $('#packaging_spinner').hide()
        });
    }

    // Gestione click per "Gestisci Quantità"
    $(document).on('click', '.manage-qty-btn', function() {
        $('.list-group-item').removeClass('active');
        $(this).closest('li').addClass('active');
        
        selectedPackId = $(this).closest('li').data('pack-id');
        const packName = $(this).closest('li').find('.packaging-name').text();
        
        $('#pack_qty_placeholder').hide();
        $('#pack_qty_form').show();
        $('#selected_packaging_name_qty').text(packName);
        loadPackQty(selectedMolecolaId, selectedPackId);
    });

    function loadPackQty(molecolaId, packId) {
        if (!molecolaId || !packId) return;
        $('#pack_qty_spinner').show();
        $('#associated_pack_qty_list').empty();
        $('#pack_qty_to_add_select').empty().append(new Option('-- Seleziona per aggiungere --', ''));

        $.ajax({
            url: GET_PACK_QTY_URL,
            type: 'GET',
            data: { _token: CSRF_TOKEN, molecola_id: molecolaId, pack_id: packId },
            success: function(data) {
                // Popola lista associati
                if (data.associated.length > 0) {
                    $('#no_pack_qty_message').hide();
                    data.associated.forEach(function(qty) {
                        const listItem = `
                            <li class="list-group-item d-flex justify-content-between align-items-center" data-qty-id="${qty.id}">
                                ${qty.descrizione}
                                <button class="btn btn-sm btn-danger dissociate-qty-btn"><i class="fas fa-trash-alt"></i></button>
                            </li>`;
                        $('#associated_pack_qty_list').append(listItem);
                    });
                } else {
                    $('#no_pack_qty_message').show();
                }

                // Popola select per aggiungere
                data.available.forEach(function(qty) {
                    $('#pack_qty_to_add_select').append(new Option(qty.descrizione, qty.id));
                });
                $('#pack_qty_to_add_select').trigger('change');
            },
            error: function() {
                Swal.fire('Errore', 'Impossibile caricare le quantità associate.', 'error');
            },
            complete: () => $('#pack_qty_spinner').hide()
        });
    }

    // --- Funzioni di Associazione ---

    $('#associate_packaging_btn').on('click', function() {
        const packId = $('#packaging_to_add_select').val();
        if (!packId) {
            Swal.fire('Attenzione', 'Seleziona un packaging da aggiungere.', 'warning');
            return;
        }
        performAjax(ASSOCIATE_PACKAGING_URL, { molecola_id: selectedMolecolaId, pack_id: packId }, function() {
            loadPackaging(selectedMolecolaId);
        });
    });

    $('#associate_pack_qty_btn').on('click', function() {
        const packQtyId = $('#pack_qty_to_add_select').val();
        if (!packQtyId) {
            Swal.fire('Attenzione', 'Seleziona una quantità da aggiungere.', 'warning');
            return;
        }
        performAjax(ASSOCIATE_PACK_QTY_URL, { molecola_id: selectedMolecolaId, pack_id: selectedPackId, pack_qty_id: packQtyId }, function() {
            loadPackQty(selectedMolecolaId, selectedPackId);
        });
    });

    // --- Funzioni di Dissociazione con Conferma ---

    $(document).on('click', '.dissociate-pack-btn', function() {
        const packId = $(this).closest('li').data('pack-id');
        const packName = $(this).closest('li').find('.packaging-name').text();
        
        Swal.fire({
            title: 'Sei sicuro?',
            html: `Stai per disassociare il packaging "<b>${packName}</b>" dalla molecola. Questa azione rimuoverà anche tutte le quantità associate. Vuoi procedere?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sì, rimuovi!',
            cancelButtonText: 'Annulla'
        }).then((result) => {
            if (result.isConfirmed) {
                performAjax(DISSOCIATE_PACKAGING_URL, { molecola_id: selectedMolecolaId, pack_id: packId }, function() {
                    loadPackaging(selectedMolecolaId);
                    // Se il packaging rimosso era quello selezionato, nascondi il form delle quantità
                    if (packId == selectedPackId) {
                        $('#pack_qty_form').hide();
                        $('#pack_qty_placeholder').show();
                        selectedPackId = null;
                    }
                });
            }
        });
    });

    $(document).on('click', '.dissociate-qty-btn', function() {
        const qtyId = $(this).closest('li').data('qty-id');
        const qtyName = $(this).closest('li').text().trim();

        Swal.fire({
            title: 'Sei sicuro?',
            html: `Stai per disassociare la quantità "<b>${qtyName}</b>". Vuoi procedere?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sì, rimuovi!',
            cancelButtonText: 'Annulla'
        }).then((result) => {
            if (result.isConfirmed) {
                performAjax(DISSOCIATE_PACK_QTY_URL, { molecola_id: selectedMolecolaId, pack_id: selectedPackId, pack_qty_id: qtyId }, function() {
                    // Ricarica la lista delle quantità
                    loadPackQty(selectedMolecolaId, selectedPackId);

                    // Controlla se, dopo l'aggiornamento, la lista delle quantità è vuota.
                    // Se sì, significa che abbiamo rimosso l'ultima quantità, quindi dobbiamo aggiornare anche la lista dei packaging a sinistra.
                    if ($('#associated_pack_qty_list').children().length === 0) {
                        loadPackaging(selectedMolecolaId);
                        $('#pack_qty_form').hide();
                        $('#pack_qty_placeholder').show();
                    }
                });
            }
        });
    });

    // --- Funzioni di Creazione ---

    $('#add_new_packaging_btn').on('click', function() {
        const description = $('#new_packaging_description').val().trim();
        if (!description) {
            Swal.fire('Attenzione', 'Inserisci una descrizione per il nuovo packaging.', 'warning');
            return;
        }
        performAjax(STORE_PACKAGING_URL, { descrizione: description }, function(response) {
            // Dopo aver creato, associa subito
            const newPackId = response.packaging.id;
            performAjax(ASSOCIATE_PACKAGING_URL, { molecola_id: selectedMolecolaId, pack_id: newPackId }, function() {
                $('#new_packaging_description').val('');
                loadPackaging(selectedMolecolaId);
            });
        });
    });

    $('#add_new_pack_qty_btn').on('click', function() {
        const description = $('#new_pack_qty_description').val().trim();
        if (!description) {
            Swal.fire('Attenzione', 'Inserisci una descrizione per la nuova quantità.', 'warning');
            return;
        }
        performAjax(STORE_PACK_QTY_URL, { descrizione: description }, function(response) {
            // Dopo aver creato, associa subito
            const newQtyId = response.packQty.id;
            performAjax(ASSOCIATE_PACK_QTY_URL, { molecola_id: selectedMolecolaId, pack_id: selectedPackId, pack_qty_id: newQtyId }, function() {
                $('#new_pack_qty_description').val('');
                loadPackQty(selectedMolecolaId, selectedPackId);
            });
        });
    });


    // Funzione helper per AJAX
    function performAjax(url, data, successCallback) {
        const spinner = $(this).find('.fa-spinner').length ? $(this) : $('body'); // Trova uno spinner o usa il body
        spinner.addClass('ajax-loading'); // Aggiungi una classe per mostrare un cursore di caricamento

        $.ajax({
            url: url,
            type: 'POST',
            data: { ...data, _token: CSRF_TOKEN },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message || 'Operazione completata!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    if (successCallback) successCallback(response);
                } else {
                    Swal.fire('Errore', response.message || 'Si è verificato un errore.', 'error');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Errore di comunicazione con il server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                    if (xhr.responseJSON.errors) {
                        errorMessage += '<br>' + Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                }
                Swal.fire('Errore', errorMessage, 'error');
            },
            complete: function() {
                spinner.removeClass('ajax-loading');
            }
        });
    }

    // Aggiungi uno stile per il cursore di caricamento
    $('head').append('<style>.ajax-loading { cursor: wait !important; }</style>');
});