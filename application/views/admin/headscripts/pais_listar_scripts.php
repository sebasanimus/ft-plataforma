
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/paises/paginar",
          "columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
					return  '<a href="admin/paises/modificar/'+data+'"class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">create</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminar('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                    
                },
				"className": "text-right",
                "targets": 3
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );

	function accionEliminar(ideliminar){
		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar al país",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/paises/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminado!',
								text: 'El país ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
      }

  </script>