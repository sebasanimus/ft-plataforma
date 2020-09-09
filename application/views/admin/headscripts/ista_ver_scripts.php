<script>

	function abrirModalRechazo(){
		$('#rechazoModal').modal('show');
	}

	function rechazar(){
		if($('#motivo').val()==''){
			swal({
				title: "Error",
				text: "Complete todos los campos",
				buttonsStyling: false,
				confirmButtonClass: "btn btn-rose"
			}).catch(swal.noop);
			return;
		}

		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de solicitar revisiones para el ISTA, esta acción no se puede deshacer",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, enviala!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/istas/rechazar", { 
								"idista": <?=$ista['idista']?>,
								"motivo": $('#motivo').val(),
							})
						.done(function( data ) {
							if(data=='1'){
								swal({
									title: '¡Enviada!',
									text: 'El alerta ha sido enviado.',
									type: 'success',
									confirmButtonClass: "btn btn-success",
									buttonsStyling: false
								})
								$('#rechazoModal').modal('hide');
								window.location.reload()
							}else{
								swal({
									title: "Error",
									text: data,
									buttonsStyling: false,
									confirmButtonClass: "btn btn-rose"
								}).catch(swal.noop);
							}
						});					
				}
            }).catch(swal.noop);	
	}
</script>