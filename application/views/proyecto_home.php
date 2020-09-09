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
	<link href="<?=base_url()?>css/webstory/swiper.min.css" rel="stylesheet">
	<script src="<?=base_url()?>js/webstory/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<!--<link href="<?=base_url()?>css/webstory/jquery-jvectormap-2.0.5.css" rel="stylesheet">	-->
	<link href="https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css" rel="stylesheet" />
    <link href="<?=base_url()?>local/select2.min.css" rel="stylesheet">

	<!-- Parallax -->
	<script type="text/javascript" src="<?=base_url()?>js/webstory/ScrollMagic.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/TweenMax.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/animation.gsap.js"></script>


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
				<a href="<?=LINK_PROYECTOS?>home/<?=$lang?>"><?=$textos['iniciativas_y_proyectos']?></a>
				<a href="#encurso"><?=$textos['iniciativas_en_curso']?></a>
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
								<a href="https://www.fontagro.org/" target="_blank" class="logo animated fadeIn">
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
										<a href="<?=LINK_PROYECTOS?>home/es" class="<?=($lang=='es')? 'active' : '' ?>">Es</a>
										<a href="<?=LINK_PROYECTOS?>home/en" class="<?=($lang=='en')? 'active' : '' ?>">En</a>
									</div>
									<div class="menuNav">
										<a href="#navigation" class="menu-button" id="open-button">
										<?=$textos['menu']?> <span></span>
										</a>
									</div>
								</div>
								<nav class="animated fadeIn">
									<ul>
										<li><a href="<?=LINK_PROYECTOS?>home/<?=$lang?>"><?=$textos['iniciativas_y_proyectos']?></a></li>
										<li><a href="#encurso"><?=$textos['iniciativas_en_curso']?></a></li>
										<li><a href="https://www.fontagro.org/es/quienes-somos/"><?=$textos['sobre_fontagro']?></a></li>
										<!--<li><a href="#" class="login">Ingresar</a></li>-->
									</ul>
								</nav>
								
							</div>
						</div>

					</div>
                </header>
				<div class="cta box">
					<h1 class="animated fadeInDown">
						<?=$textos['proyhome_tit_part1']?> <br><?=$textos['proyhome_tit_part2']?> <strong><?=$textos['proyhome_tit_part3']?></strong>
					</h1>
					<a href="#encurso"><img src="<?=base_url()?>img/proyecto/right-lightblue.svg" alt=""> <?=$textos['iniciativas_en_curso']?></a> <a href="#"><img src="<?=base_url()?>img/proyecto/right-lightblue.svg" alt=""> <?=$textos['proyhome_buscar_proy']?></a>
				</div>
				<div class="map" id="map">
					<div class="box float" style="height:0px">
						<div class="dataBox animated fadeInUp">
							<div class="dataInfo totalProyectos animated fadeIn">
								<div class="num" id="counter01">
									<?=$cantpropuestas?>
								</div>
								<?=$textos['proyhome_proy_activos']?>
							</div>
							<div class="dataInfo totalUsd animated fadeIn">
								<div class="num" id="counter02"><!--< ?=number_format($totalusd,0,',','.')?>--><?=$totalusd ?></div>
								<?=$textos['proyhome_usd_fondos']?>
							</div>
						</div>
					</div>
					<!--<div class="box float" style="height:0px">
						<div id="proy_descripcion" style="width: 350px; background:white; color:black;margin: 200px auto 0; display: none;">
							<button type="button" onclick="$('#proy_descripcion').hide()" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<div><h5 id="proy_titulo"></h5></div>
							<div><span><?=$textos['proyectos_dato_1']?>:</span> <span id="proy_codigo"></span></div>
							<div><span><?=$textos['proyhome_ejecutor']?>:</span> <span id="proy_ejecutor"></span></div>
							<div><span><?=$textos['proyectos_dato_6']?>:</span> <span id="proy_total"></span></div>
							<a id="proy_link" href="#" class="btn secondary"><?=$textos['proyhome_conocer']?></a>
						</div>
					</div>-->
					<div class="mapBox">
						<div id="worldMap" style="height: 110%;"></div>
					</div>
				</div>
				<div class="searchProyect" id="search">
					<div class="box">
						<div class="searchBox">
							<div class="grid-middle-noBottom">
								<div class="col-2_md-12 alignRight alignMiddle">
									<h3><?=$textos['proyhome_buscar_proy']?></h3>
								</div>
								<div class="col-10_md-12">
								<div class="grid-equalHeight">
										<div class="col-10_sm-9_xs-12">
											<div class="grid-equalHeight">
												<div class="col-8_sm-12">
													<div class="inputBox">
														<input type="text" id="keyword" placeholder="<?=$textos['proyhome_pal_clave']?>" value="">
													</div>
												</div>
												<div class="col-4_sm-6">
													<div class="inputBox">
														<select id="anio" class="select-tipo">
															<option></option>
															<?foreach($anios as $ti):?>
																<option value="<?=$ti['anio']?>"><?=$ti['anio']?></option>
															<?endforeach?>
														</select>
													</div>
												</div>
												<div class="col-4_sm-6">
													<div class="inputBox">
														<select id="estado" class="select-estado">
															<option></option>
															<?foreach($estados as $ti):?>
																<option value="<?=$ti['value']?>"><?=$ti['label']?></option>
															<?endforeach?>
														</select>
													</div>
												</div>
												<div class="col-4_sm-6">
													<div class="inputBox">
														<select id="tema" class="select-temas" multiple>
															<option></option>
															<optgroup label="Linea estratégica">
																<?foreach($estrategicas as $ti):?>
																	<option groupid="1" value="est_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Innovacion">
																<?foreach($innovaciones as $ti):?>
																	<option groupid="2" value="inn_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Investigacion">
																<?foreach($investigaciones as $ti):?>
																	<option groupid="3" value="inv_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Solución tecnológica">
																<?foreach($soluciones as $ti):?>
																	<option groupid="4" value="sol_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Sector productivo">
																<?foreach($sectores as $ti):?>
																	<option groupid="5" value="sec_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Subsector">
																<?foreach($subsectores as $ti):?>
																	<option groupid="6" value="sub_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Tema">
																<?foreach($temas as $ti):?>
																	<option groupid="7" value="tem_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>

														  </select>
													</div>
												</div>
												<div class="col-4_sm-6">
													<div class="inputBox">
														<select id="pais" class="select-pais">
															<option></option>															
															<?foreach($paises as $ti):?>
																<option value="<?=$ti['value']?>"><?=$ti['label']?></option>
															<?endforeach?>
														</select>
													</div>
												</div>
											</div>

										</div>
										<div class="col-2_sm-3_xs-12">
											<div class="grid">
												<div class="col-12">
													<button onclick="buscar(0)"><?=$textos['proyhome_buscar']?></button>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							
							</div>
						</div>
						<div class="searchLinks alignRight">
						<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>" class="grey"><img src="<?=base_url()?>img/proyecto/right-gray.svg" alt=""> <?=$textos['proybus_todos']?></a>
							<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?estado=1" class="grey"><img src="<?=base_url()?>img/proyecto/right-gray.svg" alt=""> <?=$textos['proybus_activos']?></a>
							<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?estado=2" class="grey"><img src="<?=base_url()?>img/proyecto/right-gray.svg" alt=""> <?=$textos['proybus_ejecutados']?></a>
						</div>
					</div>
				</div>
				<div class="listProjects">
					<div class="box">
						<!-- Swiper -->
						<div class="swiper-container projects">
							<div class="swiper-wrapper">
								<?foreach($propuestas as $prop):
									$link = empty($prop['web_publicado']) || empty($prop['web_url'])? '': LINK_PROYECTOS.$prop['web_url'].'/'.$lang;
									if(empty($link)){
										//if(empty($pro['urlvieja'])){
											$link = 'https://www.fontagro.org/es/resultados/buscador-de-proyectos/';
										/*}else{
											$link = $pro['urlvieja'];
										}*/
									}
									?>
								<div class="swiper-slide">
									<div class="projectBox">
										<span><?=$prop['operacion']?> <?=$prop['anio']?> · <a href="<?=$link?>"><?=$prop['identificador']?></a></span>
										<a href="<?=$link?>" title="<?=$prop['titulo_simple']?>">
											<?=$prop['titulo_completo']?>
										</a>
									</div>
								</div>
								<?endforeach?>								
							</div>
						</div>
						<div class="buttons alignRight">
							 <!-- Add Arrows -->
							<a href="#" class="projects-button-prev btn"><?=$textos['proyecto_anterior']?></a>
							<a href="#" class="projects-button-next btn"><?=$textos['proyecto_siguiente']?></a>
							<a href="<?=LINK_PROYECTOS?>buscador" class="btn secondary"><?=$textos['proyhome_ver_todos']?></a>
						</div>
					</div>
				</div>
				<div class="iniciativasBox">
					<div class="box">
						<div class="grid-middle">
							<div class="col-3_lg-12">
								<div class="introBlock">
									<h2><?=$textos['proyhome_iniciativas']?></h2>
									<p><?=$textos['proyhome_ini_desc']?></p>
								</div>
							</div>
							<div class="col-9_lg-12">
								<div class="grid-equalHeight">
									<div class="col-6_sm-6_xs-12">
										<a href="https://www.fontagro.org/es/como-trabajamos/convocatorias/" target="_blank" class="iniciativa bgCover" style="background-image: url(<?=base_url()?>img/prod.jpg);">
											<span class="txt">
												<strong><?=$textos['proyhome_convocatorias']?></strong>
												<span><?=$textos['proyhome_conocer']?></span>
											</span>
										</a>
									</div>
									<div class="col-6_sm-6_xs-12">
										<a href="https://www.fontagro.org/es/como-trabajamos/concurso-de-casos/" target="_blank" class="iniciativa bgCover" style="background-image: url(<?=base_url()?>img/proyecto/img.jpg);">
											<span class="txt">
												<strong><?=$textos['proyhome_concursos']?></strong>
												<span><?=$textos['proyhome_conocer']?></span>
											</span>
										</a>
									</div>
									<!--<div class="col-3_sm-6_xs-12">
										<a href="#" class="iniciativa bgCover" style="background-image: url(<?=base_url()?>img/proyecto/img.jpg);">
											<span class="txt">
												<strong>Proyectos consensuados</strong>
												<span><?=$textos['proyhome_conocer']?></span>
											</span>
										</a>
									</div>
									<div class="col-3_sm-6_xs-12">
										<a href="#" class="iniciativa bgCover" style="background-image: url(<?=base_url()?>img/proyecto/img.jpg);">
											<span class="txt">
												<strong>Fondos semilla</strong>
												<span><?=$textos['proyhome_conocer']?></span>
											</span>
										</a>
									</div>-->
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="encursoBox" id="encurso">
					<div class="box">
						<h3 class="linetop"><?=$textos['iniciativas_en_curso']?></h3>
						<div class="grid-equalHeight">
							<?foreach($iniciativas as $ini):
								$clase = 'open';
								$boton = '<a href="'.base_url().'iniciativas" class="btn white">'.$textos['proyhome_cargar'].'</a>';
								if($ini['idestadoreal']==2){
									$clase = 'preselection';
									$boton = '<a href="https://www.fontagro.org/new/iniciativas/" class="btn white">'.$textos['proyhome_ver'].'</a>';
								}else if($ini['idestadoreal']==3){
									$clase = 'selection';
									$boton = '<a href="https://www.fontagro.org/new/iniciativas/" class="btn white">'.$textos['proyhome_editar'].'</a>';
								}else if($ini['idestadoreal']==4){
									$clase = 'selection';
									$boton = '';
								}
								$numIniciativas = count($iniciativas);
								?>	
							<?php if($numIniciativas==1){ ?>
							<div class="col-12_md-12">
							<?php } else if($numIniciativas==2) { ?>
								<div class="col-6_md-12">
							<?php } else if($numIniciativas==4) { ?>
								<div class="col-3_lg-6_md-12">
							<?php } else { ?>
								<div class="col-4_md-12">
							<?php } ?>
								<div class="iniciativaBox <?=$clase?>">
									<div class="iniciativaInfo">
										<div class="category">
											<?=$ini['titulo']?> - <?=$ini['tipo']?>
										</div>
										<h4>
											<?=$ini['descripcion']?>
										</h4>
										<div class="state">
											<?=$textos['proyhome_estado']?>: <span><?=$ini['estado']?></span>
										</div>
									</div>
									<div class="actions">
										<div class="grid-middle-noBottom">
											<div class="col-5">
												<a href="<?=LINK_PROYECTOS.'iniciativa/'.$ini['idiniciativa'].'/'.toURLFriendly($ini['titulo']).'/'.$lang?>"><?=$textos['proyhome_conocer']?></a>
											</div>
											<div class="col-7 alignRight">
												<?=$boton?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?endforeach?>							
						</div>
					</div>					
				</div>
				
				<div class="historiasBox" id="historias">
					<div class="box">
						<h3 class="linetop"><?=$textos['historias']?></h3>
						<!-- Swiper -->
						<div class="swiper-container related">
							<div class="swiper-wrapper">
								<?foreach($webstories as $ws):?>
								<div class="swiper-slide">
									<a href="<?=LINK_WEBSTORIES?><?=$ws['url']?>" class="historia" style="background-image: url(<?=base_url()?>uploads/webstories/<?=empty($ws['foto_link'])? $ws['foto'] : $ws['foto_link']; ?>);">
										<h4><?=$ws['titulo']?></h4>
									</a>
								</div>
								<?endforeach?>
							</div>
						</div>
						<a href="#" class="swiper-button-prev related-button-prev"><?=$textos['proyecto_anterior']?></a>
						<a href="#" class="swiper-button-next related-button-next"><?=$textos['proyecto_siguiente']?></a>
					</div>
				</div>

				<div class="novedadesBox" id="news">
					<div class="box">
						<h3 class="linetop"><?=$textos['proyhome_ultimas']?> <span><?=$textos['proyhome_delos']?></span></h3>
						<div class="grid-equalHeight">
							<?foreach($noticias as $noticia):
								$link = empty($noticia['web_publicado']) || empty($noticia['web_url'])? '#': LINK_PROYECTOS.$noticia['web_url'].'/'.$lang;
								?>
							<div class="col-4_sm-12">
								<div class="novedad">
									<div class="projectInfo">
										<strong><?=$textos['proyhome_proyecto']?>:</strong> <a href="<?=$link?>" class="grey"><?=$noticia['titulo_simple']?></a>
									</div>
									<div class="grid">
										<div class="col-3_md-12_sm-3">
											<a href="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/<?=$lang?>/<?=$noticia['url']?>" class="imgNews bgCover" style="background-image: url(<?=base_url()?>uploads/noticias/400_<?=$noticia['foto']?>);">
											</a>
										</div>
										<div class="col-9_md-12_sm-9">
											<h5>
												<a href="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/<?=$lang?>/<?=$noticia['url']?>"><?=$noticia['titulo']?></a>
											</h5>
										</div>
									</div>
								</div>
							</div>
							<?endforeach?>
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
	<script src="<?=base_url()?>js/select2.min.js"></script>
	<script src="<?=base_url()?>js/proyecto/main.js"></script>
	<script src="<?=base_url()?>js/proyecto/countUp.min.js"></script>

	<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ 
	<script src="<?=base_url()?>material/assets/js/plugins/jquery-jvectormap-2.0.5.min.js"></script>-->
	<script src="https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js"></script>

	<!-- Initialize select -->
	<script>
		$(document).ready(function() {
			$('.select-tipo').select2({
				placeholder: "<?=$textos['proyhome_anio']?>",
				allowClear: false
			});
			$('.select-pais').select2({
				placeholder: "<?=$textos['proyhome_pais']?>",
				allowClear: false
			});
			$('.select-temas').select2({
				placeholder: "<?=$textos['proyhome_tema']?>",
				allowClear: false
			});
			$('.select-estado').select2({
				placeholder: "<?=$textos['proyhome_estado']?>",
				minimumResultsForSearch: Infinity,
				allowClear: false
			});

			<?/*var points = [
				<?foreach($puntosMapa as $punto):
					$latlon = json_decode($punto['latlng'], true);?>
					{name: '<?=$punto['titulo_simple']?>', coords: [<?=$latlon['lat']?>, <?=$latlon['lng']?>], status: '<?=$punto['estado']==1? 'open':'closed'?>', pais: '<?=$punto['pais']?>', organismo: '<?=$punto['organismo']?>', identificador: '<?=$punto['identificador']?>', total: '<?=$punto['total']?>', url: '<?=$punto['url']?>'},
				<?endforeach?>
				<?foreach($puntosMapaEstimados as $punto):?>
					{name: '<?=$punto['titulo_simple']?>', coords: [<?=$punto['latitud']+rand(-1000,1000)/500?>, <?=$punto['longitud']+rand(-1000,1000)/500?>], status: '<?=$punto['estado']==1? 'open':'closed'?>', pais: '<?=$punto['pais']?>', organismo: '<?=$punto['organismo']?>', identificador: '<?=$punto['identificador']?>', total: '<?=$punto['total']?>', url: '<?=$punto['url']?>'},
				<?endforeach?>
			];*/?>
			/*
			$("#worldMap").vectorMap({
				map:"world_mill_en",
				backgroundColor:"transparent",
				zoomOnScroll:!1,
				regionStyle:{
					initial: {
						fill:"#466c81",
						"fill-opacity":1,
						stroke:"none",
						"stroke-width":0,
						"stroke-opacity":0
					}
				},
				markers: points.map(function(h){ return {name: h.name, latLng: h.coords} }),	
				onMarkerTipShow: function(event, label, index){
					label.html(
					'<?=$textos['proyhome_proyecto']?>: <b>'+points[index].name+'</b><br/>'+
					'<?=$textos['proyhome_organismo']?>: <b>'+points[index].organismo+'</b><br/>'
					);
				},
				onRegionOver: function(event, code){
					event.preventDefault()
				},
				onMarkerClick: function(event, index){
					$('#proy_titulo').html(points[index].name);
					$('#proy_codigo').html(points[index].identificador);
					$('#proy_ejecutor').html(points[index].organismo+' - '+points[index].pais);
					$('#proy_total').html(points[index].total);
					if(points[index].url==''){
						//$('#proy_link').hide();						
						$('#proy_link').attr("href", '#');//TODO no mostrar boton
					}else{
						$('#proy_link').show();
						$('#proy_link').attr("href", '<?=LINK_PROYECTOS?>'+points[index].url+'/<?=$lang?>');
					}
					$('#proy_descripcion').show();

				},
				series: {
					markers: [{
						attribute: 'image',
						scale: {
							'closed': '<?=base_url()?>img/proyecto/point2.png',
							'open': '<?=base_url()?>img/proyecto/point.png'
						},
						values: points.reduce(function(p, c, i){ p[i] = c.status; return p }, {}),						
					}]
				}
			});*/


		});
	</script>
	 <!-- Initialize Swiper -->	 
	 <script>
		var swiper = new Swiper('.projects', {
		  slidesPerView: 3,
		  slidesPerColumn: 2,
		  spaceBetween: 55,
		  navigation: {
				nextEl: '.projects-button-next',
				prevEl: '.projects-button-prev',
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
		var swiper = new Swiper('.related', {
			slidesPerView: 3,
			spaceBetween: 18,
			navigation: {
				nextEl: '.related-button-next',
				prevEl: '.related-button-prev',
			},
			breakpoints: {
				1024: {
				slidesPerView: 3,
				spaceBetween: 18,
				},
				768: {
				slidesPerView: 2.2,
				spaceBetween: 16,
				},
				640: {
				slidesPerView: 1.2,
				spaceBetween: 12,
				},
				320: {
				slidesPerView: 1.2,
				spaceBetween: 12,
				}
			}
		});

		function buscar(pagina){
			var keyword = $('#keyword').val();
			var anio = $('#anio').val();
			var estado = $('#estado').val();
			var pais = $('#pais').val();
			var link = '<?=LINK_PROYECTOS?>buscar/<?=$lang?>?keyword='+keyword+'&anio='+anio+'&estado='+estado+'&pais='+pais+'&pagina='+pagina;

			var temas = $('.select-temas').find(':selected');
			for(var i=0; i<temas.length; i++){
				var dato = $(temas[i]).val();
				var tipo = dato.substring(0,3);
				var valor = dato.substring(4);
				switch(tipo){
					case 'est':
						link += '&estrategica='+valor;
						break;
					case 'inn':
						link += '&innovacion='+valor;
						break;
					case 'inv':
						link += '&investigacion='+valor;
						break;
					case 'sol':
						link += '&solucion='+valor;
						break;
					case 'sec':
						link += '&sector['+valor+']='+valor;
						break;
					case 'sub':
						link += '&subsector['+valor+']='+valor;
						break;
					case 'tem':
						link += '&tema['+valor+']='+valor;
						break;
				}
				console.log(valor);
			}
			window.location.href = link;
		}

		function countup() {
			var options = {
			useEasing: true,
			useGrouping: true,
			separator: '.',
			decimal: ','
			};

			var count1 = new CountUp('counter01', 0, $("#counter01").text(), 0, 3, options);
			var count2 = new CountUp('counter02', 0, $("#counter02").text(), 0, 3, options);
			if (!count1.error) {
				count1.start();
			} else {
				console.error(count1.error);
			}
			if (!count2.error) {
				count2.start();
			} else {
				console.error(count2.error);
			}
			
		}
		countup();
	  </script>

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
            var ver = (e.features[0].properties.url=='' || e.features[0].properties.publicado==0) ? '' : '<a href="<?=LINK_PROYECTOS?>'+e.features[0].properties.url+'/<?=$lang?>"><?=$textos['conocer_mas']?></a>';
			if(ver==''){
				//if(e.features[0].properties.urlvieja==''){
					ver = '<a href="https://www.fontagro.org/es/resultados/buscador-de-proyectos/"><?=$textos['conocer_mas']?></a>';
				/*}else{
					ver = '<a href="'+e.features[0].properties.urlvieja+'"><?=$textos['conocer_mas']?></a>';
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
	
	(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
      
       // Select all links with hashes
        $('a[href*="#"]')
        // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        .click(function(event) {
            // On-page links
            if (
            location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
            && 
            location.hostname == this.hostname
            ) {
            // Figure out element to scroll to
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            // Does a scroll target exist?
            if (target.length) {
                // Only prevent default if animation is actually gonna happen
                event.preventDefault();
                $('#container').animate({
                scrollTop: target.offset().top
                }, 1000, function() {
                // Callback after animation
                // Must change focus!
                var $target = $(target);
                $target.focus();
                if ($target.is(":focus")) { // Checking if the target was focused
                    return false;
                } else {
                    $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
                    $target.focus(); // Set focus again
                };
                });
            }
            }
        });

		$('#keyword').keypress(function(e) {
            // Enter pressed?
            if(e.which == 10 || e.which == 13) {
                buscar(0);
            }
        });

		//Select2 Event handler for selecting an item
		$('.select-temas').on("select2:selecting", function(evt, f, g) {
			disableSel2Group(evt, this, true);
		});

		// Select2 Event handler for unselecting an item
		$('.select-temas').on("select2:unselecting", function(evt) {
			disableSel2Group(evt, this, false);
		});
    });
	
})(jQuery, this);


		function disableSel2Group(evt, target, disabled) {
			// Found a note in the Select2 formums on how to get the item to be selected

			var selId = evt.params.args.data.id;
			console.log(selId);
			var group = $(".select-temas option[value='" + selId + "']").attr("groupid");
			if (group>=5) return;
			var aaList = $("option", target);
			$.each(aaList, function(idx, item) {
				//console.log(item);
				var data = $(item).val();
				var itemGroupId = $("option[value='" + data + "']").attr("groupid");
				//console.log(itemGroupId+' '+group+' '+data+' '+selId)
				if (itemGroupId == group && data != selId) {
					if(disabled){
						$("option[value='" + data + "']").attr('disabled','disabled');
					}else{
						$("option[value='" + data + "']").removeAttr('disabled');
					}
				}
			})
			//$('.select-temas').trigger('change.select2');
		}
</script>
</body>
</html>