<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
	<script src="material/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>

	<script>
	$(document).ready(function(){
		$('.datetimepicker').datetimepicker({
               icons: {
                   time: "fa fa-clock-o",
                   date: "fa fa-calendar",
                   up: "fa fa-chevron-up",
                   down: "fa fa-chevron-down",
                   previous: 'fa fa-chevron-left',
                   next: 'fa fa-chevron-right',
                   today: 'fa fa-screenshot',
                   clear: 'fa fa-trash',
                   close: 'fa fa-remove'
			   },
			   locale: 'es'
			});
	});
			
	</script>