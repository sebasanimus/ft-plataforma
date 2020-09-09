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



    <script src="<?=base_url()?>js/webstory/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<title>Webstories</title>
	
	<link rel="shortcut icon" href="<?=base_url()?>favicon.ico">

	<style>
		html, body, .container, .content-wrap{
			overflow: visible;
			height: auto;
		}
		#prefooter {
			padding: 20px 0;
		}
		#prefooter .historias .historia{
			margin: 10px;
			padding: 0;
			min-height: 450px;
		}
		@media (max-width: 80em){
			#prefooter .historias .historia{
				min-height: 420px;
			}
		}
		@media (max-width: 64em){
			#prefooter .historias .historia{
				min-height: 380px;
			}
		}
		@media (max-width: 48em){
			#prefooter .historias .historia{
				min-height: 350px;
			}
		}
		@media (max-width: 36em){
			#prefooter .historias .historia{
				min-height: 300px;
			}
		}
		
	</style>



	<?php $this->load->view('googletag'); ?>
</head>
<body>
	<!-- historias -->
	<div id="prefooter" class="prefooter">
		<div id="historias" class="historias">
			
				<div class="grid-equalHeight-noGutter">
					<?foreach($otrasStories as $otras):?>
						<div class="col-3_lg-4_md-4_sm-6_xs-12">
							<a target="_blank" href="<?=LINK_WEBSTORIES?><?=$otras['url']?>/<?=$lang?>" class="historia" style="background-image: url(<?=base_url()?>uploads/webstories/<?=empty($otras['foto_link'])? $otras['foto'] : $otras['foto_link']; ?>);">
								<h4>
									<?=$otras['titulo']?>
								</h4>
							</a>
						</div>
					<?endforeach?>	
					<div class="col-3_lg-4_md-4_sm-6_xs-12">
						<a target="_blank" href="<?=$lang=='es'?'http://digital.fontagro.org/historias-de-impacto/ayudando-a-dar-forma-al-pitag-de-haiti/':'http://digital.fontagro.org/en/impact-stories/helping-shape-haiti-pitag/'?>" class="historia" style="background-image: url(http://digital.fontagro.org/wp-content/uploads/2019/05/haiti-oblin-tuse-photo-ami-vitale-oxfam.jpg);">
							<h4>
							<?=($lang=='es')? 'Ayudando a dar forma al programa de innovación tecnológica agrícola y agroforestal de Haití (pitag)' : 'HELPING SHAPE HAITI’S AGRICULTURAL AND AGROFORESTRY TECHNOLOGICAL INNOVATION PROGRAM (PITAG)' ?>
							
							</h4>
						</a>
					</div>
					<div class="col-3_lg-4_md-4_sm-6_xs-12">
						<a target="_blank" href="<?=$lang=='es'?'http://digital.fontagro.org/historias-de-impacto/frutales-andinos-colombia/':'http://digital.fontagro.org/en/impact-stories/tropical-fruits-colombia/'?>" class="historia" style="background-image: url(http://digital.fontagro.org/wp-content/uploads/2019/05/header-project-rutales-andinos-min.png);">
							<h4>
							<?=($lang=='es')? 'Hacia una mayor competitividad y valor agregado para la producción de frutas Andinas en Colombia' : 'Increasing competitiveness and adding value to Andean fruits production in Colombia' ?>
							
							</h4>
						</a>
					</div>
					<div class="col-3_lg-4_md-4_sm-6_xs-12">
						<a target="_blank" href="<?=$lang=='es'?'http://digital.fontagro.org/historias-de-impacto/ayudar-a-las-abejas-a-ayudarnos/':'http://digital.fontagro.org/en/impact-stories/helping-bees-help-us/'?>" class="historia" style="background-image: url(http://digital.fontagro.org/wp-content/uploads/2018/11/hombre-apiario.jpg);">
							<h4>
							<?=($lang=='es')? 'La apicultura como herramienta de desarrollo y de sostenibilidad ambiental en América Latina y El Caribe' : 'Apiculture as a driver of development and environmental sustainability in Latin America and the Caribbean' ?>
							
							</h4>
						</a>
					</div>
					<div class="col-3_lg-4_md-4_sm-6_xs-12">
						<a target="_blank" href="<?=$lang=='es'?'http://digital.fontagro.org/casos-exitosos-2015/':'http://digital.fontagro.org/en/successful-cases-2015/'?>" class="historia" style="background-image: url(http://digital.fontagro.org/wp-content/uploads/2019/02/caso4-altiplano-peru.jpg);">
							<h4>
							<?=($lang=='es')? 'Lecciones sobre la adaptación al cambio climático de la agricultura familiar de América Latina y el Caribe.' : 'Lessons from family agriculture on adaptation to climate change in Latin America and the Caribbean' ?>
							
							</h4>
						</a>
					</div>							
				</div>
						
		</div>
	</div>
</body>
</html>
