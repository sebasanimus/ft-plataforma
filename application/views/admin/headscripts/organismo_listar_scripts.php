
    <script>
   var table;
    $(document).ready(function(){
		options = {
			"order": [[ 2, "asc" ]],
          "sAjaxSource": "admin/organismos/paginar",
          "columnDefs": [
        	{
                "render": function ( data, type, row ) {
					if(data=='' || data==null){
						return '';
					}
					return  '<div class="img-container"><img src="<?=base_url()?>uploads/organismos/'+data+'"></div>';
                    
                },
                "targets": 1 
          	},{
                "render": function ( data, type, row ) {
                    if(data=='enuso') 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets": 6
         	},{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets":7
         	},{                
                "render": function ( data, type, row ) {
					return  '<a href="admin/organismos/modificar/'+data+'"class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">create</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminar('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                    
                },
				"className": "text-right",
                "targets": 8
          	}]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );

	function accionEliminar(ideliminar){
		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar el Organismo",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/organismos/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminado!',
								text: 'El Organismo ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
      }

  </script>