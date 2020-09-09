
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/perfiles/paginar/<?=$idiniciativa?>",
		  "order": [[ 0, "desc" ]],
          "columnDefs": [
			{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets": 7
          },{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets": 8
          },{                
                "render": function ( data, type, row ) {
					return  '<a href="javascript:abrirModalEstado('+data+', \''+row[6]+'\', \''+row[1]+'\')" class="btn btn-link btn-warning btn-just-icon" title="Modificar Estado" ><i class="material-icons">local_offer</i></a> &nbsp;'+
							'<a href="<?=base_url()?>admin/perfiles/ver/'+data+'" class="btn btn-link btn-info btn-just-icon" title="Ver" ><i class="material-icons">remove_red_eye</i></a> &nbsp;'+
							'<a href="<?=base_url()?>admin/exportarpdf/generarPerfil/'+data+'" class="btn btn-link btn-info btn-just-icon" title="PDF" ><i class="material-icons">picture_as_pdf</i></a> &nbsp;';
                    
                },
				"className": "text-right",
                "targets": 9
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );

	
	function abrirModalNotificacion(){
		$('#alertaModal').modal('show');
	}


	function crearAlerta(){
		if($('#al_quienes').val()=='' || $('#al_titulo').val()=='' || $('#al_contenido').val()==''){
			swal({
				title: "Error",
				text: "Complete todos los campos",
				buttonsStyling: false,
				confirmButtonClass: "btn btn-rose"
			}).catch(swal.noop);
			return;
		}

		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de crear la alerta, esta acción no se puede deshacer",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, enviala!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/perfiles/crearAlerta", { 
								"idiniciativa": $('#al_idiniciativa').val(),
								"quienes": $('#al_quienes').val(),
								"titulo": $('#al_titulo').val(),
								"contenido": $('#al_contenido').val(),
							})
						.done(function( data ) {
							if(data=='1'){
								swal({
									title: '¡Enviada!',
									text: 'El alerta ha sido enviado.',
									type: 'success',
									confirmButtonClass: "btn btn-success",
									buttonsStyling: false
								})
								$('#alertaModal').modal('hide');
							}else{
								swal({
									title: "Error",
									text: data,
									buttonsStyling: false,
									confirmButtonClass: "btn btn-rose"
								}).catch(swal.noop);
							}
						});					
				}
            }).catch(swal.noop);
	}

	var estados = [];
	<?foreach($estados as $estado):?>
		estados['<?=$estado['nombre']?>'] = <?=$estado['idestadoperfil']?>;
	<?endforeach?>

	function abrirModalEstado(idperfil, estado, titulo){
		$('#es_idperfil').val(idperfil);
		$('#es_titulo').html(titulo);
		$('#es_estado').selectpicker('val', estados[estado]);
		$('#estadoModal').modal('show');
	}

	function cambiarEstado(){
		$.post( "admin/perfiles/cambiarEstado", { 
				"idperfil": $('#es_idperfil').val(),
				"idestado": $('#es_estado').val()
			})
		.done(function( data ) {
			$('#estadoModal').modal('hide');
			table.ajax.reload();
		});
	}
	
  </script>