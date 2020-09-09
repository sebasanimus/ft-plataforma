<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="material/assets/js/plugins/bootstrap-tagsinput.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/jQuery.auto-save-form.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
	<script src="js/jasny-bootstrap.js"></script>

<script>
	var TITULO = document.title;
	var paso = <?=$paso?>;
	var tabID = window.name==''? Math.round(Math.random()*100000000000000) : window.name;
	window.name = tabID;
	var myVar = null;

	$(function() {
		

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
			notificar('danger', '<?=$textos['ista_notificacion_error']?>');
		});
		$form.on('saveSuccess.autoSaveForm', function (ev, $form, data, textStatus, jqXHR) {
			try{
				var datos = JSON.parse(data);
				if (datos.error==''){
					actualizarPorcentajes(datos.porcentajes);
					var d = new Date();
					notificar('success', '<?=$textos['ista_notificacion_exito']?> '+d.toLocaleTimeString());
				}else if(datos.error=='cerrada'){
					cerrada();
				}else{
					notificar('danger', datos.error);
				}
			} catch(e) {
				notificar('danger', '<?=$textos['ista_notificacion_error']?>');
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
		
		/*$.notify({
				icon: "add_alert",
				message: "<?=$textos['ista_notificacion_tiempo']?>:<br/><b><?=$falta['txt']?></b>"
			},{
				type: 'warning',
				timer: 10e3,
				placement:{
					from: 'bottom',
					align: 'right'
				}
			}
		);	*/	

		<?if($falta['dias']==0):?>
			setTimeout(function(){ cerrada(); }, <?=$falta['horas']*60*60+$falta['min']*60+$falta['seg']?>*1000);
		<?endif?>
		
		multipleTabs();
		myVar = setInterval(multipleTabs, 10*1000); //10seg

		checkAlertas();
		setInterval(function(){ checkAlertas(); }, 600*1000);//10min

		let dropArea = document.getElementById('adjuntoArea');
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
			let fileInput = document.getElementById('adjuntofile');
			fileInput.files = e.dataTransfer.files;
			amanopla(e.dataTransfer.files, e.dataTransfer.files[0]);
			agregarAdjunto();
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

		$('#adjuntofile').on("change", function(){ agregarAdjunto(); });
	});

	function actualizarPorcentajes(porcentajes){
		const porcentajeTotal = getPorcentaje(porcentajes.total.cantidad, porcentajes.total.completados, 0);
		$('.statusNumber').html(porcentajeTotal+'%');
		$('.barBox .progress-bar').css('width', porcentajeTotal+'%');
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
		
		for(let i=1; i<7; i++ ){
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
		/*if(paso==0 && !$('#leyo_manual').prop('checked') ){
			$('#check_aceptar').tooltip('show');
			return;
		}*/
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
		for(let i=1; i<=7; i++){
			if(i<paso){
				$('.menu'+i).addClass('filled');
			}else if(i==paso){
				$('.menu'+i).addClass('active');
			}
		}
	}

	function irAlPaso(){
		if(paso==0){
			$('#anterior').hide();
			$('#guardar').hide();
		}else if(paso==7){
			$('#siguiente').hide();
			$('#guardar').hide();		
		}else{
			$('#anterior').show();
			$('#guardar').show();
			$('#siguiente').show();
		}
		if(paso==6){
			$('#siguiente').text('<?=$textos['ista_submit_boton']?>');
		}else{
			$('#siguiente').text('<?=$textos['ista_siguiente']?>');
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


	function terminar(){		
		var $form = $('#formPpal');
		$.ajax({
			url: $form.attr('action'),
			type: $form.attr('method'),
			data: $form.serialize(), // serializes the form's elements.			
			error: function (jqXHR, textStatus, errorThrown) {
				swal({
					title: "Error",
					text: "<?=$textos['ista_notificacion_error']?>",
					type: "error",
					buttonsStyling: false,
					confirmButtonClass: "btn btn-rose"
				}).catch(swal.noop);
			},
			success: function (data, textStatus, jqXHR) {
				var datos = JSON.parse(data);
				actualizarPorcentajes(datos.porcentajes);
				if(datos.porcentajes.total.cantidad==datos.porcentajes.total.completados){
					$.post("admin/istas/terminar", { idista: <?=$ista['idista']?> })
					.done(function( data ) {
						window.onbeforeunload = function() { null };
						window.location.replace("<?=base_url()?>admin/dashboard");
					});
				}else{
					swal({
						title: "Error",
						text: "<?=$textos['ista_submit_error']?>",
						type: "error",
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}
			},
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
			window.location.replace("<?=base_url()?>admin");					
			
		}).catch(swal.noop);
	}

	function multipleTabs(){
		$.post("admin/istas/multipleTabs", { tabID: tabID })
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



	/********************************* ARCHIVOS *********************************/

function agregarAdjunto(){
	var file = $('#adjuntofile')[0].files[0];
	var upload = new Upload(file);
	// maby check size or type here with upload.getSize() and upload.getType()
	upload.doUpload();
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
	var idista = <?=$ista['idista']?>;

	if(this.file===undefined){
		swal({
			title: "Error",
			text: "Debe seleccionar un Archivo",
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

	formData.append("idista", idista);
	$('#progress-wrp').css('visibility', 'visible');
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>admin/istas/adjuntar",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
			$('#progress-wrp').css('visibility', 'hidden');
			if(data!='' && !data.startsWith('ok') ){
				swal({
					title: "Error",
					text: data,
					buttonsStyling: false,
					confirmButtonClass: "btn btn-rose"
				}).catch(swal.noop);
			}else{
				var dividido = data.split("***");
				if(dividido.length>1){	
					$('input[name="adjunto"]').val(dividido[1]);	
					$('#archivoNombre').html(dividido[1]);
					$('#adjuntoArea .sinarchivo').hide();
					$('#adjuntoArea .conarchivo').show();
					swal({
						title: "Éxito",
						text: 'Tu adjunto se ha cargado con éxito.',
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);	
				}else{
					swal({
						title: "Error",
						text: 'Ha ocurrido un error indeterminado.',
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
				}			
			}			
        },
        error: function (error) {
			$('#progress-wrp').css('visibility', 'visible');
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
    $(progress_bar_id + " .progress-badge").text('Subiendo '+percent + "%");
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
</script>
