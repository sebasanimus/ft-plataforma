<script>
	var table, table2, tableDonante, tableAdj, tableProd;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/items/paginar/<?=$idpropuesta?>",
          "columnDefs": [
            {
                "render": function ( data, type, row ) {
					return  '<span style="float:right">'+data+'</span>';
                    
                },
                "targets": [4,5,6,7,8,9] 
          },{
                "render": function ( data, type, row ) {
					return  '<a href="admin/items/modificar/<?=$idpropuesta?>/'+data+'"class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">create</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminar('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                },
				"className": "text-right",
                "targets": 10
          }]
        };

		var dtemc = jQuery.extend({}, datatableMyConfig);
		var ddona = jQuery.extend({}, datatableMyConfig);
		var dadj = jQuery.extend({}, datatableMyConfig);
		var dprod = jQuery.extend({}, datatableMyConfig);

		jQuery.extend(datatableMyConfig, options);
		<?if(!empty($idpropuesta)):?>
        table = $('#midatatable').DataTable(datatableMyConfig);
		<?endif?>

		options = {
          "sAjaxSource": "admin/tecnicas/paginar/<?=$idpropuesta?>",
          "columnDefs": [
            {
                "render": function ( data, type, row ) {
					return  '<span style="float:right">'+data+'</span>';
                    
                },
                "targets": [7,8] 
          },{
                "render": function ( data, type, row ) {
					return '<a href="javascript:accionModificarTecnica('+data+');" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">create</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminarTecnica('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                
                },
				"className": "text-right",
                "targets": 9
          }]
        };

		jQuery.extend(dtemc, options);
		<?if(!empty($idpropuesta)):?>
        table2 = $('#midatatable2').DataTable(dtemc);
		<?endif?>

		options = {
          "sAjaxSource": "admin/adjuntos/paginar/propuesta/<?=$idpropuesta?>",
          "columnDefs": [
		 {
			"render": function ( data, type, row ) {
					var d = data.split('**');
					if(d[1]==1 || d[1]==3 || d[1]==4){
						return  '<div class="img-container"><a href="<?=base_url()?>uploads/adjuntos/'+d[0]+'" target="_blank"><img src="<?=base_url()?>uploads/adjuntos/400_'+d[0]+'"></a></div>';
					}else if(d[0].length>0){
						return '<a href="<?=base_url()?>uploads/adjuntos/'+d[0]+'" target="_blank">'+d[0]+'</a>';
					}else{
						return '<a href="'+d[2]+'" target="_blank">'+d[2]+'</a>';
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
					return '<a href="javascript:accionModificarAdj('+data+');" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">edit</i></a> &nbsp;'+
                           '<a href="javascript:accionEliminarAdj('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;';
                    
				},
				"className": "text-right",
                "targets": 5
          }]
        };

		jQuery.extend(dadj, options);
		<?if(!empty($idpropuesta)):?>
        tableAdj = $('#midatatableAdj').DataTable(dadj);
		<?endif?>

		options = {
          "sAjaxSource": "admin/productos/paginar/<?=$idpropuesta?>",
          "columnDefs": [
		 {
			"render": function ( data, type, row ) {
					return '<a href="<?=base_url()?>uploads/productos/'+data+'" target="_blank">'+data+'</a>';	
                },
				"bSortable" : false,
                "targets": 0 
          },{
                "render": function ( data, type, row ) {
                    if(data==1) 
					   return '<span class="badge badge-pill badge-success"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>';
					return '<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>';	
                    
                },
                "targets": 5
        },{
                "render": function ( data, type, row ) {
					var aprobar = (row[5]==1)? '':'<a href="javascript:accionAprobarProd('+data+');" class="btn btn-link btn-success btn-just-icon" title="Aprobar" ><i class="material-icons">check</i></a> &nbsp;'
					return '<a href="javascript:accionModificarProd('+data+');" class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">edit</i></a> &nbsp;'+
							aprobar+
                           '<a href="javascript:accionEliminarProd('+data+');" class="btn btn-link btn-danger btn-just-icon" title="Solicitar Revisión" ><i class="material-icons">close</i></a> &nbsp;';
                    
				},
				"className": "text-right",
                "targets": 6
          }]
        };

		jQuery.extend(dprod, options);
        <?if(!empty($idpropuesta)):?>
        tableProd = $('#midatatableProd').DataTable(dprod);
		<?endif?>
		
		actualizarTotal();
		$('#aporte_fontagro').change(function() {
			actualizarTotal();
		});
		$('#aporte_bid').change(function() {
			actualizarTotal();
		});
		$('#movilizacion_agencias').change(function() {
			actualizarTotal();
		});
		$('#aporte_contrapartida').change(function() {
			actualizarTotal();
		});
		$('#aporte_agencias').change(function() {
			actualizarTotal();
		});
		<?if(!empty($idpropuesta)):?>
		quieroDonantes();
		<?endif?>

		$('#tec_componente').change(function () {
			//console.log($('#tec_componente').val());
			$('.componente').hide();
			$('.componente'+$('#tec_componente').val()).show();
			$('#tec_indicastandar').selectpicker('val', '');
		});

		$('.form-check-input').change(function() {
			$('.form-check-seleccionado').removeClass('form-check-seleccionado');
			$(".form-check-input:checked").parent().addClass('form-check-seleccionado');
		});

		$('.sector-input').change(function() {
			$('.subsector'+$(this).val()).toggle('slow');
			$('.subsector'+$(this).val()+' .form-check-input:checked').prop('checked', false);
			$('.subsector'+$(this).val()+' .form-check-input:checked').trigger('change');
		});

		$("textarea[name^='web_']").each(function() {
			let maximo = ($(this).attr('maxlength') != undefined)?  $(this).attr('maxlength') : 0;
			registerSummernote('#'+$(this).attr('id'), $(this).attr('placeholder'), maximo, function(max) {
				console.log(max);
			});
		});

		$('#adj_idtipo').change(function() {
			adjuntoCamposEsconder();
		});

		$('#idperfil').select2({
			ajax: {
				url: function (params) {
					return '<?=base_url()?>admin/perfiles/select/' + params.term;
				},
				delay: 500 ,// wait 500 milliseconds before triggering the request
				processResults: function (data) {
					var datos = JSON.parse(data);
					return {
						results: datos.results
					};
				}	
			},
			minimumInputLength: 1,
			allowClear: true,
			placeholder: 'Seleccione un perfil si corresponde'
		});

    });

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

	function actualizarTotal(){
		const total = 	parseFloat(emptyZero($('#aporte_fontagro').val())) + 
			parseFloat(emptyZero($('#aporte_bid').val())) + 
			parseFloat(emptyZero($('#movilizacion_agencias').val())) + 
			parseFloat(emptyZero($('#aporte_contrapartida').val())) + 
			parseFloat(emptyZero($('#aporte_agencias').val()));
		$('#total').html(total);
	}
	function emptyZero(valor){
		if(valor=='')
			return 0;
		return valor;
	}

	function accionEliminar(ideliminar){          
		  swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar el ítem financiero",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/items/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table.ajax.reload();
							swal({
								title: '¡Eliminada!',
								text: 'El ítem ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
    }

	function accionEliminarTecnica(ideliminar){	
		swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar el dato técnico",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/tecnicas/eliminar", { "ideliminar": ideliminar })
						.done(function( data ) {
							table2.ajax.reload();
							swal({
								title: '¡Eliminada!',
								text: 'El dato ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
	}

	function accionEliminarDonante(ideliminar){          
		  swal({
                title: '¿Está Seguro?',
                text: "Está a punto de eliminar el ítem donante",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si, eliminalo!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					$.post( "admin/propuestas/deleteDonante", { "iddonante": ideliminar })
						.done(function( data ) {
							quieroDonantes();
							swal({
								title: '¡Eliminado!',
								text: 'El donante ha sido eliminado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
    }

	function abrirModalDonante(){
		vaciarModalDonante();
		$('#donanteModal').modal('show');
		inicializarSelect();
	}

	function vaciarModalDonante(){
		$('#don_orden').val('');
		$('#don_idorganismo').val(null).trigger('change');
	}

	function inicializarSelect(){
		setTimeout(function(){
			$('#don_idorganismo').select2({
				dropdownParent: $('#donanteModal'),
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

	function agregarDonante(){
		$.post( "admin/propuestas/agregarDonante", $("#don_form").serialize())
			.done(function( data ) {
				if(data!=''){
					swal({
						title: "Error",
						text: data,
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}else{
					quieroDonantes()
					$('#donanteModal').modal('hide');
				}	
			})
	}

	function quieroDonantes(){
		$.get( "admin/propuestas/getDonantes/<?=$idpropuesta?>", function( data ) {
			$( "#tablaDonantes" ).html( data );		
		});
	}

	function abrirModalTecnica(){
		if($('#tec_idtecnica').val()>0){
			vaciarModalTecnica();
		}
		$('#tec_idtecnica').val(0);
		$('#tecnicaModal').modal('show');
	}

	function vaciarModalTecnica(){
		$('#tec_indicador_es').val('');
		$('#tec_indicador_en').val('');

		$('#tec_indicastandar').selectpicker('val', '');
		$('#tec_componente').selectpicker('val', '');
		$('#tec_paisindicador').selectpicker('val', '');
		$('#tec_localidad').val('');
		$('#tec_anio_ind').val('');
		$('#tec_unidad').selectpicker('val', '');
		$('#tec_antes').val('');
		$('#tec_despues_san').val('');

		$('#tec_btn').html('Agregar');
	}

	function agregarTecnica(){
		$.post( "admin/tecnicas/agregar/<?=$idpropuesta?>", $("#tec_form").serialize())
			.done(function( data ) {
				if(data!=''){
					swal({
						title: "Error",
						text: data,
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}else{
					$('#tecnicaModal').modal('hide');
					table2.ajax.reload();
					vaciarModalTecnica();
				}	
			})
	}

	function accionModificarTecnica(idmodificar){
		$.post( "admin/tecnicas/obtener/<?=$idpropuesta?>", { "idtecnica": idmodificar })
			.done(function( data ) {
				var datos = JSON.parse(data);
				console.log(datos.indicastandar);
				console.log(datos);
				$('#tec_idtecnica').val(datos.idtecnica);
				$('#tec_componente').selectpicker('val', datos.componente);
				$('#tec_indicastandar').selectpicker('val', datos.indicastandar);
				$('#tec_paisindicador').selectpicker('val', datos.paisindicador);
				$('#tec_localidad').val(datos.localidad);
				$('#tec_anio_ind').val(datos.anio_ind);
				$('#tec_unidad').selectpicker('val', datos.unidad);
				$('#tec_antes').val(datos.antes);
				$('#tec_despues_san').val(datos.despues_san);
				
				<?foreach($lenguajes as $lenguaje):?>
				$('#tec_indicador_<?=$lenguaje->codlang?>').val(datos.indicador_<?=$lenguaje->codlang?>);
				<?endforeach?>
				
				$('#tec_btn').html('Modificar');
				$('#tecnicaModal').modal('show');
			});		
	}

	function guardarBadges(){
		$.post("admin/propuestas/guardarBadges", $("#formbadges").serialize())
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

	function agregarProducto(){		
		var file = $('#producto')[0].files[0];
		var upload = new Uploadprod(file);
		// maby check size or type here with upload.getSize() and upload.getType()
		upload.doUpload();
	}

	function accionEliminarProd(ideliminar){
		  swal({
                title: '¿Está Seguro de solicitar revisión el producto?',
                html: '<div class="form-group">' +
                    '<textarea id="motivo_rechazo" class="form-control" placeholder="Ingrese el motivo" /></textarea>' +
                    '</div>',
                type: 'error',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Si!',
                buttonsStyling: false
            }).then(function(result) {
				if (result.value) {
					console.log('hola');
					$.post( "admin/productos/eliminar/<?=$idpropuesta?>", { "ideliminar": ideliminar, 'motivo':$('#motivo_rechazo').val() })
						.done(function( data ) {
							tableProd.ajax.reload();
							swal({
								title: '¡Revisión Solicitada!',
								text: '',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
            }).catch(swal.noop);
	}

	function accionAprobarProd(idaceptar){
		swal({
				title: '¿Está Seguro de aceptar el producto?',
				type: 'success',
				showCancelButton: true,
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				confirmButtonText: 'Si, aceptalo!',
				buttonsStyling: false
			}).then(function(result) {
				if (result.value) {
					$.post( "admin/productos/aceptar/<?=$idpropuesta?>", { "idaceptar": idaceptar })
						.done(function( data ) {
							tableProd.ajax.reload();
							swal({
								title: '¡Aceptado!',
								text: 'El producto ha sido publicado.',
								type: 'success',
								confirmButtonClass: "btn btn-success",
								buttonsStyling: false
							})
						});
					
				}
			}).catch(swal.noop);
	}

	function abrirModalProd(){
		if($('#pro_idproducto').val()>0){
			vaciarModalProd();
		}
		$('#pro_idproducto').val(0);
		$('#productoModal').modal('show');
	}

	function vaciarModalProd(){
		$('#pro_idtipo').selectpicker('val', '');
		$('#pro_nombre_es').val('');
		$('#pro_nombre_en').val('');
		$('#pro_numero').val('');
		$('#pro_orden').val('');
		$('#pro_thumbnail').show();
		$('#pro_thumbnailtext').hide();
		$('#pro_btn').html('Agregar');
		$("#progress-wrp-pro .progress-bar").css("width", "0%");
		$("#progress-wrp-pro .progress-badge").text("0%");
		$('#fileinputProducto').fileinput('reset');
	}

	function accionModificarProd(idmodificar){
		$.post( "admin/productos/obtener/<?=$idpropuesta?>", { "idproducto": idmodificar })
			.done(function( data ) {
				var datos = JSON.parse(data);
				$('#pro_idproducto').val(datos.idproducto);
				$('#pro_orden').val(datos.orden);
				$('#pro_numero').val(datos.numero);
				$('#pro_idtipo').selectpicker('val', datos.idtipo);
				<?foreach($lenguajes as $lenguaje):?>
				$('#pro_nombre_<?=$lenguaje->codlang?>').val(datos.nombre_<?=$lenguaje->codlang?>);
				<?endforeach?>

				$('#fileinputProducto').fileinput('reset');
				if(datos.idtipo==1){
					$('#pro_thumbnail').show();
					$('#pro_thumbnailtext').hide();
					$('#pro_thumbnail').attr("src","<?=base_url()?>uploads/productos/400_"+datos.archivo);
				}else{
					$('#pro_thumbnail').hide();
					$('#pro_thumbnailtext').text(datos.archivo);
					$('#pro_thumbnailtext').show();
				}
				$('#pro_btn').html('Modificar');
				$("#progress-wrp-pro .progress-bar").css("width", "0%");
				$("#progress-wrp-pro .progress-badge").text("0%");
				$('#productoModal').modal('show');
			});	
	}

	function agregarAdjunto(){
		if(!$("#adj_aceptar").prop("checked")){
			swal({
				title: "Error",
				text: "Debe aceptar el otortgamiento de licencia",
				buttonsStyling: false,
				confirmButtonClass: "btn btn-rose"
			}).catch(swal.noop);
			return;
		}
		var file = $('#adjunto')[0].files[0];
		var upload = new Upload(file);
		// maby check size or type here with upload.getSize() and upload.getType()
		upload.doUpload();
	}

	function accionEliminarAdj(ideliminar){
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
					$.post( "admin/adjuntos/eliminar/propuesta/<?=$idpropuesta?>", { "ideliminar": ideliminar })
						.done(function( data ) {
							tableAdj.ajax.reload();
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

	function abrirModalAdj(){
		if($('#adj_idadjunto').val()>0){
			vaciarModalAdj();
		}
		$('#adj_idadjunto').val(0);
		adjuntoCamposEsconder();
		$('#adjuntoModal').modal('show');
	}

	function vaciarModalAdj(){
		$('#adj_idtipo').selectpicker('val', '');
		$('#adj_habilitado').selectpicker('val', '');
		$('#adj_nombre_es').val('');
		$('#adj_nombre_en').val('');
		$('#adj_taller_es').val('');
		$('#adj_taller_en').val('');
		$('#adj_lugar_es').val('');
		$('#adj_lugar_en').val('');
		$('#adj_orden').val('');
		$('#adj_autor').val('');
		$('#adj_urlold').val('');
		$('#adj_fecha').val('');
		$('#adj_thumbnail').show();
		$('#adj_thumbnailtext').hide();
		$("#adj_aceptar").prop("checked", false);
		$('#adj_btn').html('Agregar');
		$("#progress-wrp .progress-bar").css("width", "0%");
		$("#progress-wrp .progress-badge").text("0%");
		$('#fileinputAdjunto').fileinput('reset');
	}

	function accionModificarAdj(idmodificar){
		$.post( "admin/adjuntos/obtener/propuesta/<?=$idpropuesta?>", { "idadjunto": idmodificar })
			.done(function( data ) {
				var datos = JSON.parse(data);
				$('#adj_idadjunto').val(datos.idadjunto);
				$('#adj_orden').val(datos.orden);
				$('#adj_autor').val(datos.autor);
				$('#adj_urlold').val(datos.urlold);
				$('#adj_fecha').val(datos.fecha);
				$('#adj_idtipo').selectpicker('val', datos.idtipo);
				$('#adj_habilitado').selectpicker('val', datos.habilitado);
				<?foreach($lenguajes as $lenguaje):?>
				$('#adj_nombre_<?=$lenguaje->codlang?>').val(datos.nombre_<?=$lenguaje->codlang?>);
				$('#adj_taller_<?=$lenguaje->codlang?>').val(datos.taller_<?=$lenguaje->codlang?>);
				$('#adj_lugar_<?=$lenguaje->codlang?>').val(datos.lugar_<?=$lenguaje->codlang?>);
				<?endforeach?>
				$("#adj_aceptar").prop("checked", true);

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
				adjuntoCamposEsconder();
				$('#adjuntoModal').modal('show');
			});	
	}

	function adjuntoCamposEsconder(){		
		<?foreach($lenguajes as $lenguaje):?>
		$('#adj_taller_<?=$lenguaje->codlang?>').closest('.bmd-form-group').hide();
		$('#adj_lugar_<?=$lenguaje->codlang?>').closest('.bmd-form-group').hide();
		<?endforeach?>
		$('#adj_fecha').closest('.bmd-form-group').hide();
		$('#adj_autor').closest('.bmd-form-group').hide();
		$('#adj_urlold').closest('.bmd-form-group').hide();
		var tipo = $('#adj_idtipo').val();
		if(tipo==1){
			$('#adj_autor').closest('.bmd-form-group').show();
		}else if(tipo==8){
			<?foreach($lenguajes as $lenguaje):?>
			$('#adj_taller_<?=$lenguaje->codlang?>').closest('.bmd-form-group').show();
			$('#adj_lugar_<?=$lenguaje->codlang?>').closest('.bmd-form-group').show();
			<?endforeach?>
			$('#adj_fecha').closest('.bmd-form-group').show();
			$('#adj_autor').closest('.bmd-form-group').show();
		}
		if(tipo==6 || tipo==7 || tipo==8){
			$('#adj_urlold').closest('.bmd-form-group').show();
		}else{
			$('#adj_urlold').val('');
		}
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

	if(idadjunto==0 && this.file===undefined && $('#adj_urlold').val().length<5){
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
	if( $('#adj_habilitado').val()===''){
		swal({
			title: "Error",
			text: "Debe seleccionar un Estado",
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
	formData.append("habilitado", $('#adj_habilitado').val());
	<?foreach($lenguajes as $lenguaje):?>
	formData.append("nombre_<?=$lenguaje->codlang?>", $('#adj_nombre_<?=$lenguaje->codlang?>').val());
	formData.append("taller_<?=$lenguaje->codlang?>", $('#adj_taller_<?=$lenguaje->codlang?>').val());
	formData.append("lugar_<?=$lenguaje->codlang?>", $('#adj_lugar_<?=$lenguaje->codlang?>').val());
	<?endforeach?>
	formData.append("orden", $('#adj_orden').val());
	formData.append("fecha", $('#adj_fecha').val());
	formData.append("autor", $('#adj_autor').val());
	formData.append("urlold", $('#adj_urlold').val());
	formData.append("idmodelo", <?=$idpropuesta?> );
	console.log(formData);

    $.ajax({
        type: "POST",
        url: "<?=base_url()?>admin/adjuntos/adjuntar/propuesta/"+idadjunto,
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
				tableAdj.ajax.reload();
				vaciarModalAdj();
				var dividido = data.split("***");
				if(dividido.length>1){
					swal({
						title: "Éxito",
						html: 'Tu presentación ya ha sido cargada. Para acceder a ella puede hacerlo desde este link: <a target="_blank" href="<?=base_url()?>uploads/adjuntos/'+dividido[1]+'"><?=base_url()?>uploads/adjuntos/'+dividido[1]+'</a>',
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}
			}			
        },
        error: function (error) {
			console.log(error);
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


		
var Uploadprod = function (file) {
    this.file = file;
};

Uploadprod.prototype.getType = function() {
    return this.file.type;
};
Uploadprod.prototype.getSize = function() {
    return this.file.size;
};
Uploadprod.prototype.getName = function() {
    return this.file.name;
};
Uploadprod.prototype.doUpload = function () {
    var that = this;
    var formData = new FormData();
	var idproducto = $('#pro_idproducto').val();

	if(idproducto==0 && this.file===undefined){
		swal({
			title: "Error",
			text: "Debe seleccionar un Archivo",
			buttonsStyling: false,
			confirmButtonClass: "btn btn-rose"
        }).catch(swal.noop);
		return;
	}
	if( $('#pro_idtipo').val()===''){
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

	formData.append("idtipo", $('#pro_idtipo').val());
	formData.append("idpropuesta",<?=$idpropuesta?>);
	<?foreach($lenguajes as $lenguaje):?>
	formData.append("nombre_<?=$lenguaje->codlang?>", $('#pro_nombre_<?=$lenguaje->codlang?>').val());
	<?endforeach?>
	formData.append("orden", $('#pro_orden').val());
	formData.append("numero", $('#pro_numero').val());	

    $.ajax({
        type: "POST",
        url: "<?=base_url()?>admin/productos/adjuntar/"+idproducto,
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
				$('#productoModal').modal('hide');
				tableProd.ajax.reload();
				vaciarModalProd();
				var dividido = data.split("***");
				if(dividido.length>1){
					swal({
						title: "Éxito",
						html: 'Tu producto ya ha sido cargado. Para acceder a ella puede hacerlo desde este link: <a target="_blank" href="<?=base_url()?>uploads/productos/'+dividido[1]+'"><?=base_url()?>uploads/productos/'+dividido[1]+'</a>',
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}
			}			
        },
        error: function (error) {
			console.log(error);
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

Uploadprod.prototype.progressHandling = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp-pro";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .progress-badge").text(percent + "%");
};

</script>
