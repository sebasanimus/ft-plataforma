

    <script>
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

	 var table;
    $(document).ready(function(){
		options = {
          "sAjaxSource": "admin/fontagros/paginar/",
		  "pageLength": 50,
          "columnDefs": [{
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
					var d = data.split('*');
					var retorno = '';
					if(d[1]==1){
						retorno += '<a target="_blank" href="exportar/enBreve/'+d[2]+'/es" class="btn btn-link btn-info btn-just-icon" title="PDF en Español" ><img src="img/flag_es.png"/></a> &nbsp;'+
								   '<a target="_blank" href="exportar/enBreve/'+d[2]+'/en" class="btn btn-link btn-info btn-just-icon" title="PDF en Inglés" ><img src="img/flag_en.png"/></a> &nbsp;';
					}
					return  retorno+'<a href="admin/fontagros/breve/'+d[0]+'"class="btn btn-link btn-warning btn-just-icon" title="Modificar" ><i class="material-icons">create</i></a> &nbsp;';
                    
                },
				"className": "text-right",
                "targets": 1
          }]
        };

		jQuery.extend(datatableMyConfig, options);
        table = $('#midatatable').DataTable(datatableMyConfig);

		$("textarea").each(function() {
			console.log($(this).attr('maxlength'));
			let maximo = ($(this).attr('maxlength') != undefined)?  $(this).attr('maxlength') : 0;
			registerSummernote('#'+$(this).attr('id'), $(this).attr('placeholder'), maximo, function(max) {
				console.log(max);
			});
			
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
	
    </script>