<script>
	var table, table2, tablePais; 

    $(document).ready(function(){
		var datatableMyConfig2 = jQuery.extend({}, datatableMyConfig);
		var datatableMyConfig3 = jQuery.extend({}, datatableMyConfig);

		options = {
          "sAjaxSource": "admin/adjuntos/paginar/webstory/<?=$idwebstory?>",
          "columnDefs": [
		 {
			"render": function ( data, type, row ) {
					var d = data.split('**');
					if(d[1]==1 || d[1]==3 || d[1]==4){
						return  '<div class="img-container"><img src="<?=base_url()?>uploads/adjuntos/400_'+d[0]+'"></div>';
					}else{
						return '<a href="<?=base_url()?>uploads/adjuntos/'+d[0]+'" target="_blank">'+d[0]+'</a>';
					}
                    
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
                "render": function ( data, type, row ) {
					return '<a href="javascript:accionModificar('+data+');" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">edit</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminar('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                    
				},
				"className": "text-right",
                "targets": 5
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

		options2 = {
          "sAjaxSource": "admin/webstories/paginarIndicadores/<?=$idwebstory?>",
          "columnDefs": [
		 	{
				"render": function ( data, type, row ) {					
					//return '<i class="material-icons">'+data+'</i>';
					//return '<span class="lnr lnr-'+data+'"></span>';	
					return '<img width="30" height="30" src="img/iconos/'+data+'.svg" />';		
				},
				"bSortable" : false,
				"targets": 0 
			},{
				"render": function ( data, type, row ) {
					return '<a href="javascript:accionModificarIndicador('+data+');" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">edit</i></a> &nbsp;'+
						'<a href="javascript:accionEliminarIndicador('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
					
				},
				"className": "text-right",
				"targets": 3
			}]
        };

		jQuery.extend(datatableMyConfig2, options2);
        table2 = $('#miindicatable').DataTable(datatableMyConfig2);

		options3 = {
          "sAjaxSource": "admin/webstories/paginarPais/<?=$idwebstory?>",
          "columnDefs": [
		 	{
				"render": function ( data, type, row ) {
					return '<a href="javascript:accionEliminarPais('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
					
				},
				"className": "text-right",
				"targets": 2
			}]
        };

		jQuery.extend(datatableMyConfig3, options3);
        tablePais = $('#mipaistable').DataTable(datatableMyConfig3);
		
		$('#idpropuesta').select2({
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


    } );

	let dropArea = document.getElementById('adjuntoModal');
	['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
		dropArea.addEventListener(eventName, preventDefaults, false)
	});

	['dragenter', 'dragover'].forEach(eventName => {
		dropArea.addEventListener(eventName, highlight, false)
	});

	;['dragleave', 'drop'].forEach(eventName => {
		dropArea.addEventListener(eventName, unhighlight, false)
	});
	dropArea.addEventListener('drop', handleDrop, false)

	function handleDrop(e) {
		let fileInput = document.getElementById('adjunto');
		fileInput.files = e.dataTransfer.files;
		amanopla(e.dataTransfer.files, e.dataTransfer.files[0]);
		//$('#fileinputAdjunto').fileinput('change',e);
		//$('#fileinputAdjunto input').trigger('change');
		//$('#fileinputAdjunto').trigger('change.bs.fileinput', e.dataTransfer.files);
	}

	function preventDefaults (e) {
		e.preventDefault();
		e.stopPropagation();
	}

	function highlight(e) {
		dropArea.classList.add('highlight')
	}

	function unhighlight(e) {
		dropArea.classList.remove('highlight')
	}

	function accionEliminar(ideliminar){
		  swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar el adjunto",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/adjuntos/eliminar/webstory/<?=$idwebstory?>", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminado!',
								text: 'El adjunto ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
	}
	
	function accionModificar(idmodificar){
		$.post( "admin/adjuntos/obtener/webstory/<?=$idwebstory?>", { "idadjunto": idmodificar })
			.done(function( data ) {
				var datos = JSON.parse(data);
				$('#adj_idadjunto').val(datos.idadjunto);
				$('#adj_orden').val(datos.orden);
				$('#adj_idtipo').selectpicker('val', datos.idtipo);
				<?foreach($lenguajes as $lenguaje):?>
				$('#adj_nombre_<?=$lenguaje->codlang?>').val(datos.nombre_<?=$lenguaje->codlang?>);
				<?endforeach?>

				$('#fileinputAdjunto').fileinput('reset');
				if(datos.idtipo==1){
					$('#adj_thumbnail').show();
					$('#adj_thumbnailtext').hide();
					$('#adj_thumbnail').attr("src","<?=base_url()?>uploads/adjuntos/400_"+datos.archivo);
				}else{
					$('#adj_thumbnail').hide();
					$('#adj_thumbnailtext').text(datos.archivo);
					$('#adj_thumbnailtext').show();
				}
				$('#adj_btn').html('Modificar');
				$("#progress-wrp .progress-bar").css("width", "0%");
				$("#progress-wrp .progress-badge").text("0%");
				$('#adjuntoModal').modal('show');
			});	
	}

	function abrirModal(){
		if($('#adj_idadjunto').val()>0){
			vaciarModal();
		}
		$('#adj_idadjunto').val(0);
		$('#adjuntoModal').modal('show');
	}

	function editable(){
		document.getElementById("fieldset").disabled=false;
		$('#botonera').show("slow");
		$('#boton-editar').hide("slow");
	}

	function cancelar(){
		document.getElementById("fieldset").disabled=true;
		$('#botonera').hide("slow");
		$('#boton-editar').show("slow");
	}
	
	function agregarAdjunto(){
		var file = $('#adjunto')[0].files[0];
		var upload = new Upload(file);
		// maby check size or type here with upload.getSize() and upload.getType()
		upload.doUpload();
	}

	function vaciarModal(){
		$('#adj_idtipo').selectpicker('val', '');
		$('#adj_nombre_es').val('');
		$('#adj_nombre_en').val('');
		$('#adj_orden').val('');
		$('#adj_thumbnail').show();
		$('#adj_thumbnailtext').hide();
		$('#adj_btn').html('Agregar');
		$("#progress-wrp .progress-bar").css("width", "0%");
		$("#progress-wrp .progress-badge").text("0%");
		$('#fileinputAdjunto').fileinput('reset');
	}

	function abrirModalIndicador(){
		if($('#ind_idindicador').val()>0){
			vaciarModalIndicador();
		}
		$('#ind_idindicador').val(0);
		$('#indicadorModal').modal('show');
	}

	function vaciarModalIndicador(){
		$('#ind_nombre_es').val('');
		$('#ind_nombre_en').val('');
		$('#ind_valor').val('');
		$('#ind_icon').val('');
		$('#ind_prefijo').val('');
		$('#ind_unidad').val('');
		$('#ind_form .material-icon-picker-prefix').html('');
		$('#ind_btn').html('Agregar');
	}

	function agregarIndicador(){
		$.post( "admin/webstories/agregarIndicador", $("#ind_form").serialize())
			.done(function( data ) {
				if(data!=''){
					swal({
						title: "Error",
						text: data,
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}else{
					$('#indicadorModal').modal('hide');
					table2.ajax.reload();
					vaciarModalIndicador();
				}	
			})
	}

	
	function accionModificarIndicador(idmodificar){
		$.post( "admin/webstories/obtenerIndicador/<?=$idwebstory?>", { "idindicador": idmodificar })
			.done(function( data ) {
				var datos = JSON.parse(data);
				$('#ind_idindicador').val(datos.idwebstoryindicador);
				$('#ind_icon').val(datos.icono);
				$('#ind_valor').val(datos.valor);
				$('#ind_unidad').val(datos.unidad);
				$('#ind_prefijo').val(datos.prefijo);
				<?foreach($lenguajes as $lenguaje):?>
				$('#ind_nombre_<?=$lenguaje->codlang?>').val(datos.nombre_<?=$lenguaje->codlang?>);
				<?endforeach?>
				$('#ind_form .material-icon-picker-prefix').html(datos.icono);

				$('#ind_btn').html('Modificar');
				$('#indicadorModal').modal('show');
			});		
	}

	function accionEliminarIndicador(ideliminar){
		swal({
				title: '¿Está Seguro?',
				text: "Está a punto de eliminar el indicador",
				type: 'warning',
				showCancelButton: true,
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				confirmButtonText: 'Si, eliminalo!',
				buttonsStyling: false
			}).then(function(result) {
				if (result.value) {
					$.post( "admin/webstories/eliminarIndicador/<?=$idwebstory?>", { "ideliminar": ideliminar })
						.done(function( data ) {
							table2.ajax.reload();
							swal({
								title: '¡Eliminado!',
								text: 'El indicador ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
			}).catch(swal.noop);
	}

	function inicializarSelect(){
		setTimeout(function(){
			$('#pai_idorganismo').select2({
				dropdownParent: $('#paisModal'),
				ajax: {
					url: function (params) {
						return '<?=base_url()?>admin/organismos/select/' + params.term;
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

	function abrirModalPais(){
		if($('#pai_idwebstoryorganismo').val()>0){
			vaciarModalIndicador();
		}
		$('#pai_idwebstoryorganismo').val(0);
		inicializarSelect();
		$('#paisModal').modal('show');
	}

	function vaciarModalPais(){
		$('#pai_pais').selectpicker('val', '');
		$('#pai_idorganismo').val(null).trigger('change');
		$('#pai_btn').html('Agregar');
	}

	function agregarPais(){
		$.post( "admin/webstories/agregarPais", $("#pai_form").serialize())
			.done(function( data ) {
				if(data!=''){
					swal({
						title: "Error",
						text: data,
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}else{
					$('#paisModal').modal('hide');
					tablePais.ajax.reload();
					vaciarModalPais();
				}	
			})
	}

	
	function accionModificarPais(idmodificar){
		$.post( "admin/webstories/obtenerPais/<?=$idwebstory?>", { "idwebstoryorganismo": idmodificar })
			.done(function( data ) {
				var datos = JSON.parse(data);
				$('#pai_idwebstoryorganismo').val(datos.idwebstoryorganismo);
				$('#pai_pais').selectpicker('val', datos.pais);
				$('#pai_idorganismo').val(datos.idorganismo).trigger('change');

				$('#pai_btn').html('Modificar');
				$('#paisModal').modal('show');
			});		
	}

	function accionEliminarPais(ideliminar){
		swal({
				title: '¿Está Seguro?',
				text: "Está a punto de eliminar el país",
				type: 'warning',
				showCancelButton: true,
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				confirmButtonText: 'Si, eliminalo!',
				buttonsStyling: false
			}).then(function(result) {
				if (result.value) {
					$.post( "admin/webstories/eliminarPais/<?=$idwebstory?>", { "ideliminar": ideliminar })
						.done(function( data ) {
							tablePais.ajax.reload();
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
	
var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    return this.file.name;
};
Upload.prototype.doUpload = function () {
    var that = this;
    var formData = new FormData();
	var idadjunto = $('#adj_idadjunto').val();

	if(idadjunto==0 && this.file===undefined){
		swal({
			title: "Error",
			text: "Debe seleccionar un Archivo",
			buttonsStyling: false,
			confirmButtonClass: "btn btn-rose"
        }).catch(swal.noop);
		return;
	}
	if( $('#adj_idtipo').val()===''){
		swal({
			title: "Error",
			text: "Debe seleccionar un Tipo",
			buttonsStyling: false,
			confirmButtonClass: "btn btn-rose"
        }).catch(swal.noop);
		return;
	}

    // add assoc key values, this will be posts values
	if(this.file!==undefined){
		formData.append("file", this.file, this.getName());
		formData.append("upload_file", true);
	}

	formData.append("idtipo", $('#adj_idtipo').val());
	formData.append("nombre_es", $('#adj_nombre_es').val());
	formData.append("nombre_en", $('#adj_nombre_en').val());
	formData.append("orden", $('#adj_orden').val());
	formData.append("idmodelo", <?=$idwebstory?> );
	

    $.ajax({
        type: "POST",
        url: "<?=base_url()?>admin/adjuntos/adjuntar/webstory/"+idadjunto,
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
			if(data!='' && !data.startsWith('ok') ){
				swal({
					title: "Error",
					text: data,
					buttonsStyling: false,
					confirmButtonClass: "btn btn-rose"
				}).catch(swal.noop);
			}else{
				$('#adjuntoModal').modal('hide');
				table.ajax.reload();
				vaciarModal();
			}			
        },
        error: function (error) {
            alert(error);
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 600000
    });
};

Upload.prototype.progressHandling = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .progress-badge").text(percent + "%");
};



function amanopla(files, file){
	var preview = $('#fileinputAdjunto .fileinput-preview');
	var element =  $('#fileinputAdjunto');
	if ( (typeof file.type !== "undefined" ? file.type.match(/^image\/(gif|png|jpeg|svg\+xml)$/) : file.name.match(/\.(gif|png|jpe?g|svg)$/i)) && typeof FileReader !== "undefined") {
		var reader = new FileReader();
		

      	reader.onload = function(re) {
			var $img = $('<img>')
			$img[0].src = re.target.result
			files[0].result = re.target.result

			element.find('.fileinput-filename').text(file.name)

			// if parent has max-height, using `(max-)height: 100%` on child doesn't take padding and border into account
			if (preview.css('max-height') != 'none') {
				var mh = parseInt(preview.css('max-height'), 10) || 0
				var pt = parseInt(preview.css('padding-top'), 10) || 0
				var pb = parseInt(preview.css('padding-bottom'), 10) || 0
				var bt = parseInt(preview.css('border-top'), 10) || 0
				var bb = parseInt(preview.css('border-bottom'), 10) || 0

				$img.css('max-height', mh - pt - pb - bt - bb)
			}

			preview.html($img);
			
			element.addClass('fileinput-exists').removeClass('fileinput-new');

			element.trigger('change.bs.fileinput', files);
      	}

      	reader.readAsDataURL(file);
    } else {
		var text = file.name
		var $nameView = element.find('.fileinput-filename')

		if (files.length > 1) {
			text = $.map(files, function(file) {
			return file.name;
			}).join(', ')
		}

		$nameView.text(text);
		preview.text(file.name);
		element.addClass('fileinput-exists').removeClass('fileinput-new');
		element.trigger('change.bs.fileinput');
    }

}

function guardarBadges(){
	$.post("admin/webstories/guardarBadges", $("#formbadges").serialize())
		.done(function(data) {
			if (data==''){
				swal({
					title: 'Guardado!',
					text: 'Se han guardado correctamente.',
					type: 'success',
					confirmButtonClass: "btn btn-success",
					buttonsStyling: false
				})
			}else{
				swal({
					title: 'Error!',
					text: 'Hubo un error al guardar',
					type: 'error',
					confirmButtonClass: "btn btn-success",
					buttonsStyling: false
				})
			}
		});
}
</script>