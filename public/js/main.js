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
          $('#modal_main').modal("show")
        } 
        //verifica altre casisitiche di validazione
        var check=check_else()
        if (check==true) {
          event.preventDefault()
          event.stopPropagation()       
          $('#modal_main').modal("show")
        }
        form.classList.add('was-validated')
        if (form.checkValidity() && check==false) $("#btn_reg").text('Please wait...')

      }, false)
    })


  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation1')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        } 
        form.classList.add('was-validated')

      }, false)
    })    

    
})()

$(document).ready( function () {
  let cookie_healt =getCookie("cookie_healt"); 
  if (!cookie_healt || cookie_healt=="2") {
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
  } else $('#div_modal').modal("hide")
}
function check_else() {
  password=$("#password").val()
  password2=$("#password2").val()

  if (password!=password2) {
    alert("The two passwords do not match!")
    return true
  }
  $("#err_pw").hide()

  if (checkPwd(password)<4) {
    $("#err_pw").show()
    return true  
  }

  return false
}

function checkPwd(pwd) {
  if (pwd.length > 15) {
      console.log(pwd + " - Too lengthy");
      return 1 
  } else if (pwd.length < 8) {
      console.log(pwd + " - Too short");
      return 2 
  }

  const checks = [
      /[a-z]/,     // Lowercase
      /[A-Z]/,     // Uppercase
      /\d/,        // Digit
      /[@.#$!%^&*.?]/ // Special character
  ];
  let score = checks.reduce((acc, rgx) => acc + rgx.test(pwd), 0);
  return score
}

function select_terms(value) {

    $("#a_terms").removeAttr("target");
    $("#a_terms").removeAttr("href");
    $('#read_terms').prop('disabled',true);$('#btn_reg').prop('disabled',true);
    
    if (value.length>0) {
      $("#a_terms").prop("target", "_blank");
      
    } else $('#read_terms').prop('checked',false);

    if (value==2)
      $("#a_terms").attr("href","doc/AVEP Terms & Conditions_ADVANZ PHARMA_FRANCE.pdf"); 
    if (value==3)
      $("#a_terms").attr("href","doc/2024 06 19 AVEP Terms & Conditions_ADVANZ PHARMA_GERMANY& AUSTRIA.pdf"); 
    if (value==4)
      $("#a_terms").attr("href","doc/AVEP Terms & Conditions_ADVANZ PHARMA_DENMARK.pdf"); 
    if (value==5)
      $("#a_terms").attr("href","doc/2024 06 19 AVEP Terms & Conditions_ADVANZ PHARMA_GERMANY& AUSTRIA.pdf"); 
    if (value==6)
      $("#a_terms").attr("href","doc/AVEP Terms & Conditions_ADVANZ PHARMA_IRELAND.pdf"); 
    if (value==7)
      $("#a_terms").attr("href","doc/AVEP Terms & Conditions_ADVANZ PHARMA_SP.pdf"); 
    if (value==8)
      $("#a_terms").attr("href","doc/AVEP Terms & Conditions_ADVANZ PHARMA_UK.pdf"); 
      
}


function check_choice(id_molecola,id,value) {
  $(".molecola"+id_molecola).prop('disabled',false);
  if (value.length>0) {
    $(".molecola"+id_molecola).prop('disabled',true);
    $("#"+id).prop('disabled',false);
  }

  
}
