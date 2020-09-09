<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="material/assets/js/plugins/bootstrap-tagsinput.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/jQuery.auto-save-form.js"></script>

<script>
	var TITULO = document.title;
	var paso = <?=$paso?>;
	var tabID = window.name==''? Math.round(Math.random()*100000000000000) : window.name;
	window.name = tabID;
	var myVar = null;

	$(function() {
		jsExtra1();
		jsExtra2();
		subsectores();

		$('.level0').hide(0);
		$('[data-toggle="tooltip"]').tooltip();
		irAlPaso();

		$('#siguiente').click(function() {
			siguiente();
		});
		$('#anterior').click(function() {
			anterior();
		});
		$('#guardar').click(function() {
			guardar();
		});
		window.onbeforeunload = function() { return "Todos los cambios no guardados se perderán."; };

		//AUTOSAVE
		var $form = $('form');
		// Enable on all forms
		$form.autoSaveForm();
		// The following triggers confirm to the beforeSend, error and success ajax callbacks.
		$form.on('beforeSave.autoSaveForm', function (ev, $form, xhr) {
			// called before saving the form here you can return false if the form shouldn't be saved eg. because of validation errors.	
			// Let the user know we are saving
		});
		$form.on('saveError.autoSaveForm', function (ev, $form, jqXHR, textStatus, errorThrown) {
			// The saving failed so tell the user
			notificar('danger', '<?=$textos['notificacion_error']?>');
		});
		$form.on('saveSuccess.autoSaveForm', function (ev, $form, data, textStatus, jqXHR) {
			try{
				var datos = JSON.parse(data);
				if (datos.error==''){
					actualizarPorcentajes(datos.porcentajes);
					var d = new Date();
					notificar('success', '<?=$textos['notificacion_exito']?> '+d.toLocaleTimeString());
				}else if(datos.error=='cerrada'){
					cerrada();
				}else{
					notificar('danger', datos.error);
				}
			} catch(e) {
				notificar('danger', '<?=$textos['notificacion_error']?>');
			}
		});
		//FIN AUTOSAVE

		$('[data-toggle="wizard-checkbox"]').click(function() {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).find('[type="checkbox"]').removeAttr('checked');
				guardar();
            }else{
                $(this).addClass('active');
                $(this).find('[type="checkbox"]').attr('checked', 'true');
				guardar();
            }
        });

		$('.temascheck').change(function() {
			$('.form-check-seleccionado').removeClass('form-check-seleccionado');
			$(".temascheck:checked").parent().addClass('form-check-seleccionado');
		});

		actualizarPorcentajes(<?=json_encode($porcentajes)?>);

		$('.selectOrg').select2({
			allowClear: true,
			minimumResultsForSearch: 10
		});
		$('.selectOrg').on('change', function (e) {
			if($(this).val()==''){
				$(this).parent().parent().parent().next().hide();
			}else{
				$(this).parent().parent().parent().next().show();
			}			
		});
		$('.sector .selectOrg').on('change', function (e) {
			subsectores();		
		});

		$('input[name*="monto"]').change(function() {
			$('#monto_total').val(parseInt( $('input[name="monto"]').val()) + parseInt($('input[name="monto_contrapartida"]').val()) );
			$('#monto_total').trigger('change');
		});
		
		$('input[name="monto"]').change(function(){
			if($('input[name="monto"]').val()>200000){
				$('input[name="monto"]').val(0);				
				alert("Monto máximo solicitado: U$200.000");
				setTimeout(
					function(){
						cambiarPaso(3);
						$('input[name="monto"]').trigger('change');
					},100);
			}			
		});

		$('input[name="monto_contrapartida"]').change(function(){
			if($('input[name="monto_contrapartida"]').val()<(2*$('input[name="monto"]').val()) ){
				$('input[name="monto_contrapartida"]').val(0);				
				alert("Monto mínimo de contrapartida: el doble de lo que solicitado");
				setTimeout(
					function(){
						cambiarPaso(3);
						$('input[name="monto"]').trigger('change');
					},100);
			}			
		});

		$('input[name="plazo"]').change(function(){
			if($('input[name="plazo"]').val()>36){
				$('input[name="plazo"]').val(0);				
				alert("Máximo 36 meses de ejecución");
				setTimeout(
					function(){
						cambiarPaso(3);
						$('input[name="monto"]').trigger('change');
					},100);
			}			
		});

		$('input[type*="email"]').change(function() {
			var email = $(this).val();
			console.log($(this));
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
				$(this).parent().removeClass('has-danger');
			}else{
				$(this).parent().addClass('has-danger');
			}
		});

		$('select[name*="idpais"]').change(function() {
			$(this).parent().parent().removeClass('has-danger');
		});

		$('select[name="ejecutor[idorganismo]"]').change(function() {
			if($('select[name="ejecutor[idorganismo]"]').val()==''){
				$('.selectpickerOrgEje').selectpicker('setStyle', 'faltante', 'add');
			}else{
				$('.selectpickerOrgEje').selectpicker('setStyle', 'faltante', 'remove');
			}
		});

		$.notify({
				icon: "add_alert",
				message: "<?=$textos['notificacion_tiempo']?>:<br/><b><?=$falta['txt']?></b>"
			},{
				type: 'warning',
				timer: 10e3,
				placement:{
					from: 'bottom',
					align: 'right'
				}
			}
		);		

		<?if($falta['dias']==0):?>
			setTimeout(function(){ cerrada(); }, <?=$falta['horas']*60*60+$falta['min']*60+$falta['seg']?>*1000);
		<?endif?>
		mostrarUltimaCruz();
		multipleTabs();
		myVar = setInterval(multipleTabs, 10*1000); //10seg

		checkAlertas();
		setInterval(function(){ checkAlertas(); }, 600*1000);//10min
	});

	function actualizarPorcentajes(porcentajes){
		const porcentajeTotal = getPorcentaje(porcentajes.total.cantidad, porcentajes.total.completados, 0);
		$('.statusNumber').html(porcentajeTotal+'%');
		$('.progress-bar').css('width', porcentajeTotal+'%');
		if(porcentajeTotal==100){
			$('#notificacion_incompleto').hide();
			$('#notificacion_completo').show();
			$('#paso10_error').hide();
			$('#paso10_exito').show();
		}else{
			$('#notificacion_completo').hide();
			$('#notificacion_incompleto').show();
			$('#paso10_exito').hide();
			$('#paso10_error').show();
		}
		
		for(let i=1; i<10; i++ ){
			let porc = getPorcentaje(porcentajes["paso"+i].cantidad, porcentajes["paso"+i].completados,2);
			$('.menu'+i+' .pasoCompletitud').css('width', porc+'%');			
			if(porc==100){
				$('.menu'+i+' .pasoCompletitud').css('background', '#008a8e');
			}else if(porc>3){
				$('.menu'+i+' .pasoCompletitud').css('background', '#00636e');
			}else if(porc==2){
				$('.menu'+i+' .pasoCompletitud').css('background', '#350155');
			}
		}
	}

	function getPorcentaje(cantidad, completados, minimo ){
		if (cantidad==0) return minimo;
		porcentaje = Math.round(100*completados/cantidad);
		if(porcentaje==100 && completados<cantidad){
			porcentaje=99;
		}else if(porcentaje<minimo){
			porcentaje=minimo;
		}
		return porcentaje;
	}

	function guardar(){
		$('form').trigger('save.autoSaveForm');
	}

	function siguiente(){
		if(paso==0 && !$('#leyo_manual').prop('checked') ){
			$('#check_aceptar').tooltip('show');
			return;
		}
		paso++;
		irAlPaso();
	}

	function anterior(){
		paso--;
		irAlPaso();
	}

	function cambiarPaso(step){
		if(paso==0 && !$('#leyo_manual').prop('checked') ){
			$('#check_aceptar').tooltip('show');
			return;
		}
		paso = step;
		irAlPaso();
	}

	function indicativoArriba(){
		$('.stepBox').show(0);
		$('.stepBox').removeClass('active');
		for(let i=1; i<paso; i++){
			$('.step'+i).hide(0);
		}
		$('.step'+paso).addClass('active');
	}

	function menuDelCostado(){
		$('.nav-item').removeClass('filled');
		$('.nav-item').removeClass('active');
		for(let i=1; i<=9; i++){
			if(i<paso){
				$('.menu'+i).addClass('filled');
			}else if(i==paso){
				$('.menu'+i).addClass('active');
			}
		}
	}

	function irAlPaso(){
		//window.history.pushState("<?=base_url()?>", "Paso "+paso, "iniciativas/perfiles/pasos/"+paso+"/<?=$perfil['idperfil']?>");
		if(paso==0){
			$('#anterior').hide();
			$('#guardar').hide();
		}else if(paso==10){
			$('#siguiente').hide();
			$('#guardar').hide();		
		}else{
			$('#anterior').show();
			$('#guardar').show();
			$('#siguiente').show();
		}
		if(paso==9){
			$('#siguiente').text('<?=$textos['submit_boton']?>');
		}else{
			$('#siguiente').text('<?=$textos['siguiente']?>');
		}
		$('.contpaso').hide(0);
		$('.paso'+paso).show();

		indicativoArriba();	
		menuDelCostado();
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function volver(){
		$('.level0').show();
		$('.level1').hide();
	}

	function seleccionar(){
		$('.level0').hide();
		$('.level1').show();
	}

	function notificar(tipo, mensaje){
		//type=["","info","danger","success","warning","rose","primary"];
		$.notify(
			{
				icon: "add_alert",
				message: mensaje
			},{
				type: tipo,
				timer: 3e3,
				placement:{
					from: 'top',
					align: 'left'
				}
			}
		);
	}

	function mostarCoEjecutor(){
		$('.coejecutor:hidden:first').show(600);
		if($('.coejecutor:hidden:first').length==0){
			$('#masCoEjecutor').hide();
		}
	}

	function mostarAsociado(){
		$('.asociado:hidden:first').show(600);
		if($('.asociado:hidden:first').length==0){
			$('#masAsociado').hide();
		}
	}

	function mostarComponente(){
		$('.componente:hidden:first').show(600);
		if($('.componente:hidden:first').length==0){
			$('#masComponente').hide();
		}
		mostrarUltimaCruz();
	}

	function hideComponente(){
		if($('.componente:visible').length>0){
			$('.componente:visible:last').find("input[name*='nombre']").val('');
			$('.componente:visible:last').hide();
			mostrarUltimaCruz();
		}
	}

	function mostrarUltimaCruz(){
		$('.close-card').hide();
		if($('.componente:visible').length>1){
			$('.componente:visible:last').find('.close-card').show();
		}
	}

	function mostarSector(){
		$('.sector:hidden:first').show(600);
		if($('.sector:hidden:first').length==0){
			$('#masSector').hide();
		}
	}


	function modalOrganismo(){
		$('#organismoModal').modal('show');
	}

	function agregarOrganismo(){
		$.post( "iniciativas/perfiles/agregarOrganismo/", {
			nombre: $('#org_nombre').val(),
			nombre_largo: $('#org_nombre_largo').val(),
			link: $('#org_link').val(),
			idpais: $('#org_pais').val(),
			tipo_institucion: $('#org_tipo_institucion').val()
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
						text: "<?=$textos['solicitar_aclaracion']?>",
						type: "success",
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);

					$('#organismoModal').modal('hide');
					vaciarModalOrganismo();
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

	function terminar(){		
		var $form = $('#formPpal');
		$.ajax({
			url: $form.attr('action'),
			type: $form.attr('method'),
			data: $form.serialize(), // serializes the form's elements.			
			error: function (jqXHR, textStatus, errorThrown) {
				swal({
					title: "Error",
					text: "<?=$textos['notificacion_error']?>",
					type: "error",
					buttonsStyling: false,
					confirmButtonClass: "btn btn-rose"
				}).catch(swal.noop);
			},
			success: function (data, textStatus, jqXHR) {
				var datos = JSON.parse(data);
				actualizarPorcentajes(datos.porcentajes);
				if(datos.porcentajes.total.cantidad==datos.porcentajes.total.completados){
					$.post("iniciativas/perfiles/terminar", { idperfil: <?=$perfil['idperfil']?> })
					.done(function( data ) {
						window.onbeforeunload = function() { null };
						window.location.replace("<?=base_url()?>iniciativas/perfiles/principal");
					});
				}else{
					swal({
						title: "Error",
						text: "<?=$textos['submit_error']?>",
						type: "error",
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}
			},
		});
	}

	function subsectores(){
		$('.delsector').each(function() {
			const sector = $(this).data('sector');
			const valorSeleccionado = $(this).parent().parent().parent().find('select').val();
			if(sector == valorSeleccionado){
				$(this).show();
			}else{
				$(this).hide();
			}
		});
	} 

	function cerrada(){
		window.onbeforeunload = function() { null };
		swal({
			title: 'Convocatoria cerada',
			text: "Ya no puede realizar cambios, la convocatoria ha cerrado",
			type: 'error',
			showCancelButton: true,
			confirmButtonClass: 'btn btn-success',
			cancelButtonClass: 'btn btn-danger',
			confirmButtonText: 'Salir!',
			buttonsStyling: false
		}).then(function(result) {
			window.location.replace("<?=base_url()?>iniciativas");					
			
		}).catch(swal.noop);
	}

	function multipleTabs(){
		$.post("iniciativas/perfiles/multipleTabs", { tabID: tabID })
			.done(function( data ) {
				if(data!=''){
					clearInterval(myVar);
					window.onbeforeunload = function() { null };
					swal({
						title: 'Error',
						text: "Usted tiene abierta este editor en otro navegador o tab. La información no se guardará correctamente. Por favor edite desde un solo lugar.",
						type: 'error',
						showCancelButton: true,
						confirmButtonClass: 'btn btn-success',
						cancelButtonClass: 'btn btn-danger',
						confirmButtonText: 'Salir!',
						buttonsStyling: false
					}).then(function(result) {
						if (result.value) {							
							window.location.replace("https://fontagro.org");							
						}
					}).catch(swal.noop);
				}
			});
	}

	function checkAlertas(){
		$.get( "alertas/getAlertas").done(function( data ) {
			var datos = JSON.parse(data);
			//console.log(datos);
			$('#alertas').html('');
			var sinVer = 0;
			for(var i=0; i<datos.alertas.length; i++){
				var bold = '';
				if(datos.alertas[i].leido==null){
					sinVer++;
					bold = 'font-weight-bold'
				}
				$('#alertas').append('<a class="dropdown-item dropdown-item-rose '+bold+'" href="javascript:verAlerta('+datos.alertas[i]['idalerta']+')">'+datos.alertas[i]['titulo']+'  &nbsp; &nbsp;&nbsp;<small style="padding:0">'+datos.alertas[i]['created']+'</small></a><div class="dropdown-divider"></div>')
				
			}
			if(sinVer==0){
				$('#alertaNum').hide();
				document.title = TITULO;
			}else{
				$('#alertaNum').html(sinVer);
				$('#alertaNum').show();
				document.title = '('+sinVer+') '+TITULO;
			}				
		});
	}

	function verAlerta(idalerta){
		$.post( "alertas/getAlerta", {idalerta:idalerta}).done(function( data ) {
			var datos = JSON.parse(data);			
			swal({
				title: datos.alerta.titulo,
				html: datos.alerta.contenido,
				type: 'info',
				showCancelButton: true,
				showCloseButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ver',
				cancelButtonText: 'Eliminar Alerta'
			}).then(function(result) {
				if (result.value) {//ver
					if(datos.alerta.link!=''){
						window.location.href = datos.alerta.link;
					}
				} else if (result.dismiss === Swal.DismissReason.cancel) {//eliminar alerta
					$.post( "alertas/cerrarAlerta", {idalerta:idalerta}).done(function( data ) {checkAlertas();});
				}
			});
			checkAlertas();
		});
	}
</script>
