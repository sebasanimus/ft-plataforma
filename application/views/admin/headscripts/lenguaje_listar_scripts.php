<? $link=(!empty($esapp))? 'lenguajesapp' : 'lenguajes'; ?>
    <script>
   var table;
    $(document).ready(function(){
        options = {
            "sAjaxSource": "admin/<?=$link?>/paginar/",
            "columnDefs": [
                {
                    "render": function ( data, type, row ) {
                        if(data==1) 
							return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
						return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';
                        
                    },
					<?if(!empty($esapp)): ?> 
					"visible": false,
					<?endif?>
                    "targets": 3

                },{
                    // The `data` parameter refers to the data for the cell (defined by the
                    // `data` option, which defaults to the column being worked with, in
                    // this case `data: 0`.
                    "render": function ( data, type, row ) {
						var retorno = '';
						<?if(empty($esapp)):?> retorno += '<a href="admin/<?=$link?>/modificar/'+data+'" class="btn btn-link btn-info btn-just-icon" title="Modificar"><i class="material-icons">create</i></a></a> &nbsp;';<?endif?>
						 return retorno;
                        
                    },
					"className": "text-right",
                    "targets": 4
            }]
        }
        jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );


      function accionEliminar(ideliminar){
		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de lenguaje al usuario",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/lenguaje/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminado!',
								text: 'El usuario ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
      }
  </script>