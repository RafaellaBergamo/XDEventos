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

})


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
 
 
 
