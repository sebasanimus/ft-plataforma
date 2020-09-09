<!-- Datatables -->
<script src="material/assets/js/plugins/datatables.min.js"></script>

<script>
var datatableMyConfig = {
	"language": {
		"url": "js/Spanish.json"
	},
	"drawCallback": function(settings, json) {
		$('[data-toggle="tooltip"]').tooltip(); 
	},
	"bProcessing": true,
	"bServerSide": true,
	"drawCallback": function () {
		$('.dataTables_paginate > .pagination').addClass('pagination-rose');
	},
	"fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
	oSettings.jqXHR = $.ajax( {
		"dataType": 'json',
		"type": "POST",
		"url": sSource,
		"data": aoData,
		"success": fnCallback
	} );
	}
} ;   
</script>