$(document).ready( function () {
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