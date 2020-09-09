
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/webstories/paginar",
          "columnDefs": [
            {
                "render": function ( data, type, row ) {
					return  '<div class="img-container"><img src="<?=base_url()?>uploads/webstories/400_'+data+'"></div>';
                    
                },
				"bSortable" : false,
                "targets": 0 
          },{
                "render": function ( data, type, row ) {
					var d = data.split('**');
					return '<a href="admin/webstories/ver/'+row[4]+'">'+d[0]+'</a><br /><small>'+d[1]+'</small>';
                    
                },
                "targets": 1
          },{
                "render": function ( data, type, row ) {
					var d = data.split('**');
					return '<a href="admin/webstories/ver/'+row[4]+'">'+d[0]+'</a><br /><small>'+d[1]+'</small>';
                    
                },
                "targets": 2
          },{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets": 3
          },{
                "render": function ( data, type, row ) {
					var url = row[2].split('**');
					return '<a href="admin/webstories/ver/'+data+'" class="btn btn-link btn-info btn-just-icon" title="Ver" ><i class="material-icons">remove_red_eye</i></a> &nbsp;'+
						   '<a href="<?=base_url()?>webstories/'+url[1]+'" class="btn btn-link btn-info btn-just-icon" title="Ver Online (interno)" target="_blank" ><i class="material-icons">open_in_new</i></a> &nbsp;'+
						   '<a href="<?=LINK_WEBSTORIES?>'+url[1]+'" class="btn btn-link btn-info btn-just-icon" title="Ver Online Para Compartir" target="_blank" ><i class="material-icons">share</i></a> &nbsp;'+
						   '<a href="<?=base_url()?>exportarposter/generarPDF/'+url[1]+'/es" class="btn btn-link btn-success btn-just-icon" title="Generar y Ver Poster (Español)" target="_blank" ><i class="material-icons">book</i></a> &nbsp;'+
						   '<a href="<?=base_url()?>exportarposter/generarPDF/'+url[1]+'/en" class="btn btn-link btn-primary btn-just-icon" title="Generar y Ver Poster (Inglés)" target="_blank" ><i class="material-icons">book</i></a> &nbsp;'+
					<?if($this->session->userdata('role')==1):?>	   
                        	'<a href="javascript:accionEliminar('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Deshabilitar" ><i class="material-icons">close</i></a> &nbsp;';
                    <?else:?>
							'';
					<?endif?>
				},
				"className": "text-right",
                "targets": 4
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );


	function accionEliminar(ideliminar){
		  swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar la webstory",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminala!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/webstories/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: 'Eliminada!',
								text: 'La webstory ha sido eliminada.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
    }

  </script>