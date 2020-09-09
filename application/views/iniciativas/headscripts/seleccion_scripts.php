<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="material/assets/js/plugins/bootstrap-tagsinput.js"></script>

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

		actualizarPorcentajes(<?=json_encode($porcentajes)?>);
		
		checkAlertas();
		setInterval(function(){ checkAlertas(); }, 600*1000);//10min

		let dropArea1 = document.getElementById('adjuntoArea1');
		['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
			dropArea1.addEventListener(eventName, preventDefaults, false);
		});

		['dragenter', 'dragover'].forEach(eventName => {
			dropArea1.addEventListener(eventName, highlight1, false);
		});

		;['dragleave', 'drop'].forEach(eventName => {
			dropArea1.addEventListener(eventName, unhighlight1, false);
		});
		dropArea1.addEventListener('drop', handleDrop1, false)

		function handleDrop1(e) {
			let fileInput = document.getElementById('adjuntofile1');
			fileInput.files = e.dataTransfer.files;
			amanopla(e.dataTransfer.files, e.dataTransfer.files[0], 1);
			agregarAdjunto(1);
		}
		function preventDefaults (e) {
			e.preventDefault();
			e.stopPropagation();
		}

		function highlight1(e) {
			dropArea1.classList.add('highlight')
		}

		function unhighlight1(e) {
			dropArea1.classList.remove('highlight')
		}

		$('#adjuntofile1').on("change", function(){ agregarAdjunto(1); });
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
		
		for(let i=1; i<2; i++ ){
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
		paso++;
		irAlPaso();
	}

	function anterior(){
		paso--;
		irAlPaso();
	}

	function cambiarPaso(step){
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
		for(let i=1; i<=1; i++){
			if(i<paso){
				$('.menu'+i).addClass('filled');
			}else if(i==paso){
				$('.menu'+i).addClass('active');
			}
		}
	}

	function irAlPaso(){
		if(paso==1){
			$('#anterior').hide();
			$('#guardar').show();
		}else if(paso==2){
			$('#siguiente').hide();
			$('#guardar').hide();		
		}else{
			$('#anterior').show();
			$('#guardar').show();
			$('#siguiente').show();
		}
		if(paso==1){
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

function agregarAdjunto(num){
	var file = $('#adjuntofile'+num)[0].files[0];
	var upload = new Upload(file);
	// maby check size or type here with upload.getSize() and upload.getType()
	upload.doUpload(num);
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
Upload.prototype.doUpload = function (num) {
    var that = this;
    var formData = new FormData();
	var idperfil = <?=$perfil['idperfil']?>;

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

	formData.append("idperfil", idperfil);
	$('#progress-wrp'+num).css('visibility', 'visible');
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>iniciativas/perfiles/adjuntar",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
				if(num==1){
					myXhr.upload.addEventListener('progress', that.progressHandling1, false);
				}else{
                	myXhr.upload.addEventListener('progress', that.progressHandling2, false);
				}
            }
            return myXhr;
        },
        success: function (data) {
			$('#progress-wrp'+num).css('visibility', 'hidden');
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
					if(num==1){
						$('input[name="adjunto_seleccion"]').val(dividido[1]);
						$('input[name="adjunto_seleccion"]').trigger("change");
					}						
					$('#archivoNombre'+num).html(dividido[1]);
					$('#adjuntoArea'+num+' .sinarchivo').hide();
					$('#adjuntoArea'+num+' .conarchivo').show();
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
			$('#progress-wrp'+num).css('visibility', 'visible');
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

Upload.prototype.progressHandling1 = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp1";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .progress-badge").text('Subiendo '+percent + "%");
};

Upload.prototype.progressHandling2 = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp2";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .progress-badge").text('Subiendo '+percent + "%");
};



function amanopla(files, file, num){
	var preview = $('#fileinputAdjunto'+num+' .fileinput-preview');
	var element =  $('#fileinputAdjunto'+num);
	
	var text = file.name;
	var $nameView = element.find('.fileinput-filename');

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
</script>
