

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

    $("#table-clients").DataTable({
        dom: "tipr",
        pageLength: '10'
    })

    $(".cancel-new-client").on("click", function(){
        window.location.href = "/clients"
    })

    $("#table-clients").on("click", "td", function()
    {
        var id = $(this).parent().data('id')
        var index = $(this).index()

        if(index == 0) {
            window.location.href = "/clients/update-client/" + id
        }
        if(index == 1) {
            modal_delete(id)
        }
    })  

    $("#clients-form").on("reset", function(){
        $("#city").prop("disabled", true);
    })
})

function modal_delete(id){
    bootbox.confirm({
        message: "Você deseja mesmo excluir esse cliente?",
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

    $.post('/clients/delete-client', data, function(response) {
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
                    message: "Ocorreu um erro ao deletar cliente! Tente novamente mais tarde.",
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
            window.location.href = "/clients"
        }
      })
}