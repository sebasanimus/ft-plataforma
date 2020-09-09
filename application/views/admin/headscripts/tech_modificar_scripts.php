
<script>
	var table, table2, tablePais; 
	var summetToolbar = [	
		['style', ['bold', 'italic', 'underline', 'clear']],			
		['fontsize', ['fontsize']],
		['para', ['ul']],
		['font', ['clear']]
			];
	function registerSummernote(element, placeholder, max, callbackMax) {
		calbacks = {
			onPaste: function (e) {
				var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
				e.preventDefault();
				document.execCommand('insertText', false, bufferText);
			}
		};
		if(max>0){
			calbacks = {
				onKeydown: function(e) {
					var t = e.currentTarget.innerText;
					if (t.trim().length >= max) {
					//delete key
					if (e.keyCode != 8)
						e.preventDefault();
					// add other keys ...
					}
				},
				onKeyup: function(e) {
					var t = e.currentTarget.innerText;
					if (typeof callbackMax == 'function') {
						callbackMax(max - t.trim().length);
					}
				},
				onPaste: function(e) {
					var t = e.currentTarget.innerText;
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
					e.preventDefault();
					var all = t + bufferText;
					document.execCommand('insertText', false, all.trim().substring(0, 400));
					if (typeof callbackMax == 'function') {
						callbackMax(max - t.length);
					}
				}
			}
		} 
		$(element).summernote({
			toolbar: summetToolbar,
			placeholder,
			callbacks: calbacks
		});
	}

    $(document).ready(function(){
		var datatableMyConfig2 = jQuery.extend({}, datatableMyConfig);
		var datatableMyConfig3 = jQuery.extend({}, datatableMyConfig);


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

		$("textarea[name^='tech_resultados']").each(function() {
			console.log($(this).attr('maxlength'));
			let maximo = ($(this).attr('maxlength') != undefined)?  $(this).attr('maxlength') : 0;
			registerSummernote('#'+$(this).attr('id'), $(this).attr('placeholder'), maximo, function(max) {
				console.log(max);
			});
			
		});

    } );

	

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