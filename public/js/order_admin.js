ismobile=false

$(document).ready( function () {
 
  if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
    ismobile=true
  else
    ismobile=false
  
   set_table()
})

function check_choice(id_molecola,id,value) {
    $(".molecola"+id_molecola).prop('disabled',false);
    $(".molecola"+id_molecola).val('')
    if (value.length>0) {
      $(".molecola"+id_molecola).prop('disabled',true);
      $("#"+id).prop('disabled',false);
      $("#"+id).val(value)
    }
  
    
  }

  
  function set_table() {
    scroll=false;
    if (ismobile==true)  scroll=true
      

    $('#tbl_order tfoot th').each(function () {
        var title = $(this).text();
		if (title.length!=0) {
			style='style="max-width:80px;"'
			if (title=="ID") style='style="max-width:30px;"'
            placeholder="' + title + '"
			$(this).html('<input class="form-control" '+style+' type="text"  />');
		}
    });	
        
    $('#tbl_articoli, #tbl_order').DataTable({
    order: [[0, 'desc']],
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


function save_info(id_ordine) {
    let CSRF_TOKEN = $("#token_csrf").val();
    $("#spin"+id_ordine).show(100)
    let spin = document.getElementById("spin"+id_ordine);
    spin.removeAttribute("hidden");
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
          body: "_token="+ CSRF_TOKEN+"&id_ordine="+id_ordine+"&tracker="+tracker+"&ship_date="+ship_date+"&ship_date_estimated="+ship_date_estimated,
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