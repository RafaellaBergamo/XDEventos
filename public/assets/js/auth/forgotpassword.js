$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    
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
