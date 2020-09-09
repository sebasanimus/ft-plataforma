<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<title>FONTAGRO TECH</title>

	<link href="<?=base_url()?>pdf_resources/styleTech.css" rel="stylesheet">
	<link href="<?=base_url()?>pdf_resources/gridlex.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="firstPage">
			<div class="headerMainBox">
				<div class="grid-noGutter-equalHeight-bottom mainTitleBox">
					<div class="col-6">
						<div class="txtTitleBox">
							<div class="tagTitle">
								<strong>Fontagro</strong>tech
							</div>
							<div class="txtTitle">
								<h1><?=$webstory['tech_titulo']?></h1>
								<div class="countries">
									<?
									$firstPais=true;
									foreach($paises as $pais){
										if(!$firstPais) echo ' / ';
										$firstPais = false;
										echo $pais['nombre'];										
									}									
									?>
								</div>
							</div>
						</div>									
					</div>
					<div class="col-6 bgImg" style="background-image: url(<?=base_url()?>uploads/webstories/<?=$webstory['foto_principal']?>)">
						<div class="bgImgShadow">

						</div>
					</div>
				</div>
			</div>
			<div class="odsBox">
				<div class="grid-noBottom-middle">
					<div class="col-6">
						<a href="http://webstories.fontagro.org/<?=$webstory['url']?>" target="_blank" class="moreinfo">
							<div class="grid-middle-noGutter">
								<div class="col-1">
										<img src="<?=base_url()?>pdf_resources/images/more.png" alt="">
								</div>
								<div class="col-11">
										<!--webstories.fontagro.org/<?=$webstory['url']?>-->
										Webstory
								</div>
							</div>
						</a>
					</div>
					
					<div class="col-6">
						<div class="grid-9-middle-noGutter ods">
							<?foreach($badges as $badge):?>
								<div class="col">
									<img src="<?=base_url()?>uploads/badges/<?=$badge['foto']?>" alt="<?=$badge['nombre']?>">
								</div>
							<?endforeach?>				
						</div>
					</div>
					
				</div>
			</div>
			<div class="contentMainBox">
				<div class="grid">
					<div class="col-6">
						<div class="blockBox color1">
							<div class="grid">
								<div class="col-3">
									<div class="iconBox">
										<img src="<?=base_url()?>pdf_resources/images/icon01.png" alt="">
									</div>
								</div>
								<div class="col-9">
									<div class="blockTxt">
										<h4>
											<?=$textos['solucion']?>
										</h4>
										<p class="coltxt">
											<?=$webstory['tech_solucion']?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="blockBox color2">
							<div class="grid">
								<div class="col-3">
									<div class="iconBox">
										<img src="<?=base_url()?>pdf_resources/images/icon02.png" alt="">
									</div>
								</div>
								<div class="col-9">
									<div class="blockTxt">
										<h4>
											<?=$textos['tech_descripcion']?>
										</h4>
										<p class="coltxt">
											<?=$webstory['tech_descripcion']?> 
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="blockBox color3">
							<div class="grid">
								<div class="col-3">
									<div class="iconBox">
										<img src="<?=base_url()?>pdf_resources/images/icon03.png" alt="">
									</div>
								</div>
								<div class="col-9">
									<div class="blockTxt">
										<h4>
											<?=$textos['impactos_resultados']?>
										</h4>
										
											<?=$webstory['tech_resultados']?> 
										
										<!--<ul>
											<li>10 técnicos en el diseño y análisis de línea base.</li>
											<li>Aumento en la eficiencia del uso del agua del 17% y 52% en Panamá y Nicaragua. </li>
										</ul>-->
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="indicadoresBox">
							<div class="grid-equalHeight">
								<?foreach($indicadores as $ind):?>
								<div class="col-6">
									<div class="indBox">
										<div class="numberInd">
										<?=$ind['prefijo']?><?=$ind['valor']?> <?=$ind['unidad']?>
										</div>
										<div class="txtInd">
											<?=$ind['nombre']?>
										</div>
									</div>
								</div>
								<?endforeach?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="homeFooter">
				<div class="grid-noBottom-middle h100">
					
					<div class="col-9">
						<div class="grid-6-middle-noBottom ods">
							<?foreach($donantes as $dona):?>
								<?if($dona['nombre']!='BID'):?>
								<div class="col">
									<img src="<?=base_url()?>uploads/organismos/<?=$dona['logo']?>" alt="<?=$dona['nombre']?>">
								</div>
								<?endif?>
							<?endforeach?>
							
						</div>
					</div>
					<div class="col-3 fontagro" >
						<img src="<?=base_url()?>pdf_resources/images/bid.png" alt="BID">
					</div>
				</div>
			</div>
				
		</div>
		<div class="pagebreak"> </div>
		<div class="intPage">
			<div class="headerIntBox">
				<div class="grid-noGutter-equalHeight-bottom mainTitleBox">
					<div class="col-8">
						<div class="txtTitleBox">
							<div class="tagTitle">
								<strong>Fontagro</strong>tech
							</div>
							<div class="txtTitle">
								<h2><?=$fontagro['sobreTitulo']?></h2>
								<p><?=$fontagro['sobre']?></p>
							</div>
						</div>
							
					</div>
					<div class="col-4 bgImg" style="background-image: url(<?=base_url()?>pdf_resources/images/header.jpg)">
						<div class="bgImgShadow">

						</div>
					</div>
				</div>
			</div>


			<div class="colsBox">
				<div class="grid-equalHeight">
					<div class="col-4">
						<div class="titleColBox"><h3><?=$fontagro['origenTitulo']?></h3></div>
					</div>
					<div class="col-4">
						<div class="titleColBox"><h3><?=$fontagro['participacionTitulo']?></h3></div>
					</div>
					<div class="col-4">
						<div class="titleColBox"><h3><?=$fontagro['enCifrasTitulo']?></h3></div>
					</div>
				</div>
				<div class="grid">
					<div class="col-4">
						<div class="colContent">
							<img src="https://www.fontagro.org/new/exportar/torta/es">
							<div class="labelsBox">
								<div class="grid-noGutter">
									<div class="col-1">
										<img src="<?=base_url()?>application/controllers/assets/images/pieColor01.png" width="10px" />
									</div>
									<div class="col-11">
										<span class="labeltxt"><strong><?=$fontagro['aporteContrapartida']?></strong><?=number_format($db['aporte_contrapartida'],0,",",".")?></span>
									</div>
									<div class="col-1">
										<img src="<?=base_url()?>application/controllers/assets/images/pieColor02.png" width="10px" />
									</div>
									<div class="col-11">
										<span class="labeltxt"><strong>FONTAGRO</strong><?=number_format($db['aporte_fontagro'],0,",",".")?></span>
									</div>
									<div class="col-1">
										<img src="<?=base_url()?>application/controllers/assets/images/pieColor03.png" width="10px" />
									</div>
									<div class="col-11">
										<span class="labeltxt"><strong><?=$fontagro['BID']?></strong><?=number_format($db['aporte_bid'],0,",",".")?></span>
									</div>
									<div class="col-1">
										<img src="<?=base_url()?>application/controllers/assets/images/pieColor04.png" width="10px" />
									</div>
									<div class="col-11">
										<span class="labeltxt"><strong><?=$fontagro['otrasAgencias']?></strong><?=number_format($db['otras'],0,",",".")?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="colContent">
							<div class="labelsBox">
								<div class="grid-noGutter">
									<div class="col-1">
										<img src="<?=base_url()?>pdf_resources/images/dotColor01.png" width="10px" />
									</div>
									<div class="col-5">
										<span class="labeltxt"><strong><?=$fontagro['miembro']?></strong></span>
									</div>
									<div class="col-1">
										<img src="<?=base_url()?>pdf_resources/images/dotColor02.png" width="10px" />
									</div>
									<div class="col-5">
										<span class="labeltxt"><strong><?=$fontagro['lider']?></strong></span>
									</div>
									
								</div>
							</div>
							<img src="<?=base_url()?>exportar/barras/es">
						</div>
					</div>
					<div class="col-4">
						<div class="colContent">
							<div class="cifraBox color01">
								<div class="grid-middle-noBottom">
									<div class="col-4">
										<div class="numBox"><strong><?=$valores['proyectosAprobados']?></strong>	</div>
									</div>
									<div class="col-8">
										<div class="descTxt"><?=$fontagro['proyectosAprobados']?></div>
									</div>
								</div>
							</div>
							<div class="cifraBox color02">
								<div class="grid-middle-noBottom">
									<div class="col-4">
										<div class="numBox"><strong><?=$valores['montoTotal']?></strong> millones	</div>
									</div>
									<div class="col-8">
										<div class="descTxt"><?=$fontagro['montoTotal']?></div>
									</div>
								</div>
							</div>
							<div class="cifraBox color03">
								<div class="grid-middle-noBottom">
									<div class="col-4">
										<div class="numBox"><strong><?=$valores['otrosTotal']?></strong> millones	</div>
									</div>
									<div class="col-8">
										<div class="descTxt"><?=$fontagro['otrosInvercionistas']?></div>
									</div>
								</div>
							</div>
							<div class="cifraBox color04">
								<div class="grid-middle-noBottom">
									<div class="col-4">
										<div class="numBox"><strong><?=$valores['paises']?></strong></div>
									</div>
									<div class="col-8">
										<div class="descTxt"><?=$fontagro['paisesBeneficiados']?></div>
									</div>
								</div>
							</div>
							<div class="cifraBox color05">
								<div class="grid-middle-noBottom">
									<div class="col-4">
										<div class="numBox"><strong><?=$valores['tecnologias_generadas']?></strong></div>
									</div>
									<div class="col-8">
										<div class="descTxt"><?=$fontagro['tecnologiasGeneradas']?></div>
									</div>
								</div>
							</div>
							<div class="cifrasBoxSmall color06">
								<div class="grid-middle">
									<div class="col-4">
										<div class="numBox"><strong><?=$valores['tecnologias_nuevas']?></strong></div>
									</div>
									<div class="col-8">
										<div class="descTxt"><?=$fontagro['tecnologiasNuevas']?></div>
									</div>
									<div class="col-4">
											<div class="numBox"><strong><?=$valores['tecnologias_relevantes']?></strong></div>
										</div>
										<div class="col-8">
											<div class="descTxt"><?=$fontagro['tecnologiasRelevantes']?></div>
										</div>
								</div>
							</div>
						
						</div>
					</div>
				</div>
			</div>
			<div style="clear:both; width:100%"></div>
			<div class="paisesBox">
				<div class="grid">
					<div class="col-4">
						<div class="titleColBox">
							<h3><?=$fontagro['paisesMiembro']?></h3>
						</div>
					</div>
					<div class="col-8">
						<div class="countriesBox">
							<div class="grid">
								<?foreach($paisesMiembro as $pa):?>
								<div class="col-3">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tbody>
										<tr>
											<td width="30px"><img src="https://www.fontagro.org/new//application/controllers/assets/images/flag-<?=$pa['code']?>.png" width="30px" /></td>
											<td align="left" class="countryTd"><?=$pa['nombre']?></td>
										</tr>
										</tbody>
									</table>
								</div>
								<?endforeach?>
								
							</div>
						</div>
						
					</div>
				</div>
			</div>

			<div class="homeFooter">
				<div class="grid-noBottom-middle h100">
					
					<div class="col-10">
						<div class="grid-6-middle-noBottom ods">
							<!--<div class="col">
								<img src="<?=base_url()?>pdf_resources/images/iica.gif" alt="IICA">
							</div>
							<div class="col">
								<img src="<?=base_url()?>pdf_resources/images/bid.png" alt="BID">
							</div>-->
							<div class="col"></div>
							<div class="col"></div>
							<div class="col"></div>
							<div class="col"></div>
							
						</div>
					</div>
					<div class="col-2 fontagro" >
						<img src="<?=base_url()?>pdf_resources/images/fontagro.png" alt="Fontagro">
					</div>
				</div>
			</div>	
		</div>

	</body>
</html>	