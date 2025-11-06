$(document).ready( function () {
    $('#tbl_art_liof').DataTable({
		dom: 'Bfrtip',
		buttons: [
			'excel'
		]
	});
} );

function save_art_liof(id_art) {
    Swal.fire({
        title: 'Confermi il salvataggio?',
        text: "Stai per salvare le modifiche all'articolo.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sì, salva!',
        cancelButtonText: 'Annulla'
    }).then((result) => {
        if (result.isConfirmed) {
            let cod_liof = $("#cod_liof" + id_art).val();
            let description = $("#description" + id_art).val();
            // Note: stock is now read-only and not sent. The backend doesn't expect it for update_art_liof anymore.

            $("#spin_art" + id_art).show();
            let base_path = $("#url").val() || ''; // Fallback for base_path
            let token = $('#token_csrf').val();

            $.ajax({
                type: "POST",
                url: base_path + "/update_art_liof",
                data: {
                    _token: token,
                    id_art: id_art,
                    cod_liof: cod_liof,
                    description: description
                },
                success: function (data) {
                    $("#spin_art" + id_art).hide();
                    Swal.fire('Salvato!', 'Le modifiche sono state salvate.', 'success');
                },
                error: function() {
                    $("#spin_art" + id_art).hide();
                    Swal.fire('Errore!', 'Si è verificato un errore durante il salvataggio.', 'error');
                }
            });
        }
    });
}

function refill_art(id_art) {
    let refill_qty = $("#refill" + id_art).val();
    if (refill_qty == 0) {
        Swal.fire('Attenzione!', 'Inserire una quantità di refill valida.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Confermi il refill?',
        text: `Stai aggiuntendo ${refill_qty} quantità allo stock ed al remaining.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sì'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#spin_art" + id_art).show();
            let token = $('#token_csrf').val();
            $.ajax({
                type: "POST",
                url: "refill_art",
                data: {
                    _token: token,
                    id_art: id_art,
                    refill_qty: refill_qty
                },
                success: function (data) {
                    let response = JSON.parse(data);
                    if (response.header === "OK") {
                        $("#stock_val" + id_art).text(response.new_stock);
                        $("#remaining_val" + id_art).text(response.new_remaining);
                        $("#refill" + id_art).val(0);
                        Swal.fire('Success!', 'Stock è stato refillato.', 'success');
                    } else {
                        Swal.fire('Error!', 'Qualcosa non è andato bene', 'error');
                    }
                    $("#spin_art" + id_art).hide();
                },
                error: function() {
                    Swal.fire('Error!', 'Errore occorso durante il refill.', 'error');
                    $("#spin_art" + id_art).hide();
                }
            });
        }
    });
}