$(document).ready(function($){
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

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
      
              form.classList.add('was-validated')
            }, false)
          })
      
    })()
	
	$('.eye-login').on("click", function(){
		let input = document.querySelector('#password');
		let i = document.querySelector('#icon');

		if(input.getAttribute('type') == 'password'){
			input.setAttribute('type', 'text');
      console.log(input)
			i.setAttribute('class', 'mdi mdi-eye-off-outline');
		} else {
			input.setAttribute('type', 'password');
			i.setAttribute('class', 'mdi mdi-eye-outline');
		}
	})

  $("#forgot-password").on("click", function() {
    showModal()
  })


})

function showModal() {
  $(".required").css("display", "none");
  var regex = new RegExp(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/);

  msg = "<input type='email' id='input-email'>";
  msg += '<div class="required" style="display: none">  </div>'
  bootbox.dialog({
      size: 'small',
      backdrop: true,
      message: msg,
      title: "Por favor, informe seu email: <br>  ",
      input: "email",
      centerVertical: true,
      show: true,
      buttons: {
          confirm: {
              label: "Enviar",
              callback: function(){
                  var email = $('#input-email').val()
                  if(email === "") {
                      $(".required").html("**Campo obrigatório!");
                      $(".required").show();
                      return false
                  }
                  if(!regex.test(email)){
                      $(".required").html("**Email inválido!");
                      $(".required").show();
                      return false
                  }

                  var route = "/auth/send-email";
                  var data = {
                      'email'  : email,
                  }
                  $.post(route, data, function(response) {
                      if(response.status_code == 200) {
                          if(response.success == false) {
                              error_modal(response.message)
                          } 
                          else {
                              var time_send = new Date().getTime() / 1000;
                              code_modal(time_send, email, response.data.token)
                          }
                      }
                      console.log(response)
                  })
              }
          }
      },
      
  })
}

function error_login(msg) {
	bootbox.alert({
        size: 'small',
        backdrop: true,
        message: msg,
        title: "Atenção!!",
        centerVertical: true,
        show: true,
    })
}
 
 
 
