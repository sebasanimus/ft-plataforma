<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
	<title>Alianzas FONTAGRO</title>
	<meta name="description" content="Alianzas Fontagro">
	<link rel="shortcut icon" href="<?=base_url()?>favicon.ico">
    <meta name="author" content="ANIMUS">

	<link href="<?=base_url()?>css/proyecto/style.css" rel="stylesheet">
	<link href="<?=base_url()?>css/webstory/swiper.min.css" rel="stylesheet">
	<script src="<?=base_url()?>js/webstory/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<link href="<?=base_url()?>css/webstory/jvectormap.css" rel="stylesheet">

	<!-- CHARTS https://gionkunz.github.io/chartist-js/index.html -->
	<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>


	
	<style>
	.ct-label{
		font-size:15px;
	}
	.chartValues{
		padding:3.2rem 50px;
		text-align:center
	}
	@media (max-width: 1480px){
		.chartValues{
			padding:3.2rem
		}
	}
	.chartValues .valueLabel{
		display:inline-block;
		padding:0 3.2rem 2px 0;
		font-size:1.4rem;
	}
	.chartValues .valueLabel .color{
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
	.chartValues .valueLabel strong{
		display:inline-block;
		margin-left:10px;
		font-family:'gotham-Bold'
	}
	</style>
</head>
<body>
	<div class="container">		
		<div class="content-wrap" id="container">
			<div class="content">			
               
                <div class="projectContent">                    
						<?
						foreach($tipo_institucion as $tipo):
							if(empty($tipo['organismos'])) continue;
							?>
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
                                    <h3 class="underline">
										<?=$tipo['label']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12">
                                    <div class="objectivosImg">
										<?
										$repetido=Array('FONTAGRO'=>1); //no muestra a fontagro
										foreach($tipo['organismos'] as $org):											
											if($tipo['value']<=2 && !empty($repetido[$org['nombre']])){
												continue;
											}
											$repetido[$org['nombre']] = 1;
										?>
											<a href="<?=empty($org['link'])? '#': $org['link']?>" target="_blank">
												<img src="<?=base_url()?>uploads/organismos/<?=$org['logo']?>" alt="<?=$org['nombre']?>" title="<?=$org['nombre']?>">	
											</a>									
										<?endforeach?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?endforeach?>
                </div>
				

				<?
				$labels = '';
				$values = '';
				$spans = '';
				$colores = Array('#d70206','#f05b4f','#f4c63d','#d17905','#453d3f','#59922b','#0544d3','#6b0392','#f05b4f','#dda458');
				$i=0;
				foreach($estadisticas as $est):
					$labels .= '"'.$est['nombre'].'",';
					$values .= $est['total'].',';
					$spans .= '<span class="valueLabel"><span class="color" style="background-color:'.$colores[$i].'"></span>'.$est['nombre'].' <strong>'.round(100*$est['total']/$total).' %</strong></span>';
					$i++;
				endforeach;
				?>
                <div class="projectContent">
                    <div class="box">                        
                        <div class="contentBlock">
                            <div class="grid">
                                <div class="col-3_sm-12">
                                    <h3 class="underline">
									<?=$textos['socios']?>
                                    </h3>
                                </div>
                                <div class="col-9_sm-12">
                                    <div class="graphicBox" style="max-height: 700px;">
                                        <div class="grid">
                                            <div class="col-1">
                                                <div class="icon">
                                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col-11">
                                                <div class="graphicContent">
													<h5><?=$textos['aportes']?></h5>
													<div style="height: 410px;" class="ct-chart ct-perfect-fourth"></div>
													<div class="chartValues">
														<?=$spans?>
													</div>													
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				
			</div>
		</div>
    </div>
    <script src="<?=base_url()?>js/proyecto/jquery-3.4.1.min.js"></script>
	<script src="<?=base_url()?>js/webstory/classie.js"></script>


    <script>
        

		$(document).ready(function() {

			var data = {
				series: [<?=$values?>]
			};

			var sum = function(a, b) { return a + b };
			var labels = [<?=$labels?>];
			new Chartist.Pie('.ct-chart', data, {
				labelInterpolationFnc: function(value,idx) {
					return labels[idx] + ' ' +Math.round(value / data.series.reduce(sum) * 100) + '%';
				},
				showLabel: false
			}, [
				['screen and (min-width: 640px)', {
					chartPadding: 30,
					labelOffset: 100,
					labelDirection: 'explode',
				}],
				['screen and (min-width: 1024px)', {
					labelOffset: 80,
					chartPadding: 20
				}]
			]);		

		});
    </script>
</body>
</html>
