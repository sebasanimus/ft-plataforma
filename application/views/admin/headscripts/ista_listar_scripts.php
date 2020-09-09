
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/istas/paginar/<?=$idcallista?>",
		  "order": [[ 0, "desc" ]],
          "columnDefs": [
			{
                "render": function ( data, type, row ) {
                    if(data=='') 
						return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-success" title="'+data+'"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
						
                    
                },
                "targets": 4
          },{                
                "render": function ( data, type, row ) {
					return  '<a href="<?=base_url()?>admin/istas/ver/'+data+'" class="btn btn-link btn-info btn-just-icon" title="Ver" ><i class="material-icons">remove_red_eye</i></a> &nbsp;'+
							'<a href="<?=base_url()?>admin/exportarpdf/generarIsta/'+data+'" class="btn btn-link btn-info btn-just-icon" title="PDF" ><i class="material-icons">picture_as_pdf</i></a> &nbsp;';
                    
                },
				"className": "text-right",
                "targets": 5
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
					$.post( "admin/istas/crearAlerta", { 
								"idcallista": $('#al_idcallista').val(),
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

  </script>