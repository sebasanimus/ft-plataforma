<script>
$(document).ready(function(){
	$('.form-check-input').change(function() {
		$('.form-check-seleccionado').removeClass('form-check-seleccionado');
		$(".form-check-input:checked").parent().addClass('form-check-seleccionado');
	});

	$('.sector-input').change(function() {
		$('.subsector'+$(this).val()).toggle('slow');
		$('.subsector'+$(this).val()+' .form-check-input:checked').prop('checked', false);
		$('.subsector'+$(this).val()+' .form-check-input:checked').trigger('change');
	});

});
</script>