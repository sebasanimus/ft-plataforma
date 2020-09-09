<!DOCTYPE html>
<html lang="es">
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
    <link href="<?=base_url()?>local/select2.min.css" rel="stylesheet">

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
	<meta property="og:url" content="<?=LINK_PROYECTOS?>buscar/<?=$lang?>" />
	<meta property="og:image" content="<?=base_url()?>img/prod.jpg" />
	<meta property="og:description" content="<?=$textos['proyhome_descripcion']?>" />

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
				
				
				<div class="searchProyect searchInt" id="search">
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
														<input type="text" id="keyword" placeholder="<?=$textos['proyhome_pal_clave']?>" value="<?=$keyword?>">
													</div>
												</div>
												<div class="col-4_sm-6">
													<div class="inputBox">
														<select id="anio" class="select-tipo">
															<option></option>
															<?foreach($anios as $ti):
																if($anio==$ti['anio']) $criterio[] = $ti['anio'];
																?>
																<option <?=($anio==$ti['anio'])?'selected':''?> value="<?=$ti['anio']?>"><?=$ti['anio']?></option>
															<?endforeach?>
														</select>
													</div>
												</div>
												<div class="col-4_sm-6">
													<div class="inputBox">
														<select id="estado" class="select-estado">
															<option></option>
															<?foreach($estados as $ti):
																if($estado==$ti['value']) $criterio[] = $ti['label'];
																?>
																<option <?=($estado==$ti['value'])?'selected':''?> value="<?=$ti['value']?>"><?=$ti['label']?></option>
															<?endforeach?>
														</select>
													</div>
												</div>
												<div class="col-4_sm-6">
													<div class="inputBox">
														<select id="tema" class="select-temas" multiple>
															<option></option>
															<optgroup label="Linea estratégica">
																<?foreach($estrategicas as $ti):
																	if($estrategica==$ti['value']) $criterio[] = $ti['label'];
																	?>
																	<option groupid="1" <?=($estrategica==$ti['value'])?'selected':''?> value="est_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Innovacion">
																<?foreach($innovaciones as $ti):
																	if($innovacion==$ti['value']) $criterio[] = $ti['label'];
																	?>
																	<option groupid="2" <?=($innovacion==$ti['value'])?'selected':''?> value="inn_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Investigacion">
																<?foreach($investigaciones as $ti):
																	if($investigacion==$ti['value']) $criterio[] = $ti['label'];
																	?>
																	<option groupid="3" <?=($investigacion==$ti['value'])?'selected':''?> value="inv_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Solución tecnológica">
																<?foreach($soluciones as $ti):
																	if($solucion==$ti['value']) $criterio[] = $ti['label'];
																	?>
																	<option groupid="4" <?=($solucion==$ti['value'])?'selected':''?> value="sol_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Sector productivo">
																<?foreach($sectores as $ti):
																	if(!empty($sector[$ti['value']])) $criterio[] = $ti['label'];
																	?>
																	<option groupid="5" <?=(!empty($sector[$ti['value']]))?'selected':''?> value="sec_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Subsector">
																<?foreach($subsectores as $ti):
																	if(!empty($subsector[$ti['value']])) $criterio[] = $ti['label'];
																	?>
																	<option groupid="6" <?=(!empty($subsector[$ti['value']]))?'selected':''?> value="sub_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>
															<optgroup label="Tema">
																<?foreach($temas as $ti):
																	if($tema==$ti['value']) $criterio[] = $ti['label'];
																	?>
																	<option groupid="7" <?=(!empty($tema[$ti['value']]))?'selected':''?> value="tem_<?=$ti['value']?>"><?=$ti['label']?></option>
																<?endforeach?>
															</optgroup>

														  </select>
													</div>
												</div>
												<div class="col-4_sm-6">
													<div class="inputBox">
														<select id="pais" class="select-pais">
															<option></option>															
															<?foreach($paises as $ti):
																	if($pais==$ti['value']) $criterio[] = $ti['label'];
																	?>
																<option <?=($pais==$ti['value'])?'selected':''?> value="<?=$ti['value']?>"><?=$ti['label']?></option>
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
                <div class="searchBlock box">
					<h1 class="animated fadeInDown" id="subtitulo">
					<?=$textos['proybus_encontraron']?> <strong> <?=$total?> <?=$textos['proybus_iniciativas']?></strong> <br><?=$textos['proybus_siguiendo']?>
					</h1>
				</div>
				<div class="listProjects">
					<div class="box">
						<div class="searchListBox">
							<div class="grid">
								<?foreach($propuestas as $pro):
									$link = empty($pro['web_publicado']) || empty($pro['web_url'])? '': LINK_PROYECTOS.$pro['web_url'].'/'.$lang;
									if(empty($link)){
										//if(empty($pro['urlvieja'])){
											$link = 'https://www.fontagro.org/es/resultados/buscador-de-proyectos/';
										/*}else{
											$link = $pro['urlvieja'];
										}*/
									}
									?>							
								<div class="col-6_sm-12">
									<div class="projectBox">
										<span><?=$pro['operacion']?> <?=$pro['anio']?> · <a href="<?=$link?>"><?=$pro['identificador']?></a></span>
										<a href="<?=$link?>" title="<?=$pro['titulo_simple']?>">
											<h4><?=$pro['titulo_completo']?></h4>	
										</a>
										<p><?=substr(strip_tags($pro['web_resumen']),0,400)?><?=strlen($pro['web_resumen'])>400?'...':''?></p>
										<?if($link!='#'):?>
										<a href="<?=$link?>" class="btn main"><?=$textos['proyhome_conocer']?></a>
										<?endif?>
									</div>
								</div>
								<?endforeach?>	
							</div>
							
							<div class="buttons alignRight">
								<span><?=$textos['proybus_pagina']?> <?=($pagina+1)?> <?=$textos['proybus_de']?> <?=ceil($total/10)?> &nbsp;&nbsp;&nbsp;&nbsp;</span>
								<!-- Add Arrows -->
								<?if(empty($pagina)):?>
									<a href="#" class="projects-button-prev btn swiper-button-disabled"><?=$textos['proyecto_anterior']?></a>
								<?else:?>
									<a href="javascript:buscar(<?=($pagina-1)?>)" class="projects-button-prev btn"><?=$textos['proyecto_anterior']?></a>
								<?endif?>
								<?if(($pagina+1)==ceil($total/10)):?>
									<a href="#" class="projects-button-next btn swiper-button-disabled"><?=$textos['proyecto_siguiente']?></a>
								<?else:?>
									<a href="javascript:buscar(<?=($pagina+1)?>)" class="projects-button-next btn"><?=$textos['proyecto_siguiente']?></a>
								<?endif?>

								<!--<a href="#" class="btn secondary">Ver todos</a>-->
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
									$boton = '<a href="#" class="btn white">'.$textos['proyhome_ver'].'</a>';
								}else if($ini['idestadoreal']==3){
									$clase = 'selection';
									$boton = '<a href="#" class="btn white">'.$textos['proyhome_editar'].'</a>';
								}else if($ini['idestadoreal']==4){
									$clase = 'selection';
									$boton = '';
								}
								?>	
							<div class="col-4_md-12">
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


	<!-- Initialize select -->
	<script>
		$(document).ready(function() {
			$('.select-tipo').select2({
				placeholder: "<?=$textos['proyhome_anio']?>",
				allowClear: true
			});
			$('.select-pais').select2({
				placeholder: "<?=$textos['proyhome_pais']?>",
				allowClear: true
			});
			$('.select-temas').select2({
				placeholder: "<?=$textos['proyhome_tema']?>",
				allowClear: false
			});
			$('.select-estado').select2({
				placeholder: "<?=$textos['proyhome_estado']?>",
				allowClear: true
			});

			 //Select2 Event handler for selecting an item
			$('.select-temas').on("select2:selecting", function(evt, f, g) {
				disableSel2Group(evt, this, true);
			});

			// Select2 Event handler for unselecting an item
			$('.select-temas').on("select2:unselecting", function(evt) {
				disableSel2Group(evt, this, false);
			});

			$('#keyword').keypress(function(e) {
				// Enter pressed?
				if(e.which == 10 || e.which == 13) {
					buscar(0);
				}
			});

			<?if(!empty($criterio)):
				$textoCriterio = ':<br><small>';
				$first = true;
				foreach($criterio as $cr):
					if(!$first) $textoCriterio .= ', ';
					$first=false;
					$textoCriterio .= $cr;
				endforeach;
				$textoCriterio .= '</small>';
				?>
				$('#subtitulo').append('<?=$textoCriterio?>');
			<?endif?>
		});

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

		function buscar(pagina){
			var keyword = $('#keyword').val();
			//var tipo = $('#tipo').val();
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
	</script>

	 <!-- Initialize Swiper -->
	 <script>
		/*var swiper = new Swiper('.projects', {
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
		});*/
	</script>
	 <?php $this->load->view('target_blank'); ?>
</body>
</html>