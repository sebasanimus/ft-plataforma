<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
    <meta name="author" content="ANIMUS">
    <link href="<?=base_url()?>css/webstory/animate.min.css" rel="stylesheet">
	<link href="<?=base_url()?>css/webstory/style.css" rel="stylesheet">
	<link href="<?=base_url()?>css/webstory/swiper.min.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>css/webstory/lightgallery.min.css" />
	<link href="<?=base_url()?>css/webstory/jvectormap.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
	<!--link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" />-->

    <script src="<?=base_url()?>js/webstory/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<title><?=$webstory['titulo']?></title>
	<meta name="description" content="<?=$webstory['bajada']?>">
	<link rel="shortcut icon" href="<?=base_url()?>favicon.ico">

	<!-- CSS Facybox -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/webstory/jquery.fancybox.min.css">

	<!-- Parallax -->
	<script type="text/javascript" src="<?=base_url()?>js/webstory/ScrollMagic.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/TweenMax.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/animation.gsap.js"></script>

	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@FONTAGROdigital">
	<meta name="twitter:title" content="<?=$webstory['titulo']?>">
	<meta name="twitter:description" content="<?=$webstory['bajada']?>">
	<meta name="twitter:creator" content="@FONTAGROdigital">
	<meta name="twitter:image" content="<?=base_url()?>uploads/webstories/<?=$webstory['foto_principal']?>">

	<!-- Open Graph data -->
	<meta property="og:title" content="<?=$webstory['titulo']?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?=LINK_WEBSTORIES?><?=$webstory['url']?>" />
	<meta property="og:image" content="<?=base_url()?>uploads/webstories/<?=$webstory['foto_principal']?>" />
	<meta property="og:description" content="<?=$webstory['bajada']?>" />


	<?php $this->load->view('googletag'); ?>
</head>
<body>
	<div class="container">
		<div class="menu-wrap">
			<nav class="menu-top">
				<div class="profile"><img src="<?=base_url()?>img/webstory/fontagro-logo-color.svg" alt="FONTAGRO"/><span>webstories</span></div>
				<div class="icon-list">
					<a href="<?=$textos['twitter']?>" target="_blank"><i class="fa fa-fw fa-twitter"></i></a>
					<a href="<?=$textos['vimeo']?>" target="_blank"><i class="fa fa-fw fa-vimeo"></i></a>
					<a href="<?=$textos['youtube']?>" target="_blank"><i class="fa fa-fw fa-youtube-play"></i></a>
					<a href="<?=$textos['linkedin']?>" target="_blank"><i class="fa fa-fw fa-linkedin"></i></a>
				</div>
			</nav>
			<nav class="menu-side">
				<a href="#contexto" class="close"><?=$textos['contexto']?></a>
				<a href="#iniciativa" class="close"><?=$textos['iniciativa']?></a>
				<a href="#solucion" class="close"><?=$textos['solucion']?></a>
				<a href="#mapa" class="close"><?=$textos['mapa']?></a>
				<a href="#impactos_resultados" class="close"><?=$textos['impactos_resultados']?></a>
				<a href="#estadisticas" class="close"><?=$textos['estadisticas']?></a>
				<a href="#video" class="close"><?=$textos['video']?></a>
				<a href="#infografia" class="close"><?=$textos['infografia']?></a>
				<a href="#donantes" class="close"><?=$textos['donantes']?></a>
				<a href="#informacion" class="close"><?=$textos['informacion']?></a>
				<a href="#logos" class="close"><?=$textos['logos']?></a>
				<a href="#prefooter" class="close last"><?=$textos['prefooter']?></a>
				<div class="about">
					<h3><?=$textos['sobre_fontagro']?></h3>
					<p>
					<?=$textos['descripcion']?>
						<a href="#" class="more"><?=$textos['conocer_mas']?></a>
					</p>
				</div>
			</nav>
		</div>
		<div class="content-wrap" id="container">
			<div class="content">
				<!-- HEADER -->
				<header id="header" class="header">
					<div class="box">
						<div class="topBox animated fadeIn">
							<a href="#" class="logo">
								<img src="<?=base_url()?>img/webstory/fontagro-logo.svg" alt="FONTAGRO">
							</a>
							<div class="menuBox">
								<div class="lang">
									<a href="<?=LINK_WEBSTORIES?><?=$webstory['url']?>/es" class="<?=($lang=='es')? 'active' : '' ?>">Es</a>
									<a href="<?=LINK_WEBSTORIES?><?=$webstory['url']?>/en" class="<?=($lang=='en')? 'active' : '' ?>">En</a>
								</div>
								<div class="menuNav">
									<a href="#navigation" class="menu-button" id="open-button">
									<?=$textos['menu']?> <span></span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</header>

				<!-- CTA Box -->
				<div id="ctaBox" class="ctaBox">
					<div class="parallaxParent">
						<div id="ctaParallax" class="ctaParallax" style="background-image: url(<?=base_url()?>uploads/webstories/<?=$webstory['foto_principal']?>);"></div>
					</div>
					<div class="box">
						<div id="cta" class="cta">
							<div class="breadcrumb">
								<a href="<?=$link_propuesta?>" class="btn small back"><img src="<?=base_url()?>img/webstory/left-white.svg" alt=""> <?=$textos['volver']?></a>
								<a href="#" class="btn small white"><?=$textos['historias']?></a>
								<?if(!empty($webstory['link_publicacion']) && !empty($webstory['link_publicacion_titulo'])) :?>
									<a href="<?=$webstory['link_publicacion']?>" target="_blank" class="btn small back"><?=$webstory['link_publicacion_titulo']?></a>
								<?endif?>
							</div>
							<h1 class="animated fadeIn"><?=$webstory['titulo']?></h1>
							<h4 class="animated fadeIn"><?=$webstory['bajada']?></h4>
						</div>
						<div id="share" class="share">
							<span class="shareTitle vertical-text"><?=$textos['compartir']?></span>
							<a href="https://twitter.com/intent/tweet?text=<?=$webstory['titulo']?>%20<?=LINK_WEBSTORIES?><?=$webstory['url']?>/<?=$lang?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?=LINK_WEBSTORIES?><?=$webstory['url']?>/<?=$lang?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
							<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?=LINK_WEBSTORIES?><?=$webstory['url']?>/<?=$lang?>&title=<?=$webstory['titulo']?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>

				<!-- Contexto -->
				<div id="contexto" class="contexto">
					<div class="box">
						<div class="grid contextoTxt animated">
							<div class="col-4_sm-12">
								<h2 class="titleCol"><?=$textos['contexto']?></h2>
							</div>
							<div class="col-8_sm-12">
								<div class="twoCols">
									<p><?=nl2br($webstory['contexto'])?></p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Iniciativa -->
				<div id="iniciativa" class="iniciativa">
					<div class="grid-middle-noBottom">
						<div class="col-6_md-12_sm-12 alignRight">
							<div class="box-2">
								<div class="titleBox">
									<h3 id="subtitle01">
										<?=$webstory['iniciativa_titulo']?>
									</h3>
									<h2 id="title01">
										<?=$textos['iniciativa']?>
									</h2>
								</div>
								<p>
									<?=nl2br($webstory['iniciativa_descripcion'])?>
								</p>
							</div>
						</div>
						<div class="col-6_md-12_sm-12">
							<!-- Swiper -->
							<div class="swiper-container photoslider">
								<div class="swiper-wrapper">
								<?foreach($fotosIniciativa as $foto):?>
									<div class="swiper-slide" style="background-image: url(<?=base_url()?>uploads/adjuntos/<?=$foto['archivo']?>);"></div>
								<?endforeach?>
								</div>
								<!-- Add Pagination -->
								<div class="swiper-pagination"></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Solución -->
				<div id="solucion" class="solucion">
					<div class="box">
						<div class="titleBox alignCenter">
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

				<!-- Frase -->
				<div id="frase" class="frase">
					<div class="parallaxParent">
						<div id="fraseParallax" class="fraseParallax" style="background-image: url(<?=base_url()?>uploads/webstories/<?=$webstory['foto_cita']?>);"></div>
					</div>
					<div class="box alignCenter">
						<h5 id="fraseTxt"><?=$webstory['cita_texto']?></h5>
						<div id="author" class="author">
							<?=$webstory['cita_fuente']?>
						</div>
					</div>
				</div>

				<!-- map -->
				<div id="mapa" class="mapa">
					<div class="grid-noGutter">
						<div class="col-6_sm-12">
							<div id="worldMap" style="height: 414px;"></div>
						</div>
						<div class="col-6_sm-12">
							<div class="box-2 mapInfo">
								<div class="grid">
									<div class="col-6_sm-6_xs-12">
										<h3><?=$textos['mapa']?></h3>
										<ul>
											<?foreach($paises as $pais):?>
											<li><a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?pais=<?=$pais['id']?>" class="country"><img src="<?=base_url()?>img/webstory/flags_by_code/<?=$pais['code']?>.svg" alt="<?=$pais['nombre']?>"> <?=$pais['nombre']?></a></li>
											<?endforeach?>
										</ul>
									</div>
									<div class="col-6_sm-6_xs-12">
										<h3><?=$textos['tipo_proyecto']?></h3>
										<ul>
											<?if(!empty($propuesta['estrategica'])):?><li><a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?estrategica=<?=$propuesta['linea_estrategica']?>" class="tag"><?=$propuesta['estrategica']?></a></li><?endif?>
											<?if(!empty($propuesta['solucion'])):?><li><a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?solucion=<?=$propuesta['solucion_tecnologica']?>" class="tag"><?=$propuesta['solucion']?></a></li><?endif?>
											<?if(!empty($propuesta['sector_productivo'])):?><li><a href="#" class="tag"><?=$propuesta['sector_productivo']?></a></li><?endif?>
											<?foreach($temas as $tema):?>
												<li><a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?tema[<?=$tema['id']?>]=<?=$tema['id']?>" class="tag"><?=$tema['nombre']?></a></li>
											<?endforeach?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Impactos y resultados -->
				<div id="impactos_resultados" class="impactos_resultados">
					<div class="box">
						
						<div class="titleBox alignCenter">
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

				<?if(!empty($webstory['codigo_estadisticas']) || !empty($fotosEstadisticas)):?>
				<!-- estadísiticas -->
				<div id="estadisticas" class="estadisticas">
					<div class="box alignCenter">
						<div class="titleBox alignCenter">
							<h3 id="subtitle04">
								<?=$textos['estadisticas']?>
							</h3>
							<h2 id="title04">
								<?=$webstory['estadisticas_titulo']/*$textos['estadisticas']*/?>
							</h2>
						</div>
						
						<div class="graphicBox">
							<?if(!empty($webstory['codigo_estadisticas'])):?>
								<?=$webstory['codigo_estadisticas']?>
							<?else:?>
								<img src="<?=base_url()?>uploads/adjuntos/<?=$fotosEstadisticas[0]['archivo']?>" alt="<?=$fotosEstadisticas[0]['nombre']?>">
							<?endif?>
						</div>
					</div>
				</div>
				<?endif?>

				<!-- Counters -->
				<div id="contadores" class="contadores">
					<div class="box">
						<div class="grid">
							<?
							$col = 4;
							if(sizeof($indicadores)==1){
								$col = 12;
							}else if(sizeof($indicadores)==2){
								$col = 6;
							}else if(sizeof($indicadores)==3){
								$col = 4;
							}else if(sizeof($indicadores)==4){
								$col = 3;
							}else if(sizeof($indicadores)==5){
								$col = 4;
							}else if(sizeof($indicadores)==6){
								$col = 4;
							}else if(sizeof($indicadores)==7){
								$col = 3;
							}else if(sizeof($indicadores)==8){
								$col = 3;
							}
							foreach($indicadores as $ind):
							?>
							<div class="col-<?=$col?>_sm-12">
								<div class="grid-noBottom">
									<div class="col-4 alignCenter icon">
										<img src="<?=base_url()?>img/iconos/<?=$ind['icono']?>.svg" alt="<?=$ind['nombre']?>" class="icon">							
									</div>
									<div class="col-8">
										<div class="number"><?=$ind['prefijo']?><span class="counter-value" data-count="<?=$ind['valor']?>">-</span><?=$ind['unidad']?></div>
										<div class="numTxt"><?=$ind['nombre']?></div>
									</div>
								</div>
							</div>
							<?endforeach?>							
						</div>
					</div>
				</div>

				<!-- video -->
				<div id="video" class="video">
					<div class="parallaxParent">
						<div id="videoParallax" class="videoParallax" style="background-image: url(<?=base_url()?>uploads/webstories/<?=$webstory['foto_cita']?>);"></div>
					</div>
					<?if(!empty($webstory['video'])):?>				
						<div class="box alignCenter" id="video-gallery">
							<a href="<?=$webstory['video']?>" id="play" class="popVideo video-play-button"><span></span></a>
						</div>
					<?endif?>
				</div>

				<!-- Fotos -->
				<div id="fotos" class="fotos">
					<div class="box" id="fotosBox">
						 <!-- Swiper -->
						<div class="swiper-container carroucel">
							<div class="swiper-wrapper" id="lightgallery">
								<?foreach($fotosGaleria as $fotoG):?>
									<div class="swiper-slide" style="background-image: url(<?=base_url()?>uploads/adjuntos/<?=$fotoG['archivo']?>);">
										<a href="<?=base_url()?>uploads/adjuntos/<?=$fotoG['archivo']?>" data-src="<?=base_url()?>uploads/adjuntos/<?=$fotoG['archivo']?>" class="imgGal" alt="<?=$fotoG['nombre']?>"></a>
									</div>
								<?endforeach?>
							</div>
						</div>
						<!-- Add Arrows -->
						<div class="swiper-button-next fotosNext"></div>
						<div class="swiper-button-prev fotosPrev"></div>
					</div>
				</div>

				<?if(!empty($webstory['infografia']) || !empty($webstory['codigo_infografia'])):?>
				<!-- Infografía -->
				<div id="infografia" class="infografia">
					<div class="box alignCenter">
						<div class="titleBox alignCenter">
							<h3 id="subtitle05"><?=$webstory['infografia_volanta']?></h3>
							<h2 id="title05"><?=$webstory['infografia_titulo']?></h2>
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
				
				<!-- logos -->
				<div id="logos" class="logos">
					<div class="box alignCenter">
						<h3><?=$textos['logos']?></h3>
					</div>
					<div class="box alignCenter">
						<!-- Swiper -->
						<div class="swiper-container logos">
							<div class="swiper-wrapper">
								<?foreach($organismos as $org):
									$nombre = empty($org['nombre_largo'])? $org['nombre'] : $org['nombre_largo'].' ('.$org['nombre'].')';
									if(!empty($org['pais'])) $nombre .= ' - '.$org['pais'];
									?>
									<div class="swiper-slide"><img class="grayscale" src="<?=base_url()?>uploads/organismos/<?=$org['logo']?>" alt="<?=$nombre?>"  title="<?=$nombre?>"></div>
								<?endforeach?>	
							</div>
						</div>
						<!-- Add Arrows -->
						<div class="swiper-button-next logosNext"></div>
						<div class="swiper-button-prev logosPrev" ></div>
					</div>
				</div>

				<!-- Donantes -->
				<div id="donantes" class="donantes">
					<div class="box">
						<div class="grid-noBottom-middle">
							<div class="col-4_sm-12">
								<h2 class="titleCol"><?=$textos['donantes']?></h2>
							</div>
							<div class="col-8_sm-12">
								<div class="grid-center-noBottom">
									<?foreach($donantes as $dona):
										$nombre = empty($dona['nombre_largo'])? $dona['nombre'] : $dona['nombre_largo'].' ('.$dona['nombre'].')';
										if(!empty($dona['pais'])) $nombre .= ' - '.$dona['pais'];
										?>
										<div class="col-3 alignCenter">
											<a href="<?=$dona['link']?>" target="_blank"><img class="grayscale" src="<?=base_url()?>uploads/organismos/<?=$dona['logo']?>" alt="<?=$nombre?>"  title="<?=$nombre?>"></a>
										</div>
									<?endforeach?>	
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Información -->
				<div id="informacion" class="informacion">
					<div class="box">
						<div class="grid">
							<div class="col-4_sm-12">
								<h2 class="titleCol"><?=$textos['informacion']?></h2>
							</div>
							<div class="col-3_sm-12">
								<ul>
									<li><a href="<?=$link_propuesta?>"><?=$textos['conocer_mas']?></a></li>
									<li><a href="<?=$link_propuesta?>#ctaTxt"><?=$textos['ficha']?></a></li>
									<li><a href="<?=$link_propuesta?>#news"><?=$textos['novedades']?></a></li>
								</ul>
							</div>
							<div class="col-5_sm-12">
								<div class="grid-noGutter">
									<?foreach($badges as $badge):?>
									<div class="col-3">
										<img src="<?=base_url()?>uploads/badges/<?=$badge['foto']?>" alt="<?=$badge['nombre']?>" title="<?=$badge['descripcion']?>">
									</div>
									<?endforeach?>
								</div>
							</div>
						</div>
					</div>
				</div>

				
				<!-- historias -->
				<div id="prefooter" class="prefooter">
					<div id="historias" class="historias">
						<div class="titleBox alignCenter">
							<h3>
								<?=$textos['conoce']?>
							</h3>
							<h2>
								<?=$textos['historias']?>
							</h2>
						</div>
						<!-- Swiper -->
						<div class="swiper-container related">
							<div class="swiper-wrapper">
								<?foreach($otrasStories as $otras):?>
								<div class="swiper-slide">
									<a href="<?=LINK_WEBSTORIES?><?=$otras['url']?>" class="historia" style="background-image: url(<?=base_url()?>uploads/webstories/<?=empty($otras['foto_link'])? $otras['foto'] : $otras['foto_link']; ?>);">
										<h4>
											<?=$otras['titulo']?>
										</h4>
									</a>
								</div>
								<?endforeach?>								
							</div>
						</div>
						
					</div>
				</div>
			<!-- footer -->
			<footer id="footer">
				<div class="box">
					<div class="grid-middle-noBottom">
						<div class="col-1_sm-12">
							<a href="#"><img src="<?=base_url()?>img/webstory/fontagro-logo-color.svg" alt="FONTAGRO"/></a>
						</div>
						<div class="col-7_sm-12">
							© FONTAGRO | 1300 New York Avenue NW, Stop W0502 Washington, DC 20577<br />
							E-mail: fontagro@iadb.org
						</div>
						<div class="col-4_sm-12 alignRight">
							<div class="socialIcons">
								<a href="<?=$textos['twitter']?>" target="_blank" class="social twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
								<a href="<?=$textos['linkedin']?>" target="_blank" class="social linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
								<a href="<?=$textos['vimeo']?>" target="_blank" class="social vimeo"><i class="fa fa-vimeo" aria-hidden="true"></i></a>
								<a href="<?=$textos['youtube']?>" target="_blank" class="social Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
					
						
					
				</div>
			</footer>
		</div>
	</div><!-- /content-wrap -->
</div><!-- /container -->

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script src="<?=base_url()?>js/webstory/classie.js"></script>
<script src="<?=base_url()?>js/webstory/swiper.min.js"></script>
<script src="<?=base_url()?>js/webstory/main.js"></script>

<script src="<?=base_url()?>js/webstory/lightgallery.min.js"></script>
<script src="<?=base_url()?>js/webstory/lg-video.min.js"></script>
<script src="<?=base_url()?>js/webstory/lg-autoplay.min.js"></script>


<script src="<?=base_url()?>js/numscroller-1.0.js"></script>

<script>
$(document).ready(function() {
    $("#lightgallery").lightGallery({
        selector: '.imgGal'
    });
    $('#video-gallery').lightGallery(); 
})
</script>

<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?=base_url()?>material/assets/js/plugins/jquery-jvectormap.js"></script>
<script>
	$(document).ready(function() {
		$("#worldMap").vectorMap({
			map:"world_mill_en",
			backgroundColor:"transparent",
			zoomOnScroll:!1,
			regionStyle:{
				initial: {
					fill:"#e2ffff",
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
						scale:["#16c0e1","#1fb4d1"],
						normalizeFunction:"polynomial"
					}
				]
			}
		});
	});
</script>
</body>
</html>