
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/propuestas/paginar",
          "columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
					return  '<span style="float:right">'+data+'</span>';
                    
                },
                "targets": 6 
          	},{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets": 5
          	},{
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
					<?if($this->session->userdata('role')==3):?>
					return 	'<a href="admin/propuestas/depurar/'+data+'" class="btn btn-link btn-warning btn-just-icon" title="Depurar" ><i class="material-icons">edit</i></a>&nbsp;';
					<?endif?>
					<?if($this->session->userdata('role')==4):?>
					return 	'<a href="admin/propuestas/investigador/'+data+'" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">edit</i></a>&nbsp;'+
                           '<a href="admin/mapas/listar/'+data+'"class="btn btn-link btn-warning btn-just-icon" title="Mapas" ><i class="material-icons">place</i></a>&nbsp;'+
                           '<a href="admin/noticias/listar/'+data+'"class="btn btn-link btn-warning btn-just-icon" title="Noticias" ><i class="material-icons">post_add</i></a>&nbsp;';
					<?endif?>
					return '<a href="admin/propuestas/ver/'+data+'" class="btn btn-link btn-info btn-just-icon" title="Ver" ><i class="material-icons">remove_red_eye</i></a>&nbsp;'+
                           '<a href="admin/mapas/listar/'+data+'"class="btn btn-link btn-warning btn-just-icon" title="Mapas" ><i class="material-icons">place</i></a>&nbsp;'+
                           '<a href="admin/noticias/listar/'+data+'"class="btn btn-link btn-warning btn-just-icon" title="Noticias" ><i class="material-icons">post_add</i></a>&nbsp;'+
                           '<a href="javascript:accionEliminar('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a>&nbsp;';
                    
				},
				"className": "text-right",
                "targets": 7
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );

	function accionEliminar(ideliminar){
		  swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar la propuesta",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminala!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/propuestas/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminada!',
								text: 'La unidad ha sido eliminada.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
      }

  </script>