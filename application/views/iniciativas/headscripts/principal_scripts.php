<script>
	function anotarse(idiniciativa){
		  swal({
                title: '¿Está Seguro?',
                text: "Está a punto de anotarse en la iniciativa",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "iniciativas/perfiles/anotarse", { "idiniciativa": idiniciativa })
						.done(function( data ) {
							var datos = JSON.parse(data);
							if(datos.error==''){
								window.location.href = datos.url;
							}else{
								alert(datos.error);
							}
						});
					
				}
            }).catch(swal.noop);
    }
</script>