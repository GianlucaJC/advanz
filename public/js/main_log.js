$(document).ready( function () {
  load_allestimento(0)
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
    $( ".mole" ).each(function( index ) {
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