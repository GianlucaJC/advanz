// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
         // $('#modal_main').modal("show")
        } 
       
        form.classList.add('was-validated')
        if (form.checkValidity() && check==false) $("#btn_send").text('Please wait...')

      }, false)
    })
 
})()


$(document).ready( function () {
    let cookie_healt =getCookie("cookie_healt"); 
    if (!cookie_healt || cookie_healt=="2") {
      
      $("#div_modal").height($(window).height()*0.9);
  
      $('#div_modal').modal({backdrop: 'static', keyboard: false})  
      $("#div_modal").modal('show')
      
    } 
  
    
    
  })
  
  function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
  
  function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  
  function set_c(value) {
    setCookie("cookie_healt",value,365)
    
    if (value=="2") {
      window.location.href = "https://www.advanzpharma.com/";
    } else {
      $('#div_modal').modal("hide")
  
    }
  }