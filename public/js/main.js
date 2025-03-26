// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        var check_no=false
        if (!form.checkValidity()) {
          check_no=true
          event.preventDefault()
          event.stopPropagation()
          $('#modal_main').modal("show")
        } 
        if (check_no==false) {
          //verifica altre casisitiche di validazione
          var check=check_else()
          if (check==true) {
            check_no=true
            event.preventDefault()
            event.stopPropagation()       
            $('#modal_main').modal("show")
          }
        } 
        if (check_no==false) {
          //recapcha
          var check=false
          var response = grecaptcha.getResponse();
          if(response.length == 0){
            event.preventDefault()
            event.stopPropagation()
            alert("reCaptcha not verified!")
          } else check=true
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

  $('#view_pw').on('change', function(){
    $('.pw').attr('type',$('#view_pw').prop('checked')==true?"text":"password"); 
  });

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
  setCookie("cookie_healt",value,1)
  
  if (value=="2") {
    window.location.href = "https://www.advanzpharma.com/";
  } else {
    $('#div_modal').modal("hide")

  }
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
    
    //load allestimento per il country
    load_allestimento(value)      
}

function load_allestimento(value) {
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



function check_choice(id_molecola,id,value) {
  $(".molecola"+id_molecola).prop('disabled',false);
  if (value.length>0) {
    $(".molecola"+id_molecola).prop('disabled',true);
    $("#"+id).prop('disabled',false);
}

  
}
