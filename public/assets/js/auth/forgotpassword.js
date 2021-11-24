$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $("#forgot-password").on("click", function() {
        showModal()
    })

    $("#forgot-password-form").on("submit", function(event){
        if(!verifyPassword()) {
            event.preventDefault()
        }
        if($("#password").val() !== $("#newpassword").val()){
            event.preventDefault()
            bootbox.alert({
                size: 'small',
                backdrop: true,
                message: "As senhas não conferem",
                title: "Atenção!!",
                centerVertical: true,
                show: true,
            })
        }
    })

    
    $('.eye').click(function(){
        let input = document.querySelector('#password');
        let i = document.querySelector('#icon');
  
        if(input.getAttribute('type') == 'password'){
            input.setAttribute('type', 'text');
            i.setAttribute('class', 'mdi mdi-eye-off-outline');
        } else {
            input.setAttribute('type', 'password');
            i.setAttribute('class', 'mdi mdi-eye-outline');
        }
      })
  
      $('.eye2').click(function(){
        let input = document.querySelector('#password_confirm');
        let i = document.querySelector('#icon2');
  
        if(input.getAttribute('type') == 'password'){
            input.setAttribute('type', 'text');
            i.setAttribute('class', 'mdi mdi-eye-off-outline');
        } else {
            input.setAttribute('type', 'password');
            i.setAttribute('class', 'mdi mdi-eye-outline');
        }
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

function response_modal(msg) {
    bootbox.alert({
        size: 'small',
        backdrop: true,
        message: msg,
        title: "Atenção!!",
        centerVertical: true,
        show: true,
        callback: function() {
            window.location.href = "/"
        }
    })
}

function verifyPassword() 
{
	var numbers = /([0-9])/;
	var uppercase = /([A-Z])/;
	var chEspeciais = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    var lowercase = /([a-z])/
    var ok = true;

  $("#password-status").show();
  var password = $('#password').val()

  if(password.match(uppercase)){
    validate("uppercase")
  }

  if(!password.match(uppercase)){
    ok = false
    novalidate("uppercase")
  }

  if(password.match(numbers)){
    validate("number")
  }

  if(!password.match(numbers)){
    ok = false
    novalidate("number")
  }

  if(password.match(chEspeciais)){
    validate("special")
  }

  if(!password.match(chEspeciais)){
    ok = false
    novalidate("special")
  }

  if(password.match(lowercase)){
    validate("lowercase")
  }
  if(!password.match(lowercase)){
    ok = false
    novalidate("lowercase")
  }

  return ok
}


function matchPassword() {

}


function validate(item) {
  $("#" + item).css("color", "green")
  $("#" + item).children().removeClass("mdi-close-circle")
  $("#" + item).children().addClass("mdi-check-circle")
}

function novalidate(item) {
  $("#" + item).css("color", "red")
  $("#" + item).children().removeClass("mdi-check-circle")
  $("#" + item).children().addClass("mdi-close-circle")
}
