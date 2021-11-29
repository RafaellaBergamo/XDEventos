$(document).ready(function($){

	(function () {
        'use strict'
      
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')


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
  const regex = new RegExp(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/);

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
                $("body").css("cursor", "wait")
                  let email = $('#input-email').val()
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

                  let route = "/auth/send-email";
                  let data =  {
                    'email'  : email,
                    '_token'  : $("#token").val()
                  }

                  $.post(route, data, function(response) {
                    $("body").css("cursor", "default")
                    if(response.status_code == 200) {
                        if(response.success == false) {
                          error_modal(response.message)
                        } 
                        else {
                          let time_send = new Date().getTime() / 1000;
                          code_modal(time_send, email, response.data.token)
                        }
                    }
                  })
              }
          }
      },
      
  })
}

function error_modal(msg) {
  bootbox.alert({
      size: 'small',
      backdrop: true,
      message: msg,
      title: "Atenção!!",
      centerVertical: true,
      show: true,
  })
}

function code_modal(time, email, token){
  var msg = document.createElement('div')
  msg.innerHTML = '<p class="text-left"> Um código foi enviado para o email: </p> ';
  msg.innerHTML += '<p class="text-center"> <strong>'+ email +'</strong> </p>'
  msg.innerHTML += '<p class="text-left">  Por favor, coloque-o no espaço abaixo para confirmar que esse e-mail é seu. </p>';
  msg.innerHTML += '<p class="text-center"> <input maxlength="6" placeholder="Digite o código aqui"  type="text" pattern="[0-9]+$" id="code"></p> '

  bootbox.confirm({
      size: 'small',
      backdrop: false,
      message: msg,
      title: "Confirme seu email!",
      centerVertical: true,
      show: true,
      callback: function(){
          var code = $("#code").val()
          if(code !== "") {
              console.log(code, token)
              if(code !== token) {
                  bootbox.alert("Código inválido", {
                      size: 'small'
                  });
              }
              else {
                  window.location.href = "/auth/change-password/" + encodeURIComponent(email);
              }
          }
      }
  })
}
 
 
 
