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
      
    $('#tbl_articoli').DataTable({
    pageLength: 10,
    "scrollX": scroll,
    pagingType: 'full_numbers',
    //dom: 'Bfrtip',
    buttons: [
      'excel', 'pdf'
    ],		
      		
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



