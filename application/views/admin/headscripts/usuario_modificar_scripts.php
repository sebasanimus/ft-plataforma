<script>
var password = document.getElementById("password")
  , confirm_password = document.getElementById("password-confirm");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Los password no coinciden");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

$(document).ready(function(){
	ocultarCampos();
	$('#idpropuestas').select2({
		ajax: {
			url: function (params) {
				return '<?=base_url()?>admin/propuestas/select/' + params.term;
			},
			delay: 500 ,// wait 500 milliseconds before triggering the request
			processResults: function (data) {
				var datos = JSON.parse(data);
				return {
					results: datos.results
				};
			}	
		},
		minimumInputLength: 1
	});
});

function ocultarCampos(){
	if($('#idtipousuario').val()==2){
	}else{
	}
}
</script>
