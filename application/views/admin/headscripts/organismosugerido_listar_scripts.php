
    <script>
   var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/organismosugeridos/paginar",
          "columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
					return '<a href="javascript:accionAceptar('+data+');" class="btn btn-link btn-success btn-just-icon" title="Aceptar" ><i class="material-icons">check</i></a> &nbsp;'+
                           '<a href="javascript:accionRechazar('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Rechazar" ><i class="material-icons">close</i></a> &nbsp;';
                    
                },
				"className": "text-right",
                "targets": 7
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

    } );

	function accionAceptar(idsugerido){
		$.post( "admin/organismosugeridos/getSugerido/", { "idsugerido": idsugerido })
			.done(function( data ) {
				var datos = JSON.parse(data);
				$('#org_idsugerido').val(datos.idsugerido);
				$('#org_nombre').val(datos.nombre);
				$('#org_nombre_largo').val(datos.nombre_largo);
				$('#org_link').val(datos.link);
				$('#org_pais').selectpicker('val', datos.idpais);
				$('#org_tipo_institucion').selectpicker('val', datos.tipo_institucion);
				$('#organismoModal').modal('show');
			});

		
	}

	function agregarOrganismo(){
		$.post( "admin/organismos/agregarDesdeSugerido/", {
			nombre: $('#org_nombre').val(),
			nombre_largo: $('#org_nombre_largo').val(),
			link: $('#org_link').val(),
			idpais: $('#org_pais').val(),
			tipo_institucion: $('#org_tipo_institucion').val(),
			idsugerido: $('#org_idsugerido').val()
		}).done(function( data ) {
				if(data!=''){
					swal({
						title: "Error",
						text: data,
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}else{
					swal({
						title: "Éxito",
						text: "",
						type: "success",
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);

					$('#organismoModal').modal('hide');
					table.ajax.reload();
				}	
			})
	}

	function vaciarModalOrganismo(){
		$('#org_nombre').val('');
		$('#org_nombre_largo').val('');
		$('#org_link').val('');
		$('#org_pais').val('');
		$('#org_pais').selectpicker('refresh');
		$('#org_tipo_institucion').val('');
		$('#org_tipo_institucion').selectpicker('refresh');
	}

	function accionRechazar(ideliminar){
		$('#rec_idsugerido').val(ideliminar);
		$('#rec_motivo').val('');
		$('#rechazoModal').modal('show');
	}

	function rechazarOrganismo(){
		$.post( "admin/organismosugeridos/rechazar/", {
			motivo: $('#rec_motivo').val(),
			idsugerido: $('#rec_idsugerido').val()
		}).done(function( data ) {
				if(data!=''){
					swal({
						title: "Error",
						text: data,
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}else{
					swal({
						title: "Éxito",
						text: "",
						type: "success",
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);

					$('#rechazoModal').modal('hide');
					table.ajax.reload();
				}	
			})
	}


  </script>