

$(document).ready(function($){

   
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
            $("#city").children().remove();
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
                    var option = '<option value=""></option>';
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

    $("#table-users").DataTable({
        dom: "tpr",
        pageLength: '10'
    })

    $(".cancel-new-user").on("click", function(){
        window.location.href = "/users"
    })

    $("#table-users").on("click", "td", function()
    {
        var id = $(this).parent().data('id')
        var index = $(this).index()

        if(index == 0) {
            window.location.href = "/users/update-user/" + id
        }
        if(index == 1) {
            modal_delete(id)
        }
    })  

    $("#users-form").on("reset", function(){
        $("#city").prop("disabled", true);
    })

    $("#users-form").on("submit", function(event){
        if(!verifyPassword()) {
            event.preventDefault()
        }
    })


})

function enabledNewPassword() {
    if($("#oldpassword").val() !== "")
        $("#password").attr("readonly", false)
    else $("#password").attr("readonly", true)
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

function modal_delete(id){
    bootbox.confirm({
        message: "Você deseja mesmo excluir esse usuário?",
        title: "Atenção!",
        centerVertical: true,
        backdrop: true,
        size: 'small',
        buttons: {
            confirm: {
                label: 'Sim',
                className: 'btn-danger'
            },
            cancel: {
                label: 'Cancelar',
                className: 'btn-secondary'
            }
        },
        callback: function(val){
            if(val){
                deleteClient(id)
            }
        }
       
    })
}


function deleteClient(id) {
    $("body").css("cursor", "wait")
    var data = {
        '_token' : $("#token").val(),
        'id' : id
    }

    $.post('/users/delete-user', data, function(response) {
        $("body").css("cursor", "default")
        if(response.status_code === 200) {
            if(response.success) {
                bootbox.alert({
                    message: "Usuário deletado com sucesso!",
                    title: " ",
                    centerVertical: true,
                    size: 'small',
                    callback: function(){
                        window.location.reload(true)
                    }
                })
            }
            else {
                bootbox.alert({
                    message: "Ocorreu um erro ao deletar usuário! Tente novamente mais tarde.",
                    centerVertical: true,
                    size: 'small',
                })
            }
        }
    })
}

function response_modal($message){
    bootbox.alert({
        size: 'small',
        backdrop: true,
        message: $message,
        title: "Atenção!",
        centerVertical: true,
        show: true,
        callback: function(){
            window.location.href = "/users"
        }
      })
}

