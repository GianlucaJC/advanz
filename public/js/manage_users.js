$(document).ready(function() {
    // Inizializza l'istanza della modale UNA SOLA VOLTA.
    const editModalEl = document.getElementById('editUserModal');
    const editUserModal = new bootstrap.Modal(editModalEl);

    // Inizializzazione DataTable
    const usersTable = $('#users_table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/it-IT.json"
        }
    });
    // Gestione apertura modale per modifica
    $(document).on('click', '.edit-btn', function() {
        const user = $(this).data('user');
        
        $('#edit_id').val(user.id);
        $('#edit_first_name').val(user.first_name);
        $('#edit_last_name').val(user.last_name);
        $('#edit_istituto').val(user.istituto);
        $('#edit_position').val(user.position);
        $('#edit_department').val(user.department);
        $('#edit_shipping_address1').val(user.shipping_address1);
        $('#edit_shipping_address2').val(user.shipping_address2);
        $('#edit_city').val(user.city);
        $('#edit_postal_code').val(user.postal_code);
        $('#edit_email_ref').val(user.email_ref);
        $('#edit_phone').val(user.phone);

        // Ora usa l'istanza già creata per mostrare la modale.
        editUserModal.show();
    });

    // Gestione salvataggio modifiche utente
    $('#saveUserBtn').on('click', function() {
        const formData = $('#editUserForm').serialize();

        $.ajax({
            url: UPDATE_USER_URL,
            type: 'POST',
            data: formData + '&_token=' + CSRF_TOKEN,
            success: function(response) {
                if (response.success) {                    
                    // Usa l'istanza già creata per nascondere la modale.
                    editUserModal.hide();

                    // --- Aggiornamento dinamico della tabella ---
                    const form = $('#editUserForm');
                    const userId = form.find('#edit_id').val();
                    const row = usersTable.row($('tr[data-user-id="' + userId + '"]'));
                    
                    if (row.length) {
                        const rowData = row.data();
                        rowData[1] = form.find('#edit_first_name').val() + ' ' + form.find('#edit_last_name').val(); // Nome e Cognome
                        rowData[3] = form.find('#edit_istituto').val(); // Istituto
                        row.data(rowData).draw();
                    }

                    // --- Aggiornamento dell'attributo data-user del pulsante ---
                    const button = $('tr[data-user-id="' + userId + '"]').find('.edit-btn');
                    if (button.length) {
                        // Ricostruisci l'oggetto utente con i dati aggiornati dal form
                        const updatedUser = {
                            id: userId,
                            first_name: form.find('#edit_first_name').val(),
                            last_name: form.find('#edit_last_name').val(),
                            istituto: form.find('#edit_istituto').val(),
                            position: form.find('#edit_position').val(),
                            department: form.find('#edit_department').val(),
                            shipping_address1: form.find('#edit_shipping_address1').val(),
                            shipping_address2: form.find('#edit_shipping_address2').val(),
                            city: form.find('#edit_city').val(),
                            postal_code: form.find('#edit_postal_code').val(),
                            email_ref: form.find('#edit_email_ref').val(),
                            phone: form.find('#edit_phone').val()
                        };
                        button.data('user', updatedUser);
                    }
                    // --- Fine aggiornamento dinamico ---

                    // Mostra la notifica di successo dopo aver chiuso la modale
                    // per evitare sovrapposizioni di overlay.
                    setTimeout(() => {
                        Swal.fire('Successo', response.message, 'success');
                    }, 300); // Un piccolo ritardo per la transizione
                }
            },
            error: function(xhr) {
                let errorMessage = 'Si è verificato un errore.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                    if (xhr.responseJSON.errors) {
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        errorMessage += '<br>' + errors.join('<br>');
                    }
                }
                Swal.fire('Errore', errorMessage, 'error');
            }
        });
    });

    // Gestione cambio ruolo
    $('.role-switch').on('change', function() {
        const checkbox = $(this);
        const userId = checkbox.closest('tr').data('user-id');
        const role = checkbox.data('role');
        const isActive = checkbox.is(':checked');

        // Logica per deselezionare l'altro switch
        if (isActive) {
            const otherRole = (role === 'is_user') ? 'is_pharma' : 'is_user';
            $(`#${otherRole}_${userId}`).prop('checked', false);
        }

        $.ajax({
            url: UPDATE_USER_ROLE_URL,
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                id: userId,
                role: role,
                active: isActive ? 1 : 0 // Invia 1 o 0 invece di true/false
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function(xhr) {
                // Ripristina lo stato precedente in caso di errore
                checkbox.prop('checked', !isActive);
                if (!isActive) {
                    const otherRole = (role === 'is_user') ? 'is_pharma' : 'is_user';
                    $(`#${otherRole}_${userId}`).prop('checked', true);
                }

                let errorMessage = 'Impossibile aggiornare il ruolo.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire('Errore', errorMessage, 'error');
            }
        });
    });
});