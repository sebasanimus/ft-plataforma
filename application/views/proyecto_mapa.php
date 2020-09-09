<!DOCTYPE html>
<html lang="<?=$lang?>">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
	<title><?=$textos['proyhome_titulo']?></title>
	<meta name="description" content="<?=$textos['proyhome_descripcion']?>">
	<link rel="shortcut icon" href="<?=base_url()?>favicon.ico">
    <meta name="author" content="ANIMUS">


	<link href="<?=base_url()?>css/proyecto/style.css" rel="stylesheet">
	<link href="https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css" rel="stylesheet" />



	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@FONTAGROdigital">
	<meta name="twitter:title" content="<?=$textos['proyhome_titulo']?>">
	<meta name="twitter:description" content="<?=$textos['proyhome_descripcion']?>">
	<meta name="twitter:creator" content="@FONTAGROdigital">
	<meta name="twitter:image" content="<?=base_url()?>img/prod.jpg">

	<!-- Open Graph data -->
	<meta property="og:title" content="<?=$textos['proyhome_titulo']?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?=LINK_PROYECTOS?><?=$lang?>" />
	<meta property="og:image" content="<?=base_url()?>img/prod.jpg" />
	<meta property="og:description" content="<?=$textos['proyhome_descripcion']?>" />

	<style>
		#map{
			color: #000;
		}
	</style>

	<?php $this->load->view('googletag'); ?>
</head>
<body>
	<div id="worldMap" style="height: 110%;"></div>
	
	
	

	<script src="<?=base_url()?>js/proyecto/jquery-3.4.1.min.js"></script>
	<script src="https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js"></script>


<script>
	var center = window.innerWidth>1400? [0, 0] : [-50, 0];

	mapboxgl.accessToken = 'pk.eyJ1IjoiZm9udGFncm9kaWdpdGFsIiwiYSI6ImNrN2F1aTkyaTE3cGQzZXA2dGdjN2FqNjkifQ.HYt9e3Dbd221FxeGb8VR1Q';
    var map = new mapboxgl.Map({
        container: 'worldMap',
        style: 'mapbox://styles/fontagrodigital/ck7auytkv05zg1ip39puf6fpe',
        center: center,
        zoom: 2.0
    });
	map.scrollZoom.disable();
	// Add zoom and rotation controls to the map.
	map.addControl(new mapboxgl.NavigationControl());
    map.on('load', function() {
        // Add a new source from our GeoJSON data and
        // set the 'cluster' option to true. GL-JS will
        // add the point_count property to your source data.
        map.addSource('proyectos', {
            type: 'geojson',
            data:
                {
					"type": "FeatureCollection",
					"crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
					"features": [
						<?foreach($puntosMapa as $punto):
							$latlon = json_decode($punto['latlng'], true);?>
							{ "type": "Feature", "properties": { name: '<?=$punto['titulo_simple']?>', status: '<?=$punto['estado']==1? 'open':'closed'?>', pais: '<?=$punto['pais']?>', organismo: '<?=$punto['organismo']?>', identificador: '<?=$punto['identificador']?>', total: '<?=round($punto['total'])?>', url: '<?=$punto['url']?>', publicado: '<?=$punto['web_publicado']?>', urlvieja: '<?=$punto['urlvieja']?>' }, "geometry": { "type": "Point", "coordinates": [ <?=$latlon['lng']?>, <?=$latlon['lat']?>, 0.0 ] } },					
						<?endforeach?>
						<?foreach($puntosMapaEstimados as $punto):?>
							{ "type": "Feature", "properties": { name: '<?=$punto['titulo_simple']?>', status: '<?=$punto['estado']==1? 'open':'closed'?>', pais: '<?=$punto['pais']?>', organismo: '<?=$punto['organismo']?>', identificador: '<?=$punto['identificador']?>', total: '<?=round($punto['total'])?>', url: '<?=$punto['url']?>', publicado: '<?=$punto['web_publicado']?>', urlvieja: '<?=$punto['urlvieja']?>'}, "geometry": { "type": "Point", "coordinates": [<?=$punto['longitud']+rand(-1000,1000)/500?>, <?=$punto['latitud']+rand(-1000,1000)/500?> , 0.0 ] } },
						<?endforeach?>
					]
			},
            cluster: true,
            clusterMaxZoom: 14, // Max zoom to cluster points on
            clusterRadius: 50 // Radius of each cluster when clustering points (defaults to 50)
        });

        map.addLayer({
            id: 'clusters',
            type: 'circle',
            source: 'proyectos',
            filter: ['has', 'point_count'],
            paint: {
                // Use step expressions (https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions-step)
                // with three steps to implement three types of circles:
                //   * Blue, 20px circles when point count is less than 100
                //   * Yellow, 30px circles when point count is between 100 and 750
                //   * Pink, 40px circles when point count is greater than or equal to 750
                'circle-color': [
                    'step',
                    ['get', 'point_count'],
                    '#66cdcc',
                    25,//cantidad
                    '#19d596',
                    35,//cantidad
                    '#83c559'
                ],
                'circle-radius': [
                    'step',
                    ['get', 'point_count'],
                    20,//px
                    25,//cantidad
                    30,//px
                    35,//cantidad
                    40//px
                ]
            }
        });

        map.addLayer({
            id: 'cluster-count',
            type: 'symbol',
            source: 'proyectos',
            filter: ['has', 'point_count'],
            layout: {
                'text-field': '{point_count_abbreviated}',
                'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                'text-size': 12
            }
        });

        map.addLayer({
            id: 'unclustered-point',
            type: 'circle',
            source: 'proyectos',
            filter: ['!', ['has', 'point_count']],
            paint: {
                'circle-color': '#fff',
                'circle-radius': 8,
                'circle-stroke-width': 4,
                'circle-stroke-color': '#66cdcc'
            }
        });

        // inspect a cluster on click
        map.on('click', 'clusters', function(e) {
            var features = map.queryRenderedFeatures(e.point, {
                layers: ['clusters']
            });
            var clusterId = features[0].properties.cluster_id;
            map.getSource('proyectos').getClusterExpansionZoom(
                clusterId,
                function(err, zoom) {
                    if (err) return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                }
            );
        });
        
        // When a click event occurs on a feature in
        // the unclustered-point layer, open a popup at
        // the location of the feature, with
        // description HTML from its properties.
        map.on('click', 'unclustered-point', function(e) {
            var coordinates = e.features[0].geometry.coordinates.slice();
            var titulo = e.features[0].properties.name;
            var codigo = e.features[0].properties.identificador;
			var ejecutor = e.features[0].properties.organismo+' - '+ e.features[0].properties.pais;
			var total = e.features[0].properties.total;
			console.log(e.features[0].properties);
            var ver = (e.features[0].properties.url=='' || e.features[0].properties.publicado==0) ? '' : '<a target="_parent"  href="<?=LINK_PROYECTOS?>'+e.features[0].properties.url+'/<?=$lang?>"><?=$textos['conocer_mas']?></a>'
            if(ver==''){
				//if(e.features[0].properties.urlvieja==''){
					ver = '<a target="_parent" href="https://www.fontagro.org/es/resultados/buscador-de-proyectos/"><?=$textos['conocer_mas']?></a>';
				/*}else{
					ver = '<a target="_parent" href="'+e.features[0].properties.urlvieja+'"><?=$textos['conocer_mas']?></a>';
				}*/
			}
			// Ensure that if the map is zoomed out such that
            // multiple copies of the feature are visible, the
            // popup appears over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }			
            new mapboxgl.Popup()
                .setLngLat(coordinates)
                .setHTML("<h5>"+titulo+"</h5>" +
						"<div><span><?=$textos['proyectos_dato_1']?>:</span> <span></span>"+codigo+"</div>"+
						"<div><span><?=$textos['proyhome_ejecutor']?>:</span> <span></span>"+ejecutor+"</div>"+
						"<div><span><?=$textos['proyectos_dato_6']?>:</span> <span></span>"+total+" USD</div>"+ver)
                .addTo(map);
        });

        map.on('mouseenter', 'clusters', function() {
            map.getCanvas().style.cursor = 'pointer';
        });
        map.on('mouseleave', 'clusters', function() {
            map.getCanvas().style.cursor = '';
		});
		
		map.on('mouseenter', 'unclustered-point', function() {
            map.getCanvas().style.cursor = 'pointer';
        });
        map.on('mouseleave', 'unclustered-point', function() {
            map.getCanvas().style.cursor = '';
        });
	});
	
</script>
<?php $this->load->view('target_blank'); ?>
</body>
</html>