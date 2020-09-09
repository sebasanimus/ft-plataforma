<!DOCTYPE html>
<html lang="<?=$lang?>">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
	<title><?=$iniciativa['titulo']?></title>
	<meta name="description" content="<?=$iniciativa['descripcion']?>">
	<link rel="shortcut icon" href="<?=base_url()?>favicon.ico">
    <meta name="author" content="ANIMUS">


	<link href="<?=base_url()?>css/proyecto/style.css" rel="stylesheet">
	<link href="<?=base_url()?>css/webstory/swiper.min.css" rel="stylesheet">
	<script src="<?=base_url()?>js/webstory/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    
    <!-- Parallax -->
	<script type="text/javascript" src="<?=base_url()?>js/webstory/ScrollMagic.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/TweenMax.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/animation.gsap.js"></script>


	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@FONTAGROdigital">
	<meta name="twitter:title" content="<?=$iniciativa['titulo']?>">
	<meta name="twitter:description" content="<?=$iniciativa['descripcion']?>">
	<meta name="twitter:creator" content="@FONTAGROdigital">
	<meta name="twitter:image" content="<?=base_url()?>uploads/noticias/<?=$iniciativa['foto']?>">

	<!-- Open Graph data -->
	<meta property="og:title" content="<?=$iniciativa['titulo']?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?=LINK_PROYECTOS.'iniciativa/'.$iniciativa['idiniciativa'].'/'.toURLFriendly($iniciativa['titulo']).'/'.$lang?>" />
	<meta property="og:image" content="<?=base_url()?>uploads/noticias/<?=$iniciativa['foto']?>" />
	<meta property="og:description" content="<?=$iniciativa['descripcion']?>" />

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
						<div id="ctaParallax" class="ctaParallax bgCover" style="background-image: url('<?=base_url()?>uploads/noticias/<?=$iniciativa['foto']?>');"></div>
					</div>
                    <div class="box">
                        <div class="txt" id="ctaTxt">
                            <div class="titleBox">
                                <h1>
									<?=$iniciativa['titulo']?> - <?=$iniciativa['tipo']?>
                                </h1>
                                <h3><?=$iniciativa['descripcion']?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="newsContent">
                    <div class="box">
                        <div class="contentTxt">
                            <div class="grid">
								<?
								$clase = 'open';
								$boton = '<a href="'.base_url().'iniciativas" class="btn white"><i class="fa fa-sign-in" aria-hidden="true"></i> '.$textos['proyhome_cargar'].'</a>';
								if($iniciativa['idestadoreal']==2){
									$clase = 'preselection';
									$boton = '<a href="#" class="btn white"><i class="fa fa-sign-in" aria-hidden="true"></i> '.$textos['proyhome_ver'].'</a>';
								}else if($iniciativa['idestadoreal']==3){
									$clase = 'selection';
									$boton = '<a href="#" class="btn white"><i class="fa fa-sign-in" aria-hidden="true"></i> '.$textos['proyhome_editar'].'</a>';
								}else if($iniciativa['idestadoreal']==4){
									$clase = 'selection';
									$boton = '';
								}
								?>

                                <div class="col-9_lg-9_md-9_sm-12">
                                    <div class="entry-content">
                                        <div class="stateBox <?=$clase?>">
                                            <div class="state">
												<?=$textos['proyhome_estado']?> <span><?=$iniciativa['estado']?></span>
                                            </div>
                                        </div>
                                        <div class="intro">
                                            <h5>
                                                <?=$iniciativa['html_intro']?>
                                            </h5>
                                        </div>
                                        <?=$iniciativa['html_parte1']?>
										<div class="iniciativaBox">
											<div class="iniciativaInfo">
												<div class="category">
													<?=$iniciativa['titulo']?> - <?=$iniciativa['tipo']?>
												</div>
												<h4><?=$iniciativa['descripcion']?></h4>
												<p><?=$iniciativa['estado_descripcion']?></p>
											</div>
											<div class="actions">
												<div class="grid-middle-noBottom">
													<div class="col-5_sm-12">
														<div class="state">
															<?=$textos['proyhome_estado']?>: <span> <?=$iniciativa['estado']?></span>
														</div>
													</div>
													<div class="col-7_sm-12 alignRight">
														<?=$boton?>
													</div>
												</div>
											</div>
										</div>
										<?=$iniciativa['html_parte2']?>
										
                                        <?if(!empty($iniciativa['link_preseleccionados'])):?>
                                        <div class="alert">
                                            <h4><?=$textos['proyini_perfiles_pre']?></h4>
                                            <p><?=$textos['proyini_perfiles_desc']?>&nbsp;<a href="<?=$iniciativa['link_preseleccionados']?>"><strong><?=($lang=='en')? 'here':'aquí'?></strong></a>.</p>
                                        </div>
										<?endif?>
										<?if(!empty($iniciativa['link_ganadores'])):?>
                                        <div class="alert">
                                            <h4><?=$textos['proyini_ganadores']?></h4>
                                            <?=$textos['proyini_ganadores_desc']?> <strong><a href="<?=$iniciativa['link_ganadores']?>"><?=$textos['proyini_ganadores']?></a></strong>.
                                        </div>   
										<?endif?>  
                                        <div class="alert">
                                            <h4><?=$textos['proyini_info']?></h4>
                                            <p><?=$textos['proyini_info_desc']?>&nbsp;<a href="mailto:fontagro@iadb.org"><span class="s8">fontagro@iadb.org</span></a></span></p>
                                        </div>                 
                                       
                                    </div>  
                                </div>
                                <div class="col-3_lg-3_md-3_sm-12">
                                    <div class="columnBox">
                                       <nav>
										   <ul>
										   		<?if(!empty($iniciativa['link_preseleccionados'])):?><li><a href="<?=$iniciativa['link_preseleccionados']?>"><?=$textos['proyini_perfiles_pre']?></a></li><?endif?>
												<?if(!empty($iniciativa['link_ganadores'])):?><li><a href="<?=$iniciativa['link_ganadores']?>"><?=$textos['proyini_ganadores']?></a></li><?endif?> 
											   	<li><a href="<?=base_url().'iniciativas'?>"><i class="fa fa-sign-in" aria-hidden="true"></i> <?=$textos['proyini_plataforma']?></a></li>
										   </ul>
									   </nav>
                                        <div class="share ">
											<span class="shareTitle vertical-text"><?=$textos['compartir']?></span>
											<a href="https://twitter.com/intent/tweet?text=<?=$iniciativa['titulo']?>%20<?=LINK_PROYECTOS.'iniciativa/'.$iniciativa['idiniciativa'].'/'.toURLFriendly($iniciativa['titulo']).'/'.$lang?>" target="_blank" ><i class="fa fa-twitter" aria-hidden="true"></i></a>
											<a href="https://www.facebook.com/sharer/sharer.php?u=<?=LINK_PROYECTOS.'iniciativa/'.$iniciativa['idiniciativa'].'/'.toURLFriendly($iniciativa['titulo']).'/'.$lang?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
											<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?=LINK_PROYECTOS.'iniciativa/'.$iniciativa['idiniciativa'].'/'.toURLFriendly($iniciativa['titulo']).'/'.$lang?>&title=<?=$iniciativa['titulo']?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
											
										</div>
                                    </div>
                                </div>
                            </div>
                            
                                                          
                        </div>
                    </div>
                </div>
<!-- SI HAY MAS DE UNA CONVOCATORIA ABIERTA -->
                <!--<div class="encursoBox" id="encurso">
					<div class="box">
						<h3 class="linetop">Iniciativas en curso</h3>
						<div class="grid-equalHeight">
							<div class="col-4_md-12">
								<div class="iniciativaBox open">
									<div class="iniciativaInfo">
										<div class="category">
											CONVOCATORIA 2019 - PRODUCTIVIDAD
										</div>
										<h4>
											Aumento de la productividad en la agricultura familiar con sostenibilidad, inclusión, y rentabilidad
										</h4>
										<div class="state">
											Estado: <span>Abierto</span>
										</div>
									</div>
									<div class="actions">
										<div class="grid-middle-noBottom">
											<div class="col-5">
												<a href="#">Conocer más</a>
											</div>
											<div class="col-7 alignRight">
												<a href="#" class="btn white">Cargar perfil</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-4_md-12">
								<div class="iniciativaBox preselection">
									<div class="iniciativaInfo">
										<div class="category">
											CONVOCATORIA 2019 - PRODUCTIVIDAD
										</div>
										<h4>
											Aumento de la productividad en la agricultura familiar con sostenibilidad, inclusión, y rentabilidad
										</h4>
										<div class="state">
											Estado: <span>Pre-selección</span>
										</div>
									</div>
									<div class="actions">
										<div class="grid-middle-noBottom">
											<div class="col-5">
												<a href="#">Conocer más</a>
											</div>
											<div class="col-7 alignRight">
												<a href="#" class="btn white">Ver perfil</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-4_md-12">
								<div class="iniciativaBox selection">
									<div class="iniciativaInfo">
										<div class="category">
											CONVOCATORIA 2019 - PRODUCTIVIDAD
										</div>
										<h4>
											Aumento de la productividad en la agricultura familiar con sostenibilidad, inclusión, y rentabilidad
										</h4>
										<div class="state">
											Estado: <span>Propuesta</span>
										</div>
									</div>
									<div class="actions">
										<div class="grid-middle-noBottom">
											<div class="col-5">
												<a href="#">Conocer más</a>
											</div>
											<div class="col-7 alignRight">
												<a href="#" class="btn white">Editar proyecto</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>-->
                
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
	
    <script>
        var swiper = new Swiper('.news', {
		  slidesPerView: 3,
		  slidesPerColumn: 2,
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
		  slidesPerView: 2,
		  slidesPerColumn: 3,
		  spaceBetween: 30,
		    navigation: {
				nextEl: '.docs-button-next',
				prevEl: '.docs-button-prev',
			},
			breakpoints: {
				640: {
				slidesPerView: 1,
				spaceBetween: 15,
				},
				768: {
				slidesPerView: 2,
				spaceBetween: 20,
				},
				1024: {
				slidesPerView: 2,
				spaceBetween: 30,
				},
			}
        });
    </script>
	<?php $this->load->view('target_blank'); ?>
</body>
</html>