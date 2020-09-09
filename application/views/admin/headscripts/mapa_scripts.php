<script src="<?=base_url()?>js/OSMLocationPicker.js"></script>
<script type="text/javascript">
var startPoint = [<?=$startingPoint['lat']?>, <?=$startingPoint['lng']?>];
var map = L.map('mapa', {editable: true}).setView(startPoint, 6),
    tilelayer = L.tileLayer('http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {maxZoom: 20, attribution: 'Data \u00a9 <a href="http://www.openstreetmap.org/copyright"> OpenStreetMap Contributors </a> Tiles \u00a9 HOT'}).addTo(map);

    L.EditControl = L.Control.extend({

        options: {
            position: 'topleft',
            callback: null,
            kind: '',
            html: ''
        },

        onAdd: function (map) {
            var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar'),
                link = L.DomUtil.create('a', '', container);

            link.href = '#';
            link.title = 'Create a new ' + this.options.kind;
            link.innerHTML = this.options.html;
            L.DomEvent.on(link, 'click', L.DomEvent.stop)
                      .on(link, 'click', function () {
                        window.LAYER = this.options.callback.call(map.editTools);
                      }, this);

            return container;
        }

    });

var isDirty = false;
var idlocal = 1;
var elementos = new Array();  
var aux;

window.onload = function() {
    window.addEventListener("beforeunload", function (e) {
        if (!isDirty) {
            return undefined;
        }

        var confirmationMessage = 'Los cambios no guardados se perderán ¿Está seguro que desea irse?';

        (e || window.event).returnValue = confirmationMessage; //Gecko + IE
        return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
    });
}; 
var grupeteArray = new Array();

<? 	foreach($elementos as $elem):?>

		var nuevoElemento = new Object();
		nuevoElemento.idlocal = idlocal;
		nuevoElemento.idelemento = <?=$elem['idelemento']?>;
		idlocal++;

		<?if($elem['tipo']=='marcador'):?>
			aux = L.marker([<?=$elem['latlng']['lat']?>, <?=$elem['latlng']['lng']?>]).addTo(map);
		<?else:?>
			aux =  L.polygon([[
				<?foreach($elem['latlng'] as $latlng):?>
					[<?=$latlng['lat']?>, <?=$latlng['lng']?>],
				<?endforeach?>
			]]).addTo(map);
		<?endif?>
		aux.enableEdit();
		grupeteArray.push(aux);

		nuevoElemento.elem = aux;
		if (aux instanceof L.Path){
			nuevoElemento.tipo = 'poligono';
		}else if(aux instanceof L.Marker) {
			nuevoElemento.tipo = 'marcador'; 
		}
		nuevoElemento.link = '<?=$elem['link']?>';
		nuevoElemento.foto = '<?=$elem['foto']?>';
		nuevoElemento.esppal = <?=$elem['esppal']?>;
		<?foreach($lenguajes as $lenguaje):?>
			nuevoElemento.nombre_<?=$lenguaje->codlang?>='<?=$elem['nombre_'.$lenguaje->codlang]?>';
			nuevoElemento.descripcion_<?=$lenguaje->codlang?>='<?= str_replace(array("\r", "\n"), '', $elem['descripcion_'.$lenguaje->codlang]) ?>';
		<?endforeach?>
		aux.bindPopup(getPopupHtml(nuevoElemento))
		elementos.push(nuevoElemento);

<? 	endforeach ?>
actualizarLista();

<?if(!empty($elementos)):?>
	var grupete = L.featureGroup(grupeteArray);
	map.fitBounds(grupete.getBounds());
<?endif?>

function empezarPoligono(){
	map.editTools.startPolygon().on("editable:drawing:end", terminoDibujar).on('dragend', seMovio);
}

function empezarMarcador(){
	map.editTools.startMarker().on("editable:drawing:end", terminoDibujar).on('dragend', seMovio);
}

var seMovio = function (e) {
	console.log('Se movio', e);
	isDirty = true;
}
var terminoDibujar = function (e) {
	var nuevoElemento = new Object();
	nuevoElemento.idlocal = idlocal;
	idlocal++;
	nuevoElemento.elem = e.layer;
	if (e.layer instanceof L.Path){
		nuevoElemento.tipo = 'poligono';
	}else if(e.layer instanceof L.Marker) {
		nuevoElemento.tipo = 'marcador'; 
	}
	nuevoElemento.link = '';
	nuevoElemento.esppal = 0;
	nuevoElemento.foto = '';
	<?foreach($lenguajes as $lenguaje):?>
		nuevoElemento.nombre_<?=$lenguaje->codlang?>='';
		nuevoElemento.descripcion_<?=$lenguaje->codlang?>='';
	<?endforeach?>
	elementos.push(nuevoElemento);
	isDirty = true;
	actualizarLista();
	modificar(nuevoElemento.idlocal);
}


//poligono._latlngs[0]
//poligono.toGeoJSON();
/*
map.on('layeradd', function (e) {
	if (e.layer instanceof L.Path) e.layer.on('click', L.DomEvent.stop).on('click', deleteShape, e.layer);
	/*if (e.layer instanceof L.Marker){
		console.log(e.layer);
		e.layer.on('click', L.DomEvent.stop).on('click', deleteMarker, e.layer);
	}
});	*/


function cancelar() {
 	window.history.back();
}


function guardar(){
	var elementosAEnviar = new Array();
	for(var i=0; i<elementos.length; i++){		
		var nuevoE = jQuery.extend({}, elementos[i]);
		if (nuevoE.tipo == 'poligono'){
			let serializado = Object();
			let i=0;
			for(i=0; i < nuevoE.elem._latlngs[0].length; i++){
				serializado[i] = Object();
				serializado[i].lat = nuevoE.elem._latlngs[0][i].lat;
				serializado[i].lng = nuevoE.elem._latlngs[0][i].lng;
			}
			nuevoE.latlng =  serializado;
		}else if(nuevoE.tipo == 'marcador') {
			nuevoE.latlng = nuevoE.elem._latlng;
		}
		delete nuevoE.elem; 
		elementosAEnviar.push(nuevoE);
	}
	
	$.post( "admin/mapas/guardarElementos/<?=$idmapa?>", {elementos: JSON.stringify(elementosAEnviar) } )
		.done(function( data ) {
			if(data==''){
				isDirty = false;
				swal({
					title: '¡Guardado!',
					text: 'El mapa y todos sus cambios han sido guardados.',
					type: 'success',
					confirmButtonClass: "btn btn-success",
					buttonsStyling: false
				});
			}else{
				swal({
					title: 'Error',
					text: data,
					type: 'error',
					buttonsStyling: false,
					confirmButtonClass: "btn btn-rose"
				});
			}
		})
}

function actualizarLista(){
	$('#contenedorElementos').html('');
	elementos.forEach(procesarLista);	
}

function procesarLista(item) {
	let nombre = item.nombre_es==''? 'Sin nombre' : item.nombre_es;
	let descripcion = item.descripcion_es==''? 'Sin descripción' : item.descripcion_es;
	var card = '<div class="rotating-card-container">'+
					'<div class="card card-rotate">'+
						'<div class="front" >'+
							'<div class="card-body">'+
									'<button class="btn btn-'+(item.tipo=='marcador'? (item.esppal? 'success':'dark'):'info')+' btn-round btn-fab float-left" style="position: fixed;"  >'+
										'<i class="material-icons">'+(item.tipo=='marcador'? 'room':'map')+'</i>'+
									'</button>'+
									'<div class="message">'+
										'<h6 class="card-category">'+nombre+'</h6>	'+												
										'<p class="card-description">'+descripcion+'</p>'+
									'</div>'+
							'</div>'+
						'</div>'+
						'<div class="back" >'+
							'<div class="card-body">	'+												
								'<div class="footer justify-content-center">'+
									'<button onclick="multimedia('+item.idlocal+')" class="btn btn-link btn-primary btn-just-icon" title="Agregar Multimedia">'+
										'<i class="material-icons">photo_camera</i>'+
									'</button>'+
									'<button onclick="modificar('+item.idlocal+')" class="btn btn-link btn-warning btn-just-icon" title="Editar Punto">'+
										'<i class="material-icons">mode_edit</i>'+
									'</button>'+
									'<button onclick="eliminar('+item.idlocal+')" class="btn btn-link btn-danger btn-just-icon" title="Eliminar Punto">'+
										'<i class="material-icons">delete</i>'+
									'</button>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';
    $("#contenedorElementos").append(card);
}

function eliminar(id){	
	swal({
		title: '¿Está Seguro?',
		text: "¿Desea eliminarlo?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonClass: 'btn btn-success',
		cancelButtonClass: 'btn btn-danger',
		confirmButtonText: 'Si, eliminalo!',
		buttonsStyling: false
	}).then(function(result) {
		if (result.value) {
			var i=0;
			for(i=0; i<elementos.length; i++){
				if(elementos[i].idlocal==id){
					map.removeLayer(elementos[i].elem);
					break;
				}
			}
			isDirty = true;
			elementos.splice(i, 1); 
			actualizarLista();		
		}
	}).catch(swal.noop);
}

function modificar(id){
	let elemento = getElementoById(id);
	$('#ele_idlocal').val(id);
	$('#ele_link').val(elemento.link);
	$('#ele_esppal').prop("checked", elemento.esppal); 
	<?foreach($lenguajes as $lenguaje):?>
		$('#ele_nombre_<?=$lenguaje->codlang?>').val(elemento.nombre_<?=$lenguaje->codlang?>);
		$('#ele_descripcion_<?=$lenguaje->codlang?>').val(elemento.descripcion_<?=$lenguaje->codlang?>);
	<?endforeach?>
	(elemento.tipo=='marcador')? $('#row_esppal').show() : $('#row_esppal').hide(); //solo los marcadores pueden ser ppal
	$('#elementoModal').modal('show');
			
}

function aplicarModificacion(){
	var id = $('#ele_idlocal').val();
	let elemento = getElementoById(id);
	elemento.link = $('#ele_link').val();
	elemento.esppal = (elemento.tipo=='marcador')? $('#ele_esppal').is(":checked") : 0; //solo los marcadores pueden ser ppal
	<?foreach($lenguajes as $lenguaje):?>
		elemento.nombre_<?=$lenguaje->codlang?> = $('#ele_nombre_<?=$lenguaje->codlang?>').val();
		elemento.descripcion_<?=$lenguaje->codlang?> = $('#ele_descripcion_<?=$lenguaje->codlang?>').val();
	<?endforeach?>
	elemento.elem.bindPopup(getPopupHtml(elemento));
			
	if(elemento.esppal){//solo puede haber 1 ppal
		for(var i=0; i<elementos.length; i++){
			if(elementos[i].idlocal==id) continue;
			elementos[i].esppal=0;
		}
	}

	actualizarLista();
	$('#elementoModal').modal('hide');
}

function getPopupHtml(elemento){
	var popuphtml = '<b>'+elemento.nombre_es+'</b><br/>'+elemento.descripcion_es+'<br/>' +
					'<button onclick="multimedia('+elemento.idlocal+')" class="btn btn-link btn-primary btn-just-icon" title="Agregar Multimedia">'+
								'<i class="material-icons">photo_camera</i>'+
							'</button>'+
							'<button onclick="modificar('+elemento.idlocal+')" class="btn btn-link btn-warning btn-just-icon" title="Editar Punto">'+
								'<i class="material-icons">mode_edit</i>'+
							'</button>'+
							'<button onclick="eliminar('+elemento.idlocal+')" class="btn btn-link btn-danger btn-just-icon" title="Eliminar Punto">'+
								'<i class="material-icons">delete</i>'+
							'</button>';
	return popuphtml;
}

function getElementoById(id){
	for(var i=0; i<elementos.length; i++){
		if(elementos[i].idlocal==id){
			return elementos[i];
		}
	}
	return null;
}

$(document).ready(function(){
	OSMPICKER.initmappicker('', '', map, {
		addressId: "direccion",
		latitudeId: "latitud",
		longitudeId: "longitud"
	});
});

/********************** ADJUNTOS *********************************************************************/

	function agregarAdjunto(){
		var file = $('#adjunto')[0].files[0];
		var upload = new Upload(file);
		// maby check size or type here with upload.getSize() and upload.getType()
		upload.doUpload();
	}

	function multimedia(id){		
		elemento = getElementoById(id);
		$('#adj_idlocal').val(id)
		$('#fileinputAdjunto').fileinput('reset');
		if(elemento.foto!='' ){
			$('#adj_thumbnail').show();
			$('#adj_thumbnailtext').hide();
			$('#adj_thumbnail').attr("src","<?=base_url()?>uploads/mapas/400_"+elemento.foto);
		}

		$("#progress-wrp .progress-bar").css("width", "0%");
		$("#progress-wrp .progress-badge").text("0%");
		$('#adjuntoModal').modal('show');				
		
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

		// add assoc key values, this will be posts values
		if(this.file==undefined){
			swal({
				title: "Error",
				text: "Debe seleccionar un Archivo",
				buttonsStyling: false,
				confirmButtonClass: "btn btn-rose"
			}).catch(swal.noop);
		}
		formData.append("idlocal", $('#adj_idlocal').val());
		formData.append("file", this.file, this.getName());
		formData.append("upload_file", true);
		
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>admin/mapas/adjuntar/",
			xhr: function () {
				var myXhr = $.ajaxSettings.xhr();
				if (myXhr.upload) {
					myXhr.upload.addEventListener('progress', that.progressHandling, false);
				}
				return myXhr;
			},
			success: function (data) {
				if(data.startsWith('***') ){
					isDirty = true;
					var datos = data.split('***');
					console.log(datos);
					var id = datos[1];
					var foto = datos[2];
					var elemento = getElementoById(id);
					elemento.foto = foto;
					$('#adjuntoModal').modal('hide');
				}else{					
					swal({
						title: "Error",
						text: data,
						buttonsStyling: false,
						confirmButtonClass: "btn btn-rose"
					}).catch(swal.noop);
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

</script>
<style>
.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 9999;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9; 
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
.inputbusqueda{
	width:300px;
	float:left;
	margin-right: 25px;
}
.panelbusqueda .bmd-form-group{
	float:left;
}
</style> 