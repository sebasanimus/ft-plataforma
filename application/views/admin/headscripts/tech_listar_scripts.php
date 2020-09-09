
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/techies/paginar",
          "columnDefs": [
            {
                "render": function ( data, type, row ) {
					var d = data.split('**');
					return '<a href="admin/techies/ver/'+row[2]+'">'+d[0]+'</a><br /><small>'+d[1]+'</small>';
                    
                },
                "targets": 0
          }, {
                "render": function ( data, type, row ) {
					var d = data.split('**');
					return '<a>'+d[0]+'</a><br /><small>'+d[1]+'</small>';
                    
                },
                "targets": 1
          },{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets": 3
          },{
                "render": function ( data, type, row ) {
					return 	'<a href="admin/techies/ver/'+data+'" class="btn btn-link btn-info btn-just-icon" title="Ver" ><i class="material-icons">remove_red_eye</i></a> &nbsp;'+
							'<a href="exportartech/generarPDF/'+data+'/es" class="btn btn-link btn-info btn-just-icon" title="Generar y Ver PDF" target="_blank" ><i class="material-icons">open_in_new</i></a> &nbsp;'+
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

		$('#idpropuesta').on('select2:select', function (e) {
			var data = e.params.data;
			$('#idwebstory').val(null).trigger('change');
			$('#idwebstory').select2({
				dropdownParent: $('#techModal'),
				ajax: {
					url: function (params) {
						return '<?=base_url()?>admin/techies/selectWS/'+ data.id +'/' + params.term;
					},
					delay: 500 ,// wait 500 milliseconds before triggering the request
					processResults: function (data) {
						var datos = JSON.parse(data);
						return {
							results: datos.results
						};
					}	
				},
				minimumInputLength: 0
			});
		});

    } );


	function accionEliminar(ideliminar){
		  swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar el Tech",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/techies/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminado!',
								text: 'El Tech ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
    }



	function abrirModalTech(){
		$('#idpropuesta').val(null).trigger('change');
		$('#idwebstory').val(null).trigger('change');
		inicializarSelect();
		$('#techModal').modal('show');
	}

	function agregarTech(){
		$.post( "admin/techies/agregarTech", $("#tech_form").serialize())
			.done(function( data ) {				 
				if(!isNaN(data)){
					window.location.href = "<?=base_url()?>admin/techies/ver/"+data;
				}else if(data!=''){
					swal({
						title: "Error",
						text: data,
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}else{
					$('#techModal').modal('hide');
					table.ajax.reload();
				}	
			})
	}


	function inicializarSelect(){
		setTimeout(function(){
			$('#idpropuesta').select2({
				dropdownParent: $('#techModal'),
				ajax: {
					url: function (params) {
						return '<?=base_url()?>admin/propuestas/select/' + params.term;
					},
					delay: 500 ,// wait 500 milliseconds before triggering the request
					processResults: function (data) {
						var datos = JSON.parse(data);
						return {
							results: datos.results
						};
					}	
				},
				minimumInputLength: 1
			});
		},500);
	}
  </script>