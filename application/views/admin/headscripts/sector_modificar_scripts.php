
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/sectores/paginarSubsector/<?=$idsector?>",
		  "pageLength": 50,
          "columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
					return '<a href="javascript:accionModificar('+data+');" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">edit</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminar('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                },
				"className": "text-right",
                "targets": 1
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );

	function accionEliminar(ideliminar){
		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar al subsector",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/sectores/eliminarSubsector", { "ideliminar": ideliminar })
						.done(function( data ) {
							if(data==''){
								table.ajax.reload();
								swal({
									title: '¡Eliminado!',
									text: 'El subsector ha sido eliminado.',
									type: 'success',
									confirmButtonClass: "btn btn-success",
									buttonsStyling: false
								});
							}else{
								swal({
									title: 'Error!',
									text: data,
									type: 'error',
									confirmButtonClass: "btn btn-success",
									buttonsStyling: false
								});
							}
						});
					
				}
            }).catch(swal.noop);
    }

	function accionModificar(idmodificar){
		$.post( "admin/sectores/obtenerSubsector/", { "idsubsector": idmodificar })
			.done(function( data ) {
				var datos = JSON.parse(data);
				$('#sub_idsubsector').val(datos.idsubsector);
				<?foreach($lenguajes as $lenguaje):?>
				$('#sub_nombre_<?=$lenguaje->codlang?>').val(datos.nombre_<?=$lenguaje->codlang?>);
				<?endforeach?>

				$('#sub_btn').html('Modificar');
				$('#subsectorModal').modal('show');
			});		
	}

	function abrirModal(){
		if($('#sub_idsubsector').val()>0){
			vaciarModal();
		}
		$('#sub_idsubsector').val(0);
		$('#subsectorModal').modal('show');
	}

	function vaciarModal(){
		$('#sub_nombre_es').val('');
		$('#sub_nombre_en').val('');
		$('#ind_btn').html('Agregar');
	}

	function agregarSubsector(){
		$.post( "admin/sectores/agregarSubsector", $("#sub_form").serialize())
			.done(function( data ) {
				if(data!=''){
					swal({
						title: "Error",
						text: data,
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}else{
					$('#subsectorModal').modal('hide');
					table.ajax.reload();
					vaciarModal();
				}	
			})
	}

  </script>