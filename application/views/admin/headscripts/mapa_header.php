	<link rel="stylesheet" href="<?=base_url()?>js/leaflet/leaflet.css" />
	<script src="<?=base_url()?>js/leaflet/leaflet.js"></script>
	<script src="<?=base_url()?>js/leaflet/Path.Drag.js"></script>
	<script src="<?=base_url()?>js/leaflet/Leaflet.Editable.js"></script>

  	<style type='text/css'>
		#mapa{ 
			position:relative; 
			top:0; 
			bottom:0; 
			right: 0; 
			left: 0; 
			width:100%; 
			height:600px
		}

		#contenedorElementos{
			width:100%; 
			height:600px; 
			overflow-y: auto;
			overflow-x: hidden;
			padding-right:10px;
		}

		.card .card-body .message {
			padding-left: 70px;		
			&::after {
				clear: both;
			}
		}
	</style>