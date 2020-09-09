<!DOCTYPE html>
<html lang="<?=$lang?>">
<head>
<?
$descripcion = strip_tags($propuesta['web_impacto']);
?>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
	<title><?=$propuesta['titulo_simple']?></title>
	<meta name="description" content="<?=$descripcion?>">
	<link rel="shortcut icon" href="<?=base_url()?>favicon.ico">
    <meta name="author" content="ANIMUS">

	<link href="<?=base_url()?>css/proyecto/style.css" rel="stylesheet">
	<link href="<?=base_url()?>css/webstory/swiper.min.css" rel="stylesheet">
	<script src="<?=base_url()?>js/webstory/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<link href="<?=base_url()?>css/webstory/jvectormap.css" rel="stylesheet">

	<!-- CHARTS https://gionkunz.github.io/chartist-js/index.html -->
	<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

	<!-- Parallax -->
	<script type="text/javascript" src="<?=base_url()?>js/webstory/ScrollMagic.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/TweenMax.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/animation.gsap.js"></script>

	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@FONTAGROdigital">
	<meta name="twitter:title" content="<?=$propuesta['titulo_simple']?>">
	<meta name="twitter:description" content="<?=$descripcion?>">
	<meta name="twitter:creator" content="@FONTAGROdigital">
	<meta name="twitter:image" content="<?=base_url()?>uploads/propuestas/<?=$propuesta['web_foto']?>">

	<!-- Open Graph data -->
	<meta property="og:title" content="<?=$propuesta['titulo_simple']?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?=LINK_PROYECTOS?><?=$propuesta['web_url']?>/<?=$lang?>" />
	<meta property="og:image" content="<?=base_url()?>uploads/propuestas/<?=$propuesta['web_foto']?>" />
	<meta property="og:description" content="<?=$descripcion?>" />

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
	
	<style>
	.ct-series-a .ct-area, .ct-series-a .ct-slice-donut-solid, .ct-series-a .ct-slice-pie {
		fill: #34cc99;
	}
	.ct-series-a .ct-bar, .ct-series-a .ct-line, .ct-series-a .ct-point, .ct-series-a .ct-slice-donut {
		stroke: #34cc99;
	}
	.ct-series-b .ct-area, .ct-series-b .ct-slice-donut-solid, .ct-series-b .ct-slice-pie {
		fill: #83c559;
	}
	.ct-series-b .ct-bar, .ct-series-b .ct-line, .ct-series-b .ct-point, .ct-series-b .ct-slice-donut {
		stroke: #83c559;
	}
	.ct-series-c .ct-area, .ct-series-c .ct-slice-donut-solid, .ct-series-c .ct-slice-pie {
		fill: #72d0cf;
	}
	.ct-series-c .ct-bar, .ct-series-c .ct-line, .ct-series-c .ct-point, .ct-series-c .ct-slice-donut {
		stroke: #72d0cf;
	}
	.ct-label{
		font-size:15px;
	}

	.projectContent .chartValues{
		padding:3.2rem 50px;
		text-align:center
	}
	@media (max-width: 1480px){
		.projectContent .chartValues{
			padding:3.2rem
		}
	}
	.projectContent .chartValues .valueLabel{
		display:inline-block;
		padding:0 3.2rem 2px 0;
		font-size:1.4rem;
	}
	.projectContent .chartValues .valueLabel .color{
		width:25px;
		height:25px;
		display:inline-block;
		margin-right:5px;
		vertical-align:middle;
		background-color:#83c559;
		-webkit-border-radius:3px;
		-moz-border-radius:3px;
		border-radius:3px
	}
	.projectContent .chartValues .valueLabel strong{
		display:inline-block;
		margin-left:10px;
		font-family:'gotham-Bold'
	}
	</style>
	
	<?php $this->load->view('googletag'); ?>
</head>
<body>
	<div class="container">
		<div class="menu-wrap">
			<nav class="menu-top">
				<div class="profile"><img src="<?=base_url()?>img/webstory/fontagro-logo-color.svg" alt="FONTAGRO"/><span> <?=$textos['iniciativas_y_proyectos']?></span></div>
				<div class="icon-list">
					<a href="<?=$textos['twitter']?>" target="_blank"><i class="fa fa-fw fa-twitter"></i></a>
					<a href="<?=$textos['vimeo']?>"><i class="fa fa-fw fa-vimeo" target="_blank"></i></a>
					<a href="<?=$textos['youtube']?>"><i class="fa fa-fw fa-youtube-play" target="_blank"></i></a>
					<a href="<?=$textos['linkedin']?>" target="_blank"><i class="fa fa-fw fa-linkedin"></i></a>
				</div>
			</nav>
			<nav class="menu-side">
				<a href="<?=LINK_PROYECTOS?>"><?=$textos['iniciativas_y_proyectos']?></a>
				<a href="<?=LINK_PROYECTOS?>#encurso"><?=$textos['iniciativas_en_curso']?></a>
				<a href="https://www.fontagro.org/es/quienes-somos/"><?=$textos['sobre_fontagro']?></a>
				<!--<a href="#" class="login"><i class="fa fa-sign-in" aria-hidden="true"></i> Ingresar</a>-->
				<div class="about">
					<h3><?=$textos['sobre_fontagro']?></h3>
					<p>
						<?=$textos['descripcion']?>
						<a href="https://www.fontagro.org/es/quienes-somos/" class="more"><?=$textos['conocer_mas']?></a>
					</p>
				</div>
			</nav>
		</div>
		<div class="content-wrap" id="container">
			<div class="content">
				<header class="header">
					<div class="box">
						<div class="grid-middle-noBottom">
							<div class="col-2_sm-4">
								<a href="<?=LINK_PROYECTOS?>" class="logo animated fadeIn">
									<img src="<?=base_url()?>img/webstory/fontagro-logo-color.svg" alt="Fontagro - Iniciativas y proyectos">
								</a>
							</div>
							<div class="col-10_sm-8 alignRight">
								<div class="headerTools animated fadeIn">
									<div class="socialBox">
										<a href="<?=$textos['twitter']?>" target="_blank"><i class="fa fa-fw fa-twitter"></i></a>
										<a href="<?=$textos['vimeo']?>"><i class="fa fa-fw fa-vimeo" target="_blank"></i></a>
										<a href="<?=$textos['youtube']?>"><i class="fa fa-fw fa-youtube-play" target="_blank"></i></a>
										<a href="<?=$textos['linkedin']?>" target="_blank"><i class="fa fa-fw fa-linkedin"></i></a>
									</div>
									<div class="langBox">
										<a href="<?=LINK_PROYECTOS?><?=$propuesta['web_url']?>/es" class="<?=($lang=='es')? 'active' : '' ?>">Es</a>
										<a href="<?=LINK_PROYECTOS?><?=$propuesta['web_url']?>/en" class="<?=($lang=='en')? 'active' : '' ?>">En</a>
									</div>
									<div class="menuNav">
										<a href="#navigation" class="menu-button" id="open-button">
										<?=$textos['menu']?> <span></span>
										</a>
									</div>
								</div>
								<nav class="animated fadeIn">
									<ul>
										<li><a href="<?=LINK_PROYECTOS?>"><?=$textos['iniciativas_y_proyectos']?></a></li>
										<li><a href="<?=LINK_PROYECTOS?>#encurso"><?=$textos['iniciativas_en_curso']?></a></li>
										<li><a href="https://www.fontagro.org/es/quienes-somos/"><?=$textos['sobre_fontagro']?></a></li>
										<!--<li><a href="#" class="login">Ingresar</a></li>-->
									</ul>
								</nav>
								
							</div>
						</div>

					</div>
                </header>
                <div class="hero" id="cta">
                    <div class="parallaxParent">
						<?php if($propuesta['web_foto']){ ?>
							<div id="ctaParallax" class="ctaParallax bgCover" style="background-image: url('<?=base_url()?>uploads/propuestas/<?=$propuesta['web_foto']?>');"></div>
						<?php } else { ?>
							<div id="ctaParallax" class="ctaParallax bgCover" style="background-image: url('<?=base_url()?>img/proyecto/bgPerfil.jpg');"></div>
						<?php } ?>
					</div>
                    <div class="box">
                        <div class="txt" id="ctaTxt">
                            <div class="titleBox">
                                <h1><?=$propuesta['titulo_simple']?></h1>
                            </div>
                            <div class="tags">
								<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?estrategica=<?=$propuesta['linea_estrategica']?>" class="tag"><i class="fa fa-tag" aria-hidden="true"></i> <?=$propuesta['estrategica']?></a> 
								<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?innovacion=<?=$propuesta['tipo_innovacion']?>" class="tag"><i class="fa fa-tag" aria-hidden="true"></i> <?=$propuesta['innovacion']?></a> 
								<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?investigacion=<?=$propuesta['tipo_investigacion']?>" class="tag"><i class="fa fa-tag" aria-hidden="true"></i> <?=$propuesta['investigacion']?></a> 
								<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?solucion=<?=$propuesta['solucion_tecnologica']?>" class="tag"><i class="fa fa-tag" aria-hidden="true"></i> <?=$propuesta['solucion']?></a> 
								<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?anio=<?=$propuesta['anio']?>" class="tag main"><i class="fa fa-calendar" aria-hidden="true"></i> <?=$propuesta['anio']?></a>
								<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?estado=<?=$propuesta['estado']?>" class="tag main"><i class="fa <?=$propuesta['estado']==1?'fa-calendar-check-o':'fa-calendar-times-o'?>" aria-hidden="true"></i> <?=$propuesta['nombreestado']?></a>
								<?/*foreach($temas as $tema):?> 
                                	<a href="#" class="tag"><i class="fa fa-tag" aria-hidden="true"></i> <?=$tema['nombre']?></a> 
								<?endforeach?>
								<?foreach($sectores as $sector):?>
									<br><a href="#" class="tag main"><i class="fa fa-folder" aria-hidden="true"></i> <?=$sector['nombre']?></a>
									<?foreach($sector['subsectores'] as $subsector):?>
										<a href="#" class="tag"><i class="fa fa-tag" aria-hidden="true"></i> <?=$subsector['nombre']?></a> 
									<?endforeach?>
								<?endforeach*/?>                             
                            </div>
                        </div>
                        
                    </div>
                </div>

				<div class="dataSheet" id="data">
					<div class="box big">
                        <div class="dataBox">
                            <div class="topData">
                                <div class="grid-equalHeight-noBottom">
                                    <div class="col-4_sm-12">
                                        <div class="infoBox">
                                            <div class="grid-noBottom">
                                                <div class="col-3_lg-12_sm-6">
													<?=$textos['proyectos_dato_1']?>:
                                                </div>
                                                <div class="col-9_lg-12_sm-6">
                                                    <strong><?=$propuesta['identificador']?></strong> 
                                                </div>
                                            </div>
                                            <div class="grid-noBottom">
                                                <div class="col-3_lg-12_sm-6">
												<?=$textos['proyectos_dato_2']?>: 
                                                </div>
                                                <div class="col-9_lg-12_sm-6">
                                                    <strong><?=$propuesta['iniciativa']?></strong> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<?if(!empty(round($propuesta['total']))):?>
                                    <div class="col-4_sm-12">
                                        <div class="infoBox">
                                            <div class="grid-noBottom">
												<?if(empty(round($propuesta['aporte_fontagro']))):?>
                                                <div class="col-6_lg-12_sm-6">
													<?=$textos['proyectos_dato_5']?>:
                                                </div>
                                                <div class="col-6_lg-12_sm-6">
                                                    <strong>USD <?=number_format($propuesta['aporte_bid']+$propuesta['movilizacion_agencias']+$propuesta['aporte_agencias'],0,',','.')?></strong> 
                                                </div>
												<?else:?>
												<div class="col-6_lg-12_sm-6">
													<?=$textos['proyectos_dato_3']?>:
                                                </div>
                                                <div class="col-6_lg-12_sm-6">
                                                    <strong>USD <?=number_format($propuesta['aporte_fontagro'],0,',','.')?></strong> 
                                                </div>
												<?endif?>
                                            </div>
                                            <div class="grid-noBottom">
                                                <div class="col-6_lg-12_sm-6">
													<?=$textos['proyectos_dato_4']?>:
                                                </div>
                                                <div class="col-6_lg-12_sm-6">
                                                    <strong>USD <?=number_format($propuesta['aporte_contrapartida'],0,',','.')?></strong> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4_sm-12">
                                        <div class="infoBox">
                                            <div class="grid-noBottom">
												<?if(empty($propuesta['plazo'])):?>
                                                <div class="col-5_lg-12_sm-6">
													<?=$textos['proyectos_dato_5']?>
                                                </div>
                                                <div class="col-7_lg-12_sm-6">
                                                    <strong class="main">USD <?=number_format($propuesta['aporte_bid']+$propuesta['movilizacion_agencias']+$propuesta['aporte_agencias'],0,',','.')?></strong> 
                                                </div>
												<?else:?>
												<div class="col-5_lg-12_sm-6">
													<?=$textos['plazo_ejecucion_proyecto']?>
                                                </div>
                                                <div class="col-7_lg-12_sm-6">
                                                    <strong class="main"><?=$propuesta['plazo']?> <?=$textos['plazo_ejecucion_meses']?></strong> 
                                                </div>
												<?endif;?>
                                            </div>
                                            <div class="grid-noBottom">
                                                <div class="col-5_lg-12_sm-6">
													<?=$textos['proyectos_dato_6']?>:
                                                </div>
                                                <div class="col-7_lg-12_sm-6">
													<strong class="main">USD <?=number_format($propuesta['total'],0,',','.')?></strong> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<?endif?>
                                </div>
                            </div>
                            <div class="moreData">
                                <div class="grid-equalHeight-noGutter">
									<?if(!empty($paises)):?>
                                    <div class="col-6_sm-12">
                                        <div class="mapBox">
                                            <div class="mapCountries">
                                                <div id="worldMap" style="height: 414px;"></div>
                                                <div class="label"><?=$textos['mapa']?>:</div>
                                            </div>
                                            <div class="countries">
												<?foreach($paises as $pais):?>
													<span class="country"><img src="<?=base_url()?>img/webstory/flags_by_code/<?=$pais['code']?>.svg" alt="<?=$pais['nombre']?>"> <?=$pais['nombre']?> </span>
												<?endforeach?>
                                            </div>  
                                        </div>
                                    </div>
									<?endif?>
									<?if(!empty(round($propuesta['total']))):?>
                                    <div class="col-6_sm-12">
                                        <div class="chartBox">
                                            <div class="chartContent" style="height: 414px; overflow: hidden;">
                                                <div class="label"><?=$textos['fuente_de_financiamiento']?>:</div>
                                                <div class="chart">
													<div style="height: 357px;" class="pie-chart ct-perfect-fourth"></div>
                                                </div>
                                            </div>
                                            <div class="chartValues">
												<?if(!empty(round($propuesta['aporte_fontagro']))):?>
                                                <span class="valueLabel">
                                                    <span class="color" style="background-color:#34cc99"></span>
                                                    <?=$textos['proyectos_dato_3']?> <strong><?=round(100*$propuesta['aporte_fontagro']/$propuesta['total'])?>%</strong> 
                                                </span>
												<?endif?>
                                                <span class="valueLabel">
                                                    <span class="color" style="background-color:#83c559"></span>
                                                    <?=$textos['proyectos_dato_5']?> <strong> <?=round(100*($propuesta['aporte_bid']+$propuesta['movilizacion_agencias']+$propuesta['aporte_agencias'])/$propuesta['total'])?>%</strong> 
                                                </span>
                                                <span class="valueLabel">
                                                    <span class="color" style="background-color:#72d0cf"></span>
                                                    <?=$textos['proyectos_dato_4']?> <strong><?=round(100*$propuesta['aporte_contrapartida']/$propuesta['total'])?>%</strong> 
                                                </span>
                                            </div>
                                        </div>
                                    </div>
									<?endif?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <div class="box">
                            <div class="grid-middle">
                                <div class="col-6_sm-12">
                                    <div class="share">
                                        <strong><?=$textos['compartir']?></strong>
                                        <a href="https://twitter.com/intent/tweet?text=<?=$propuesta['titulo_simple']?>%20<?=LINK_PROYECTOS?><?=$propuesta['web_url']?>/<?=$lang?>" target="_blank" class="btn icon"><i class="fa fa-fw fa-twitter"></i></a>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?=LINK_PROYECTOS?><?=$propuesta['web_url']?>/<?=$lang?>" target="_blank" class="btn icon"><i class="fa fa-fw fa-facebook"></i></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?=LINK_PROYECTOS?><?=$propuesta['web_url']?>/<?=$lang?>&title=<?=$propuesta['titulo_simple']?>" target="_blank" class="btn icon"><i class="fa fa-fw fa-linkedin"></i></a>
                                    </div>
                                </div>
                                <!--<div class="col-6_sm-12">
                                    <div class="alignRight">
                                        <a href="#" class="btn secondary">
                                            <i class="fa fa-hand-paper-o" aria-hidden="true"></i> Apoyar iniciativa
                                        </a>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="projectContent">
                    <div class="box">
						<?if(!empty($propuesta['web_resumen']) && strlen($propuesta['web_resumen'])>10):?>
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
                                    <h3 class="underline">
										<?=$textos['resumen_ejecutivo']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12">
									<p><?=$propuesta['web_resumen']?></p>                          
                                </div>
                            </div>
						</div>
						<?endif?>

						<?if(!empty($propuesta['web_solucion']) && strlen($propuesta['web_solucion'])>10):?>
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
                                    <h3 class="underline">
										<?=$textos['solucion']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12">
									<p><?=$propuesta['web_solucion']?></p>                                
                                </div>
                            </div>
                        </div>
						<?endif?>

						<?if(!empty($propuesta['web_impacto']) && strlen($propuesta['web_impacto'])>10):?>
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
                                    <h3 class="underline">
										<?=$textos['impactos_resultados']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12 resultados">
									<p><?=$propuesta['web_impacto']?></p>  
                                </div>
                            </div>
						</div>
						<?endif?>

						<?if(!empty($propuesta['web_beneficiarios'] && strlen($propuesta['web_beneficiarios'])>10)):?>
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
                                    <h3 class="underline">
										<?=$textos['beneficiarios_proyectos']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12">
									<p><?=$propuesta['web_beneficiarios']?></p>                              
                                </div>
                            </div>
                        </div>
						<?endif?>

						<?if(!empty($badges)):?>
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
                                    <h3 class="underline">
										<?=$textos['objetivos_sostenibles']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12">
                                    <div class="objectivosImg">
										<?foreach($badges as $badge):?>
											<img src="<?=base_url()?>uploads/badges/<?=$badge['foto']?>" alt="<?=$badge['nombre']?>" title="<?=$badge['descripcion']?>">										
										<?endforeach?>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?endif?>


						
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
                                    <h3 class="underline">
										<?=$textos['donantes']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12">
                                    <div class="objectivosImg">
										<a href="<?=$donantesObligados[0]['link']?>" target="_blank">
											<img class="grayscale" src="<?=base_url()?>uploads/organismos/<?=$donantesObligados[0]['logo']?>" alt="<?=$donantesObligados[0]['nombre']?>" title="<?=$donantesObligados[0]['nombre']?>" />
										</a>
										<?foreach($donantes as $dona):
											if($dona['idorganismo']==256 || $dona['idorganismo']==257) continue;?>
											<a href="<?=$dona['link']?>" target="_blank">
												<img class="grayscale" src="<?=base_url()?>uploads/organismos/<?=$dona['logo']?>" alt="<?=$dona['nombre']?>" title="<?=$dona['nombre']?>" />
											</a>										
										<?endforeach?>
										<!--<a href="<?=$donantesObligados[1]['link']?>" target="_blank">
											<img class="grayscale" src="<?=base_url()?>uploads/organismos/<?=$donantesObligados[1]['logo']?>" alt="<?=$donantesObligados[1]['nombre']?>" title="<?=$donantesObligados[1]['nombre']?>" />
										</a>-->
                                    </div>
                                </div>
                            </div>
                        </div>			
						
                    </div>
                </div>

				<?if(!empty($noticias)):?>
                <div class="novedadesBox novedadesProject" id="news">
					<div class="box">
                        <h3 class="linetop"><?=$textos['novedades_proyecto']?></h3>
                        <!-- Swiper -->
						<div class="swiper-container news <?=sizeof($noticias)<6? 'oneCol':''?>">
							<div class="swiper-wrapper">
								<?foreach($noticias as $noticia):?>
								<div class="swiper-slide">
									<div class="novedad">
                                        <div class="grid">
                                            <div class="col-3_md-12_sm-3">
                                                <a href="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/<?=$lang?>/<?=$noticia['url']?>" class="imgNews bgCover" style="background-image: url(<?=base_url()?>uploads/noticias/400_<?=$noticia['foto']?>);"></a>
                                            </div>
                                            <div class="col-9_md-12_sm-9">
                                                <h5>
													<?=($noticia['idtiponoticia']==2)? '<span class="blog">Blog</span>':''?><a href="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/<?=$lang?>/<?=$noticia['url']?>"><?=$noticia['titulo']?></a>
                                                </h5>
                                                <div class="date"><?=fromYYYYMMDDtoDDMMYYY($noticia['publicada'])?></div>
                                            </div>
                                        </div>
                                    </div>
								</div>
								<?endforeach?>			
							</div>
						</div>
						<?php if ((sizeof($noticias)>3)){ ?>
						<div class="buttons alignRight">
							 <!-- Add Arrows -->
							<a href="#" class="news-button-prev btn"><?=$textos['proyecto_anterior']?></a>
							<a href="#" class="news-button-next btn"><?=$textos['proyecto_siguiente']?></a>
							<!--<a href="#" class="btn secondary">Ver todos</a>-->
						</div>
						<?php } ?>
                    </div>
                </div>
				<?endif?>

				<?if(!empty($webstory)):?>
                <div class="webstoryBox alignCenter" id="webstory">
                    <div class="parallaxParent">
						<div id="webstoryParallax" class="webstoryParallax bgCover" style="background-image: url(<?=base_url()?>uploads/webstories/<?=$webstory['foto_principal']?>);"></div>
					</div>
                    <div class="box">
                        <a href="<?=LINK_WEBSTORIES?><?=$webstory['url']?>/<?=$lang?>" id="webstoryTxt">
                            <span><?=$textos['webstory_tagline']?></span>
                            <strong>
								<?=$textos['webstory_titulo']?>
                            </strong>
                            <i class="arrow">
                                <img src="<?=base_url()?>img/proyecto/right-blue.svg" alt="">
                            </i>
                        </a>
                    </div>
                </div>
				<?endif?>
				<div class="organizaciones">
					<div class="projectContent">
						<div class="box">
							<?if(!empty($participaciones)):?>
							<div class="contentBlock">
								<div class="grid">
									<div class="col-3_sm-12">
										<h3 class="underline">
											<?=$textos['logos']?>
										</h3>
									</div>
									<div class="col-9_sm-12">
									<?foreach($participaciones as $par):
										if(empty($par['organismos'])) continue;?>
										<h5><?=$par['nombre']?></h5>
										<ul>
											<?foreach($par['organismos'] as $org):
												$nombre = empty($org['nombre_largo'])? $org['nombre'] : $org['nombre_largo'].' ('.$org['nombre'].')';
												if(!empty($org['pais'])) $nombre .= ' - '.$org['pais'];
												?>
												<li><?=$nombre?></li>
											<?endforeach?>
										</ul>
									<?endforeach?>                                   
									</div>
								</div>
							</div>
							<?endif?>
							<?if(!empty($financiamiento)):?>
							<div class="contentBlock">
								<div class="grid">
									<div class="col-3_sm-12">
										<h3 class="underline">
										<?=$textos['graficos_y_datos']?>
										</h3>
									</div>
									<div class="col-9_sm-12">
										<div class="graphicBox" style="max-height: 600px;">
											<div class="grid">
												<div class="col-1">
													<div class="icon">
														<i class="fa fa-list-alt" aria-hidden="true"></i>
													</div>
												</div>
												<div class="col-11">
													<div class="graphicContent">
														<h5><?=$textos['financiamiento_pais']?></h5>
														<div style="height: 357px;" class="ct-chart ct-perfect-fourth"></div>
														<div class="chartValues">
															<span class="valueLabel">
																<span class="color" style="background-color:#34cc99"></span>
																<?=$textos['proyectos_dato_3']?>
															</span>
															<span class="valueLabel">
																<span class="color" style="background-color:#83c559"></span>
																<?=$textos['proyectos_dato_5']?> 
															</span>
															<span class="valueLabel">
																<span class="color" style="background-color:#72d0cf"></span>
																<?=$textos['proyectos_dato_4']?>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?endif?>
						</div>
					</div>
				</div>
				<?if(!empty($mapa)):?>
                <div class="mapGeo" id="mapGeo">
                    <div class="mapBox" id="mapa">

                    </div>
				</div>
				<div class="mapGeo" id="mapGeo" style="min-height: 0; height: 0; padding: 0;">
					<div class="box float" style="height: 0;">
                        <div class="titleBox">
                            <h3 class="underline">
								<?=$textos['mapa_geolocalizado']?>
                            </h3>
                        </div>
					</div>
				</div>
				<?endif?>

				<?if(!empty($documentos)):?>
                <div class="projectContent paddingtop lightgrey">
                    <div class="box">
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
                                    <h3 class="underline">
										<?=$textos['publicaciones_y_recursos']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12">
                                    <div class="docsBox">
										<!-- Swiper -->
                                        <div class="swiper-container docs">
                                            <div class="swiper-wrapper">
											
												<?php $idoc = 0; ?>
												<?php $idocAll = 0; ?>
												<?foreach($documentos as $doc):
													$docsTotal = count($documentos);
													$linkdoc = empty($doc['archivo'])? $doc['urlold'] : base_url().'uploads/'.$doc['carpeta'].'/'.$doc['archivo'] ;
													?>

													<?php
														$idoc ++;
														$idocAll ++;
														if($idoc == 1){?>
															<div class="swiper-slide">
															<div class="grid-equalHeight">
														<?php } ?>		

														
															<div class="col-6_md-12">
																<div class="document">
																	<a href="<?=$linkdoc?>" target="_blank">
																		<i class="fa fa-file-o" aria-hidden="true"></i>
																		<span>
																			<strong><?=$doc['nombre']?></strong>
																			<?=$doc['tipo']?>
																		</span>
																	</a>
																</div>
															</div>
															
														
													<?php if($idoc == 6 || ($docsTotal <= 6 && $idoc == $docsTotal) || ($docsTotal >= 6 && $idocAll == $docsTotal)){ ?>
													
													</div>
													</div>
													<?php $idoc = 0; ?>
													<?php } ?>
													
												<?endforeach?>    
											     
                                            </div>
                                        </div>
                                        <div class="buttons alignRight">
                                            <!-- Add Arrows -->
                                            <a href="#" class="docs-button-prev btn"><?=$textos['proyecto_anterior']?></a>
                                            <a href="#" class="docs-button-next btn"><?=$textos['proyecto_siguiente']?></a>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                 
                    </div>
				</div>
				<?endif?>

				<?if(!empty($techs) || !empty($posters)):?>
                <div class="projectContent <?=(empty($documentos))? 'lightgrey':''?>" id="resources">
                    <div class="box">
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
									<h3 class="underline">
										<?=$textos['productos_de_diseminacion']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12">
                                    <div class="resourcesBox">
                                        <div class="grid-equalHeight">
											<?foreach($techs as $tech):?>
                                            <div class="col-6_sm-12">
                                                <a href="<?=base_url()?>exportartech/verPDF/<?=$tech['idtech']?>/<?=$lang?>" class="color01" target="_blank">
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                    <span>
                                                        <strong>Fontagro tech</strong>
                                                        <?=$tech['tech_titulo']?>
                                                    </span>
                                                </a>
											</div>
											<?endforeach?>
											<?foreach($posters as $poster):?>
                                            <div class="col-6_sm-12">
                                                <a href="<?=base_url()?>exportarposter/verPDF/<?=$poster['url']?>/<?=$lang?>" class="color02" target="_blank">
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                    <span>
                                                        <strong>Poster</strong>
                                                        <?=$poster['titulo']?>
                                                    </span>
                                                </a>
                                            </div>
											<?endforeach?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				<?endif?>
                <div class="related" id="related">
                    <div class="box">
                        <div id="histories">
                            <h3 class="linetop">
								<?=$textos['otros_proyectos']?>
                            </h3>
                            <div class="relatedItems">
                                <div class="grid-equalHeight">
									<?foreach($otrasPropuestas as $otras):?>
                                    <div class="col-4_sm-12">
                                        <a href="<?=LINK_PROYECTOS?><?=$otras['web_url']?>/<?=$lang?>" class="relatedProject">
                                            <div class="imgBox">
                                                <span class="img bgCover" style="background-image: url(<?=base_url()?>uploads/propuestas/<?=empty($otras['foto_link'])? $otras['foto'] : $otras['foto_link']; ?>);"></span>
                                            </div>
                                            <h4>
												<?=$otras['titulo_simple']?>
                                            </h4>
                                        </a>
                                    </div>
									<?endforeach?>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="prefooter" id="prefooter">
					<div class="box">
						<div class="grid-middle-noBottom">
							<div class="col-7_md-12">
								<div class="grid-middle-noBottom">
									<div class="col-4_sm-12">
										<div class="logosTitle">
										<?=$textos['patrocinadores']?>
										</div>
									</div>
									<div class="col-8_sm-12">
										<div class="grid-middle-noBottom">
											<div class="col alignLeft"><img src="<?=base_url()?>img/proyecto/bid.jpg" alt="BID"></div>
											<div class="col alignLeft"><img src="<?=base_url()?>img/proyecto/iica.jpg" alt="IICA"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-5_md-12">
								<div class="grid-middle-noBottom">
									<div class="col-5_md-4_sm-12">
										<div class="logosTitle">
											<?=$textos['con_el_apoyo']?>
										</div>
									</div>
									<div class="col-75_md-8_sm-12">
										<div class="grid-middle-noBottom">
											<div class="col alignLeft"><img src="<?=base_url()?>img/proyecto/fondocoreano.jpg" alt="Fondo Coreano de Alianza para el Conocimiento en Tecnología e Innovación (KPK)"></div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<footer class="footer">
					<div class="box">
						<div class="grid-middle-noBottom">
							<div class="col-8_sm-12">
								<div class="grid-middle-noBottom">
									<div class="col-2">
										<a href="https://www.fontagro.org/" target="_blank"><img src="<?=base_url()?>img/webstory/fontagro-logo-color.svg" alt="Fontagro"></a>
									</div>
									<div class="col-10">
										<p>
											© FONTAGRO | 1300 New York Avenue NW, Stop W0502 Washington, DC 20577 <br>
											E-mail: fontagro@iadb.org
										</p>
									</div>
								</div>
								
							</div>
							<div class="col-4_sm-12 alignRight">
								<div class="socialBox">
									<a href="<?=$textos['twitter']?>" target="_blank"><i class="fa fa-fw fa-twitter"></i></a>
									<a href="<?=$textos['vimeo']?>"><i class="fa fa-fw fa-vimeo" target="_blank"></i></a>
									<a href="<?=$textos['youtube']?>"><i class="fa fa-fw fa-youtube-play" target="_blank"></i></a>
									<a href="<?=$textos['linkedin']?>" target="_blank"><i class="fa fa-fw fa-linkedin"></i></a>									
								</div>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
    </div>
    <script src="<?=base_url()?>js/proyecto/jquery-3.4.1.min.js"></script>
	<script src="<?=base_url()?>js/webstory/classie.js"></script>
	<script src="<?=base_url()?>js/webstory/swiper.min.js"></script>
	<script src="<?=base_url()?>js/proyecto/main.js"></script>

	<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
	<script src="<?=base_url()?>material/assets/js/plugins/jquery-jvectormap.js"></script>

    <script>
        var swiper = new Swiper('.news', {
		  slidesPerView: 3,
		  slidesPerColumn: <?=sizeof($noticias)<6?'1':'2'?>,
		  spaceBetween: 55,
		  navigation: {
				nextEl: '.news-button-next',
				prevEl: '.news-button-prev',
			},
			breakpoints: {
				640: {
				slidesPerView: 1,
				spaceBetween: 20,
				},
				768: {
				slidesPerView: 2,
				spaceBetween: 30,
				},
				1024: {
				slidesPerView: 3,
				spaceBetween: 30,
				},
			}
        });
        var swiper = new Swiper('.docs', {
			slidesPerView: 1,
		 	 spaceBetween: 30,
		    navigation: {
				nextEl: '.docs-button-next',
				prevEl: '.docs-button-prev',
			}
        });

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
			
			new Chartist.Pie('.pie-chart', {
					series: [<?=round($propuesta['aporte_fontagro'])?>, <?=round($propuesta['aporte_bid']+$propuesta['movilizacion_agencias']+$propuesta['aporte_agencias'])?>, <?=round($propuesta['aporte_contrapartida'])?>],
					
				}, {
					labelInterpolationFnc: function(value) {
						return value[0]
					},
					showLabel: false
				}, [
				['screen and (min-width: 640px)', {
					chartPadding: 30,
					labelOffset: 100,
					labelDirection: 'explode',
					labelInterpolationFnc: function(value) {
					return value;
					}
				}],
				['screen and (min-width: 1024px)', {
					labelOffset: 80,
					chartPadding: 20
				}]
			]);

			<?
			$labelBar = "[";
			$serieFon = "[";
			$serieBid = "[";
			$serieCon = "[";
			foreach($financiamiento as $fin){
				$labelBar .= "'".$fin['pais']."', ";
				$serieFon .=round($fin['fontagro']).', ';
				$serieBid .=round($fin['bid']).', ';
				$serieCon .=round($fin['contrapartida']).', ';
			}
			$labelBar .=']';
			$serieFon .=']';
			$serieBid .=']';
			$serieCon .=']';
			?>

			new Chartist.Bar('.ct-chart', {
					labels: <?=$labelBar?>,
					series: [<?=$serieFon?>,<?=$serieBid?>,<?=$serieCon?>]
				}, {
					stackBars: true,
					axisY: {
						labelInterpolationFnc: function(value) {
						return (value / 1000) + 'k';
						}
					}
				}).on('draw', function(data) {
				if(data.type === 'bar') {
					data.element.attr({
					style: 'stroke-width: 30px'
					});
				}
			});
		});

		<?if(!empty($mapa)):?>
			var startPoint = [<?=$startingPoint['lat']?>, <?=$startingPoint['lng']?>];
			var map = L.map('mapa', {editable: true, scrollWheelZoom: false}).setView(startPoint, 6),
				tilelayer = L.tileLayer('http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {maxZoom: 20, attribution: 'Data \u00a9 <a href="http://www.openstreetmap.org/copyright"> OpenStreetMap Contributors </a> Tiles \u00a9 HOT'}).addTo(map);

				L.EditControl = L.Control.extend({

					options: {
						position: 'topleft',
						callback: null,
						kind: '',
						html: ''
					},

					onAdd: function (map) {
						var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar'),
							link = L.DomUtil.create('a', '', container);

						link.href = '#';
						link.title = 'Create a new ' + this.options.kind;
						link.innerHTML = this.options.html;
						L.DomEvent.on(link, 'click', L.DomEvent.stop)
								.on(link, 'click', function () {
									window.LAYER = this.options.callback.call(map.editTools);
								}, this);

						return container;
					}

				});

			var isDirty = false;
			var idlocal = 1;
			var elementos = new Array();  
			var aux;
			var grupeteArray = new Array();
			var nuevoElemento; 
			<? 	foreach($elementos as $elem):?>
				nuevoElemento = new Object();
				nuevoElemento.idlocal = idlocal;
				nuevoElemento.idelemento = <?=$elem['idelemento']?>;
				idlocal++;

				<?if($elem['tipo']=='marcador'):?>
					aux = L.marker([<?=$elem['latlng']['lat']?>, <?=$elem['latlng']['lng']?>]).addTo(map);
				<?else:?>
					aux =  L.polygon([[
						<?foreach($elem['latlng'] as $latlng):?>
							[<?=$latlng['lat']?>, <?=$latlng['lng']?>],
						<?endforeach?>
					]]).addTo(map);
				<?endif?>
				aux.enableEdit();
				grupeteArray.push(aux);

				nuevoElemento.elem = aux;
				if (aux instanceof L.Path){
					nuevoElemento.tipo = 'poligono';
				}else if(aux instanceof L.Marker) {
					nuevoElemento.tipo = 'marcador'; 
				}
				nuevoElemento.link = '<?=$elem['link']?>';
				nuevoElemento.foto = '<?=$elem['foto']?>';
				nuevoElemento.nombre='<?=$elem['nombre_'.$lang]?>';
				nuevoElemento.descripcion='<?= str_replace(array("\r", "\n"), '', $elem['descripcion_'.$lang]) ?>';				
				aux.bindPopup(getPopupHtml(nuevoElemento))
				elementos.push(nuevoElemento);

			<? 	endforeach ?>
			

			<?if(!empty($elementos)):?>
				var grupete = L.featureGroup(grupeteArray);
				map.fitBounds(grupete.getBounds(),{maxZoom:8});
			<?endif?>

			function actualizarLista(){
				$('#contenedorElementos').html('');
				elementos.forEach(procesarLista);	
			}


			function getPopupHtml(elemento){
				var popuphtml = '<b>'+elemento.nombre+'</b><br/>'+elemento.descripcion+'<br/><img width="400" src="<?=base_url()?>uploads/mapas/'+elemento.foto+'"/>';
				return popuphtml;
			}
			

		<?endif; /*FIN MAPA*/?>
    </script>
</body>
</html>