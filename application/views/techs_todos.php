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
	<title>FONTAGRO Techs</title>
	
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
					<?foreach($techies as $otras):?>
						<div class="col-3_lg-4_md-4_sm-6_xs-12">
							<a target="_blank" href="<?=base_url()?>exportartech/verPDF/<?=$otras['idtech']?>/<?=$lang?>" class="historia" style="background-image: url(<?=base_url()?>uploads/webstories/<?=$otras['foto_principal']?>);">
								<h4>
									<?=$otras['tech_titulo']?>
								</h4>
							</a>
						</div>
					<?endforeach?>	
					
						
		</div>
	</div>
</body>
</html>
