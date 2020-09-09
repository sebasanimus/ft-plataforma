

    <script>
		$(document).ready(function(){
  			$('#componente').change(function () {
				$('.componente').hide();
				$('.componente'+$('#componente').val()).show();
				$('#indicastandar').val('');
			});
		});
    </script>