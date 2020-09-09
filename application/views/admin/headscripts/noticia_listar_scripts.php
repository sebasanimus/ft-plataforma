
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/noticias/paginar/<?=$idpropuesta?>",
          "columnDefs": [
            {
                "render": function ( data, type, row ) {
					return  '<div class="img-container"><img src="<?=base_url()?>uploads/noticias/400_'+data+'"></div>';
                    
                },
				"bSortable" : false,
                "targets": 0 
          },{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets": 4
          },{
				"visible": false,
                "targets": 5
          },{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets": 6
          },{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-primary">Noticia</span>';
					return '<span class="badge badge-pill badge-info">Blog</span>';	
                    
                },
                "targets": 7
          },{                
                "render": function ( data, type, row ) {
					var dat = data.split("***");
					return  '<a href="<?=base_url()?>noticias/'+dat[0]+'/es/'+row[5]+'" class="btn btn-link btn-info btn-just-icon" title="Ver Online" target="_blank" ><i class="material-icons">open_in_new</i></a> &nbsp;'+
						   '<a href="<?=base_url()?>admin/noticias/modificar/'+dat[1]+'/'+dat[0]+'" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">create</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminar('+dat[0]+','+dat[1]+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                    
                },
				"className": "text-right",
                "targets": 8
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );

	function accionEliminar(ideliminar, idpropuesta){
		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar la noticia",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminala!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/noticias/eliminar/"+idpropuesta, { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminada!',
								text: 'La noticia ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
    }


  </script>