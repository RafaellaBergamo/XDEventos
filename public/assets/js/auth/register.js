$(document).ready(function(){

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
    
    $("#state").on("change", function(){
        var uf = $("#state").val();

        if(uf == "") {
            $("#city").prop("disabled", true);
            $("#state").children().remove();
        }
        else {
            $('body').css('cursor', 'wait')
            var token = $("#token").val()
            let data = {
                'state': uf,
                '_token': token
            }
            let route = "/auth/get-cities"

            $.post(route, data, function(response){
                $('body').css('cursor', 'default')
                if(response.status_code === 200) {
                    $("#city").prop("disabled", false);
                    var option = '<option value="">Cidade</option>';
                    var count = 0;

                    $.each(response.cities, function (i, city) {
                      option += '<option value="' + city['nome'] + '"> ' + city['nome'] + '</option>';
                      count++;
                    });
                    $('#city').html(option).show();
                }
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

    $("#form-register").on("submit", function(event){
      if(!verifyPassword()) 
        event.preventDefault()
    })
})

function response_modal($message){
    bootbox.alert({
        size: 'small',
        backdrop: true,
        message: $message,
        title: "Atenção!",
        centerVertical: true,
        show: true,
        callback: function(){
            window.location.href = "/login"
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