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
        } 
        //verifica altre casisitiche di validazione
        var check=check_else()
        if (check==true) {
          event.preventDefault()
          event.stopPropagation()          
        }
        form.classList.add('was-validated')

      }, false)
    })
})()


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