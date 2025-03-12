ismobile=false

$(document).ready( function () {
  load_allestimento(0)
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
      
    $('#tbl_articoli').DataTable({
    pageLength: 10,
    "scrollX": scroll,
    pagingType: 'full_numbers',
    //dom: 'Bfrtip',
    buttons: [
      'excel', 'pdf'
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

function load_allestimento(value) {
    //value serve per identificare il country
    //nel caso di un utente non loggato fa testo la tendina country valorizzata
    //in caso di utente loggato lo recupero via ajax (quindi in questo caso invio 0)
    let CSRF_TOKEN = $("#token_csrf").val();
    html="<i class='fas fa-spinner fa-spin'></i>"
    $("#div_setup").html(html)
    base_path = $("#url").val();
    timer = setTimeout(function() {	
      fetch(base_path+"/check_allestimento", {
          method: 'post',
          headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
          },
          body: "_token="+ CSRF_TOKEN+"&id_country="+value,
      })
      .then(response => {
          if (response.ok) {
            return response.json();
          }
      })
      .then(resp=>{
          if (resp.header=="OK") {
            console.log(resp.view)
              $("#div_setup").html(resp.view)
          }
          else {
            $("#div_setup").html('')
            alert("Error occurred while setting up")
          }

      })
      .catch(status, err => {
          return console.log(status, err);
      })     

    }, 800)	
}


  function send_request() {
    check=false
    $( ".allestimento" ).each(function( index ) {
        if (this.value.length>0) check=true
    })
    if (check==false) {        
        alert("Please select at last one choice")
        event.preventDefault();
        return false;
    }
    else {
        if (confirm("Are you sure?")) $('#frm_main').submit()
    }
  }