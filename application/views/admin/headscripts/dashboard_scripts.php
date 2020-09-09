<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="material/assets/js/plugins/jquery-jvectormap.js"></script>
<!-- Chartist JS -->
<script src="material/assets/js/plugins/chartist.min.js"></script>

<script>
    $(document).ready(function(){
		md.initDashboardPageCharts();
		iniciarMapa();
	});

	function iniciarMapa(){ 
		$("#worldMap").vectorMap({
			map:"world_mill_en",
			backgroundColor:"transparent",
			zoomOnScroll:!1,
			regionStyle:{
				initial:{
					fill:"#e4e4e4",
					"fill-opacity":.9,
					stroke:"none",
					"stroke-width":0,
					"stroke-opacity":0
				}
			},
			series:{
				regions:[
					{
						values:{
							<?foreach($aportes['paises'] as $pais):?>
							<?=$pais['code']?>:<?=$pais['total']?>, 
							<?endforeach?>
						},
						scale:["#e4e4e4","#444444"],
						normalizeFunction:"polynomial"
					}]
				}
			}
		)
	}
</script>
