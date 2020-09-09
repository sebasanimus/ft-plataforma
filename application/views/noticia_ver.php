<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
    <meta name="author" content="ANIMUS">

	<link href="<?=base_url()?>css/proyecto/style.css" rel="stylesheet">
	<link href="<?=base_url()?>css/webstory/swiper.min.css" rel="stylesheet">

    <script src="<?=base_url()?>js/webstory/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

	<title><?=$noticia['titulo']?></title>
	<meta name="description" content="<?=$noticia['bajada']?>">
	<link rel="shortcut icon" href="<?=base_url()?>favicon.ico">


	<!-- Parallax -->
	<script type="text/javascript" src="<?=base_url()?>js/webstory/ScrollMagic.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/TweenMax.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/webstory/animation.gsap.js"></script>

	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@FONTAGROdigital">
	<meta name="twitter:title" content="<?=$noticia['titulo']?>">
	<meta name="twitter:description" content="<?=$noticia['bajada']?>">
	<meta name="twitter:creator" content="@FONTAGROdigital">
	<meta name="twitter:image" content="<?=base_url()?>uploads/noticias/<?=$noticia['foto']?>">

	<!-- Open Graph data -->
	<meta property="og:title" content="<?=$noticia['titulo']?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/<?=$lang?>/<?=$noticia['url']?>" />
	<meta property="og:image" content="<?=base_url()?>uploads/noticias/<?=$noticia['foto']?>" />
	<meta property="og:description" content="<?=$noticia['bajada']?>" />

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
						<a href="#" class="more"><?=$textos['conocer_mas']?></a>
					</p>
				</div>
			</nav>
		</div>
		<div class="content-wrap" id="container">
			<div class="content">
				<!-- HEADER -->
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
										<a href="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/es/<?=$noticia['url']?>" class="<?=($lang=='es')? 'active' : '' ?>">Es</a>
										<a href="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/en/<?=$noticia['url']?>" class="<?=($lang=='en')? 'active' : '' ?>">En</a>
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
										<li><a href="#encurso"><?=$textos['iniciativas_en_curso']?></a></li>
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
								<h1><?=$noticia['titulo']?></h1>
							</div>   
							<?if($noticia['idtiponoticia']==2):?>
							<div class="tags">
								<a href="#" class="tag"><i class="fa fa-tag" aria-hidden="true"></i> Blog</a> 
							</div>   
							<?endif?>                         
                        </div>                    
                    </div>
                </div>
                <div class="newsContent">
                    <div class="box">
                        <div class="contentTxt">
                            <div class="grid">
                                
                                <div class="col-9_lg-9_md-9_sm-12">
                                    <div class="entry-content">
                                        <small class="date"><?=$lang=='es'? 'Publicado el ':'Published at: '?> <?=fromYYYYMMDDtoReadable($noticia['publicada'], $lang)?></small>
                                        <p><?=$noticia['bajada']?></p>
                                        <img src="<?=base_url()?>uploads/noticias/<?=$noticia['foto']?>" alt="">
                                        <?=$noticia['contenido']?>
                                    </div>  
                                </div>
                                <div class="col-3_lg-3_md-3_sm-12">
                                    <div class="columnBox">
                                        <div class="projectFather">
											<?=$textos['el_proyecto']?>: <a href="<?=(!empty($propuesta['web_publicado']) && !empty($propuesta['web_url']))? LINK_PROYECTOS.$propuesta['web_url'].'/'.$lang : '#'?>"> <?=$propuesta['titulo_simple']?></a>
                                        </div>
                                        <div class="tags">
											<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?estrategica=<?=$propuesta['linea_estrategica']?>" class="tag small"><i class="fa fa-tag" aria-hidden="true"></i> <?=$propuesta['estrategica']?></a> 
											<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?innovacion=<?=$propuesta['tipo_innovacion']?>" class="tag small"><i class="fa fa-tag" aria-hidden="true"></i> <?=$propuesta['innovacion']?></a> 
											<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?investigacion=<?=$propuesta['tipo_investigacion']?>" class="tag small"><i class="fa fa-tag" aria-hidden="true"></i> <?=$propuesta['investigacion']?></a> 
											<a href="<?=LINK_PROYECTOS?>buscar/<?=$lang?>?solucion=<?=$propuesta['solucion_tecnologica']?>" class="tag small"><i class="fa fa-tag" aria-hidden="true"></i> <?=$propuesta['solucion']?></a>
                                        </div>
                                        <div class="share ">
											<span class="shareTitle vertical-text"><?=$textos['compartir']?></span>
											<a href="https://twitter.com/intent/tweet?text=<?=$noticia['titulo']?>%20<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/<?=$lang?>/<?=$noticia['url']?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                        	<a href="https://www.facebook.com/sharer/sharer.php?u=<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/<?=$lang?>/<?=$noticia['url']?>" target="_blank"><i class="fa fa-facebook" target="_blank"></i></a>
                                        	<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/<?=$lang?>/<?=$noticia['url']?>&title=<?=$noticia['titulo']?>" target="_blank"><i class="fa fa-linkedin"></i></a>
										</div>
                                    </div>
                                </div>
                            </div>
                            
                                                          
                        </div>
                    </div>
                </div>

				
                <div class="novedadesBox novedadesProject" id="news">
					<div class="box">
                        <h3 class="linetop"><?=$textos['novedades_proyecto']?></h3>
                        <h5><a href="<?=LINK_PROYECTOS?><?=$propuesta['web_url']?>/<?=$lang?>"><?=$propuesta['titulo_simple']?></a> </h5>
                        <!-- Swiper -->
						<div class="swiper-container news">
							<div class="swiper-wrapper">
								<?foreach($noticias as $news):?>
								<div class="swiper-slide">
									<div class="novedad">
                                        <div class="grid">
                                            <div class="col-3_md-12_sm-3">
                                                <a href="<?=base_url()?>noticias/<?=$news['idnoticia']?>/<?=$lang?>/<?=$news['url']?>" class="imgNews bgCover" style="background-image: url(<?=base_url()?>uploads/noticias/400_<?=$news['foto']?>);"></a>
                                            </div>
                                            <div class="col-9_md-12_sm-9">
                                                <h5>
                                                    <a href="<?=base_url()?>noticias/<?=$news['idnoticia']?>/<?=$lang?>/<?=$news['url']?>"><?=$news['titulo']?></a>
                                                </h5>
                                                <div class="date"><?=fromYYYYMMDDtoDDMMYYY($news['publicada'])?></div>
                                            </div>
                                        </div>
                                    </div>
								</div>
								<?endforeach?>			
							</div>
						</div>
						<div class="buttons alignRight">
							 <!-- Add Arrows -->
							<a href="#" class="news-button-prev btn"><?=$textos['proyecto_anterior']?></a>
							<a href="#" class="news-button-next btn"><?=$textos['proyecto_siguiente']?></a>
						</div>
                    </div>
                </div>

				<?if(!empty($webstory)):?>               
				<div class="webstoryBox alignCenter noMargin" id="webstory">
                    <div class="parallaxParent">
						<div id="webstoryParallax" class="webstoryParallax bgCover" style="background-image: url(<?=base_url()?>uploads/webstories/<?=$webstory['foto_principal']?>););"></div>
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
	</div><!-- /content-wrap -->
</div><!-- /container -->

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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