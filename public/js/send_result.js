ismobile=false

$(document).ready( function () {
  
  if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
    ismobile=true
  else
    ismobile=false
  
   set_table()
})



  function delete_up(id_up) {
    if (!confirm('Are you sure?')) return false;
    let CSRF_TOKEN = $("#token_csrf").val();
    $("#spin"+id_up).show(100)
    base_path = $("#url").val();

    timer = setTimeout(function() {	
      fetch(base_path+"/delete_up", {
          method: 'post',
          headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
          },
          body: "_token="+ CSRF_TOKEN+"&id_up="+id_up,
      })
      .then(response => {
          if (response.ok) {
            return response.json();
          }
      })
      .then(resp=>{
          $("#spin"+id_up).hide(100)
          if (resp.header=="OK") {
            $(".divup"+id_up).remove()
          }
          else {
            alert("Error occurred while deleting file")
          }

      })
      .catch(status, err => {
          return console.log(status, err);
      })     

    }, 800)	    
  }
  
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



