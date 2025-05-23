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


  $('#tbl_art_liof').DataTable({
    order: [[0, 'desc']],
    pageLength: 10,
    "scrollX": scroll,
    pagingType: 'full_numbers',
    dom: 'Bfrtip',
    buttons: [
      'excel'
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

function save_art_liof(id_art) {
  let CSRF_TOKEN = $("#token_csrf").val();
  $("#spin_art"+id_art).show(100)
  let spin = document.getElementById("spin_art"+id_art);
  spin.removeAttribute("hidden");
  cod_liof=$("#cod_liof"+id_art).val()
  description=$("#description"+id_art).val()
  stock=$("#stock"+id_art).val()


  base_path = $("#url").val();

  timer = setTimeout(function() {	
    fetch(base_path+"/update_art_liof", {
        method: 'post',
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "_token="+ CSRF_TOKEN+"&id_art="+id_art+"&cod_liof="+cod_liof+"&description="+description+"&stock="+stock,
    })
    .then(response => {
        if (response.ok) {
          return response.json();
        }
    })
    .then(resp=>{
        spin.setAttribute("hidden", "hidden");
        if (resp.header=="OK") {
          
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

function save_info(id_ordine) {
    let CSRF_TOKEN = $("#token_csrf").val();
    $("#spin"+id_ordine).show(100)
    let spin = document.getElementById("spin"+id_ordine);
    spin.removeAttribute("hidden");
    stato=$("#stato"+id_ordine).val()
    tracker=$("#tracker"+id_ordine).val()
    ship_date=$("#ship_date"+id_ordine).val()
    ship_date_estimated=$("#ship_date_estimated"+id_ordine).val()

    base_path = $("#url").val();

    timer = setTimeout(function() {	
      fetch(base_path+"/update_order", {
          method: 'post',
          headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
          },
          body: "_token="+ CSRF_TOKEN+"&id_ordine="+id_ordine+"&stato="+stato+"&tracker="+tracker+"&ship_date="+ship_date+"&ship_date_estimated="+ship_date_estimated,
      })
      .then(response => {
          if (response.ok) {
            return response.json();
          }
      })
      .then(resp=>{
          spin.setAttribute("hidden", "hidden");
          if (resp.header=="OK") {
            
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