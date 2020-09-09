
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/mapas/paginar/<?=$idpropuesta?>",
          "columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
					return  '<a href="<?=base_url()?>admin/mapas/editarElementos/'+data+'" class="btn btn-link btn-info btn-just-icon" title="Editar Áreas" ><i class="material-icons">room</i></a> &nbsp;'+
							'<a href="javascript:accionModificarMapa('+data+');" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">create</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminarMapa('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                    
                },
				"className": "text-right",
                "targets": 2
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );

	function accionEliminar(ideliminar){
		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar el mapa",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/mapas/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminado!',
								text: 'El mapa ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
    }

	function abrirModalMapa(){
		if($('#map_idmapa').val()>0){
			vaciarModalMapa();
		}
		$('#map_idmapa').val(0);
		$('#mapaModal').modal('show');
	}

	function vaciarModalMapa(){
		$('#map_nombre_es').val('');
		$('#map_nombre_en').val('');
		$('#map_descripcion_es').val('');
		$('#map_descripcion_en').val('');
		$('#map_btn').html('Agregar');
	}

	function agregarMapa(){
		$.post( "admin/mapas/agregarMapa", $("#map_form").serialize())
			.done(function( data ) {
				if(data!=''){
					swal({
						title: "Error",
						text: data,
						type: 'error',
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}else{
					$('#mapaModal').modal('hide');
					table.ajax.reload();
					vaciarModalMapa();
				}	
			})
	}

	function accionModificarMapa(idmodificar){
		$.post( "admin/mapas/obtenerMapa/<?=$idpropuesta?>", { "idmapa": idmodificar })
			.done(function( data ) {
				var datos = JSON.parse(data);
				$('#map_idmapa').val(datos.idmapa);
				<?foreach($lenguajes as $lenguaje):?>
					$('#map_nombre_<?=$lenguaje->codlang?>').val(datos.nombre_<?=$lenguaje->codlang?>);
					$('#map_descripcion_<?=$lenguaje->codlang?>').val(datos.descripcion_<?=$lenguaje->codlang?>);
				<?endforeach?>

				$('#map_btn').html('Modificar');
				$('#mapaModal').modal('show');
			});		
	}

	function accionEliminarMapa(ideliminar){
		swal({
				title: '¿Está Seguro?',
				text: "Está a punto de eliminar el mapa",
				type: 'warning',
				showCancelButton: true,
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				confirmButtonText: 'Si, eliminalo!',
				buttonsStyling: false
			}).then(function(result) {
				if (result.value) {
					$.post( "admin/mapas/eliminarMapa/<?=$idpropuesta?>", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminado!',
								text: 'El mapa ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
			}).catch(swal.noop);
	}

  </script>