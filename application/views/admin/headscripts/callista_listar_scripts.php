
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/callistas/paginar",
          "columnDefs": [
           {                
                "render": function ( data, type, row ) {
					return  '<a href="<?=base_url()?>admin/istas/listar/'+data+'" class="btn btn-link btn-info btn-just-icon" title="Ver Istas cargados" ><i class="material-icons">input</i></a> &nbsp;'+
                           '<a href="<?=base_url()?>admin/callistas/modificar/'+data+'" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">create</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminar('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                    
                },
				"className": "text-right",
                "targets": 5
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );

	function accionEliminar(ideliminar){
		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar el llamado",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/callistas/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminada!',
								text: 'El llamado ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
    }


  </script>