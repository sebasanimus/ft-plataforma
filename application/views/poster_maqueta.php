<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta name="author" content="ANIMUS">
	
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

	<title><?=$webstory['titulo']?></title>
	<meta name="description" content="<?=$webstory['bajada']?>">
	<link rel="shortcut icon" href="<?=base_url()?>favicon.ico">

	<link href="<?=base_url()?>pdf_resources/stylePoster.css" rel="stylesheet">
	<link href="<?=base_url()?>pdf_resources/gridlex.min.css" rel="stylesheet">
	<link href="<?=base_url()?>css/webstory/jvectormap.css" rel="stylesheet">

	<?
		$colornumber = rand(1, 4); 
		if($colornumber == 1){
			$color = "#46a084";
			$colorDark = "#3a8269";
		}
		if($colornumber == 2){
			$color = "#7eae58";
			$colorDark = "#6d9654";
		}
		if($colornumber == 3){
			$color = "#67aeb2";
			$colorDark = "#5a9495";
		}
		if($colornumber == 4){
			$color = "#29b883";
			$colorDark = "#23a172";
		}
	?>
	<style>
		.intro{
			background-color: <?php echo $colorDark; ?>;
		}
		.results{
			background-color: <?php echo $colorDark; ?>;
		}
		.results img{
			background-color: <?php echo $colorDark; ?>;
		}
		.qr h3{
			color: <?php echo $colorDark; ?>;
		}
		.titleMain{
			background-color: <?php echo $color; ?>;
		}
		.list .contadores .iconBox:after{
			background-color: <?php echo $color; ?>;
		}
		.main{
			color: <?php echo $color; ?>;
		}
		h2{
			color: <?php echo $color; ?>;
		}
	</style>
</head>
<body>
	<div id="page" class="container">
		<div class="grid-noGutter fullHW">
			<div class="col-12 mainContent">
				<div class="grid-noGutter-equalHeight fullHW fullContent">
					<div class="col-5">
						<div class="table fullHW">
							<div class="row">
								<div class="cell titleMain white">
									<div class="grid-noGutter fullHW">
										<div class="col-12">
											<div class="infoTitle">
												<div class="institution">
													<?=$ejecutor['nombre']?>,
													<?=empty($ejecutor['nombre_largo'])?'':$ejecutor['nombre_largo'].','?>
													<?=$ejecutor['pais']?>
												</div>
												<!--<div class="author">
													Dr. José Alberto Yau Quintero (yau_55@yahoo.com)
												</div>-->
											</div>
										</div>
										<div class="col-12-bottom">
											<h1><?=$webstory['titulo']?></h1>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="cell intro white">
									<div class="fullHW alignMiddle">
										<h4><?=$webstory['bajada']?></h4>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="cell mapa">
									<div id="worldMap" style="height: 100%;"></div>
									<div class="countries">
										<?foreach($paises as $pais):?>
										<span> <?=$pais['nombre']?> <b>/</b> </span>
										<?endforeach?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="cell list">
									<!-- Counters -->
									<div id="contadores" class="contadores fullHW alignMiddle">
										
											<div class="grid-equalHeight contadoresBox">
												<?
												foreach($indicadores as $ind):
												?>
													<div class="col-12 counterBox">
														<div class="grid-noBottom-middle">
															<div class="col-3 alignCenter iconBox">
																<img src="<?=base_url()?>img/iconos/<?=$ind['icono']?>.svg" alt="<?=$ind['nombre']?>" class="icon">							
															</div>
															<div class="col-9">
																<div class="number main"><?=$ind['prefijo']?><?=$ind['valor']?><?=$ind['unidad']?></div>
																<div class="numTxt"><?=$ind['nombre']?></div>
															</div>
														</div>
													</div>
												<?endforeach?>							
											</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-7">
						<div class="table fullHW">
							<div class="row">
								<div class="cell imagePoster coverBg fullHW" style="background-image: url(<?=base_url()?>uploads/webstories/<?=$webstory['foto_principal']?>)">
									<!-- Información -->
									<div id="informacion" class="informacion">
										<div class="grid-10-right">
											<?foreach($badges as $badge):?>
											<div class="col">
												<img src="<?=base_url()?>uploads/badges/<?=$badge['foto']?>" alt="<?=$badge['nombre']?>" title="<?=$badge['descripcion']?>">
											</div>
											<?endforeach?>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="cell init">
									<div class="titleBox">
										<h3 id="subtitle01">
											<?=$webstory['iniciativa_titulo']?>
										</h3>
										<h2 id="title01">
											<?=$textos['iniciativa']?>
										</h2>
									</div>
									<div class="txtBlock twoCols">
										<p>
											<?=nl2br($webstory['iniciativa_descripcion'])?>
										</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="cell solution">
									<div class="titleBox">
										<h3 id="subtitle02">
											<?=$webstory['solucion_titulo']?>
										</h3>
										<h2 id="title02">
											<?=$textos['solucion']?>
										</h2>
									</div>
									<div class="txtBlock twoCols">
										<p><?=nl2br($webstory['solucion_descripcion'])?></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="cell media">
									<?if(!empty($webstory['infografia']) || !empty($webstory['codigo_infografia'])):?>
									<!-- Infografía -->
										<div id="infografia" class="infografia">
											<div class="box alignCenter">
												<div class="titleBox ">
													<h3 class="main"><?=$webstory['infografia_titulo']?></h2>
												</div>
												<div class="graphicBox">
													<?if(!empty($webstory['codigo_infografia'])):?>
														<?=$webstory['codigo_infografia']?>
													<?else:?>
														<img src="<?=base_url()?>uploads/webstories/<?=$webstory['infografia']?>" alt="<?=$webstory['infografia_titulo']?>">
													<?endif?>
													
												</div>
											</div>
										</div>
									<?endif?>
								</div>
							</div>
							<div class="row">
								<div class="cell results fullHW white">
									<div class="qr">
										<h3>Más info</h3>
										<?php
										$colorcode = substr($colorDark, 1);
										?>
										<img src="<?=base_url()?>exportarposter/getQR/<?=$webstory['url']?>/<?=$lang?>/FFFFFF/<?php echo $colorcode; ?>" />					
									</div>
									
									<div class="titleBox">
										<h2 id="title03">
											<?=$textos['impactos_resultados']?>
										</h2>
									</div>
									<div class="txtBlock twoCols">
										<p>
											<?=nl2br($webstory['resultados'])?>
										</p>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 footer">
				<div class="footerBox fullHW">
					<div class="grid-middle-noBottom fullHW">
						<div class="col-5">
							<!-- Donantes -->
							<div id="donantes" class="donantes">
								<div class="grid-noBottom-middle">
									<div class="col-12">
										<h5 class="titleCol"><?=$textos['donantes']?></h5>
									</div>
									<div class="col-12">
										<div class="grid-6-noBottom-middle">
											<? $i = 1; ?>
											<?foreach($donantes as $dona):
												$nombre = empty($dona['nombre_largo'])? $dona['nombre'] : $dona['nombre_largo'].' ('.$dona['nombre'].')';
												if(!empty($dona['pais'])) $nombre .= ' - '.$dona['pais'];
												?>
												<div class="col alignLeft">
													<img class="grayscale" src="<?=base_url()?>uploads/organismos/<?=$dona['logo']?>" alt="<?=$nombre?>"  title="<?=$nombre?>">
												</div>
												<? if (++$i == 6) break; ?>
											<?endforeach?>	
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6">
							<!-- logos -->
							<div id="logos" class="logos">
								<div class="grid-noBottom-middle">
									<div class="col-12">
										<h5 class="titleCol"><?=$textos['logos']?></h5>
									</div>
									<div class="col-12">
										<div class="grid-8-noBottom">
											<? $i2 = 1; ?>
											<?foreach($organismos as $org):
												$nombre = empty($org['nombre_largo'])? $org['nombre'] : $org['nombre_largo'].' ('.$org['nombre'].')';
												if(!empty($org['pais'])) $nombre .= ' - '.$org['pais'];
												?>
												<div class="col alignLeft">
													<img class="grayscale" src="<?=base_url()?>uploads/organismos/<?=$org['logo']?>" alt="<?=$nombre?>"  title="<?=$nombre?>">
												</div>
												<? if (++$i2 == 9) break; ?>
											<?endforeach?>	
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-1 alignRight">
							<img class="fontagro" src="<?=base_url()?>/pdf_resources/images/fontagroFooter.png" alt="FONTAGRO">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /container -->

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>


<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?=base_url()?>material/assets/js/plugins/jquery-jvectormap.js"></script>
<script>
	var colorData = ["<?php echo $color; ?>","<?php echo $colorDark; ?>"]
	
	$(document).ready(function() {
		$("#worldMap").vectorMap({
			map:"world_mill_en",
			backgroundColor:"transparent",
			zoomOnScroll:!1,
			zoomButtons : false,
			regionStyle:{
				initial: {
					fill:"#d2d2d2",
					"fill-opacity":.9,
					stroke:"none",
					"stroke-width":0,
					"stroke-opacity":0
				}
			},
			focusOn: {
				regions: [<?foreach($paises as $pais):?>	
							"<?=$pais['code']?>",
						<?endforeach?>]
			},
			series:{
				regions:[
					{
						values:{
						<?foreach($paises as $pais):?>	
							<?=$pais['code']?>:<?=$pais['participacion']?>,
						<?endforeach?>		
						},
						scale:colorData,
						normalizeFunction:"polynomial"
					}
				]
			}
		});
	});
</script>

</body>
</html>
