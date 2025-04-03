ismobile=false

$(document).ready( function () {
  
  if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
    ismobile=true
  else
    ismobile=false
  
   set_table()
})

  function set_table() {
    scroll=false;
    if (ismobile==true)  scroll=true
      
    $('#tbl_articoli tfoot th').each(function () {
      var title = $(this).text();
      if (title.length!=0) {
        style='style="max-width:80px;"'
        if (title=="ID") style='style="max-width:30px;"'
              placeholder="' + title + '"
        $(this).html('<input class="form-control" '+style+' type="text"  />');
      }
    });    
    $('#tbl_articoli').DataTable({
      pageLength: 10,
      "scrollX": scroll,
      pagingType: 'full_numbers',
      dom: 'Bfrtip',
      buttons: [
        'excel'
      ],		
      initComplete: function () {
        // Apply the search
        this.api()
            .columns()
            .every(function () {
                var that = this;
  
                $('input', this.footer()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
      },      		
      /*
      language: {
          lengthMenu: 'Visualizza _MENU_ records per pagina',
          zeroRecords: 'Nessuna urgenza trovata',
          info: 'Pagina _PAGE_ di _PAGES_',
          infoEmpty: 'Non sono disponibili urgenze',
          infoFiltered: '(Filtrati da _MAX_ urgenze totali)',
      },
      */
  });	
    
}



