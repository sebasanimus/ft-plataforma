

<script>
	
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