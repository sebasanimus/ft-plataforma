    <script>
    $(document).ready(function(){
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

		$('#idorganismo').select2({
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
		}).on('select2:select', function(event) {
			// This is how I got ahold of the data
			var organismo = event.params.data;
			console.log(organismo);
			$('#pais').selectpicker('val', organismo.idpais);
			$('#tipo_institucion').selectpicker('val', organismo.tipo_institucion);
		});
    });
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
    </script>