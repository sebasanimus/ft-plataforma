<!DOCTYPE html>
<html lang="es">
	<head>
		<base href="<?=base_url()?>" >
		<meta charset="utf-8" />
		<title><?=$ista['titulo_simple']?></title>
		<link href="<?=base_url()?>pdf_resources/stylePerfil.css" rel="stylesheet">
		<link href="<?=base_url()?>pdf_resources/gridlex.min.css" rel="stylesheet">
	</head>

  	<body class="">
		<div class="content">
		
				<div class="header">
					<div class="grid">
						<div class="col-6">
							<h5><?=$callista['titulo']?> </h5>
						</div>
						<div class="col-6 alignRight">
							<h5>ID: <?=$propuesta['identificador']?></h5>
						</div>
					</div>
					<h1 class="title"><?=$ista['titulo_simple']?></h1>
					<h6 class="category"><?=$callista['titulo']?>: <?=$callista['descripcion']?></h6>
				</div>
				
						<div class="tab-content">
							<div class="tab-pane active" id="link0">
								<div class="contpaso paso0">									              
										<div class="card resumen">											
											<div class="card-body ficha">
												<div class="card-header card-header-text">
													<div class="card-text">
														<h4 class="card-title">Info General</h4>
													</div>
												</div>
												
												<div class="grid-noBottom">
													<div class="col-12">
														<div class="grid-noBottom">
														<?foreach($usuarios as $usuario):?>
															<div class="col-4">
																<strong>Investigador:</strong>
															</div>
															<div class="col-8">
																<label class="form-control"><?=$usuario['nombre']?> - <?=$usuario['email']?> - <?=$usuario['institucion']?> - <?=$usuario['posicion']?> </label>
															</div>
														<?endforeach?>
														</div>													
													</div>											
												</div>
												
											</div>
										</div>									
								</div><!-- paso0 -->
							</div>

							<div class="tab-pane" id="link01">
								<div class="contpaso paso1">
									<div class="card ">
										<div class="card-header card-header-text">
											<div class="card-text">
												<h4 class="card-title"><?=$textos['ista_paso_1']?></h4>
											</div>
										</div>
										<div class="card-body ">
											<div class="grid">
												<div class="col-4"><strong><?=$textos['ista_investigador']?></strong> </div>
												<div class="col-8"><?=$ista['investigador']?></div>
											
												<div class="col-4"><strong><?=$textos['ista_objetivo']?></strong> </div>
												<div class="col-8"><?=$ista['objetivo']?></div>
											</div>
										</div>
									</div>									
								</div><!-- grid paso1 -->
							</div>

							<div class="tab-pane" id="link02">
								<div class="contpaso paso2">								
									<div class="card ">
										<div class="card-header card-header-text">
											<div class="card-text">
												<h4 class="card-title"><?=$textos['ista_paso_2']?></h4>
											</div>
										</div>
										<div class="card-body ">
											<div class="grid">
												<div class="col-4"><strong><?=$textos['ista_resumen_ejecutivo']?></strong> </div>
												<div class="col-8"><?=$ista['resumen_ejecutivo']?></div>
											
												<div class="col-4"><strong><?=$textos['ista_resultados']?></strong> </div>
												<div class="col-8"><?=$ista['resultados']?></div>
											
												<div class="col-4"><strong><?=$textos['ista_productos']?></strong> </div>
												<div class="col-8"><?=$ista['productos']?></div>
											</div>
										</div>
									</div>
								</div><!-- grid paso2 -->
							</div>

							<div class="tab-pane" id="link03">		
								<div class="contpaso paso3">
									<div class="card ">
										<div class="card-header card-header-text">
											<div class="card-text">
												<h4 class="card-title"><?=$textos['ista_paso_3']?></h4>
											</div>
										</div>
										<div class="card-body ">
											<div class="grid">
												<div class="col-4"><strong><?=$textos['ista_hallazgos']?></strong> </div>
												<div class="col-8"><?=$ista['hallazgos']?></div>
											
												<div class="col-4"><strong><?=$textos['ista_innovaciones']?></strong> </div>
												<div class="col-8"><?=$ista['innovaciones']?></div>
											</div>
										</div>
									</div> 									
								</div><!-- grid paso3 -->
							</div>

							<div class="tab-pane" id="link04">								
								<div class="contpaso paso4">
									    
									<div class="card ">
										<div class="card-header card-header-text">
											<div class="card-text">
												<h4 class="card-title"><?=$textos['ista_paso_4']?></h4>
											</div>
										</div>
										<div class="card-body ">
											<div class="grid">
												<div class="col-4"><strong><?=$textos['ista_historias']?></strong> </div>
												<div class="col-8"><?=$ista['historias']?></div>
											
												<div class="col-4"><strong><?=$textos['ista_oportunidades']?></strong> </div>
												<div class="col-8"><?=$ista['oportunidades']?></div>
											
											</div>
										</div>
									</div>
									
								</div><!-- grid paso4 -->
							</div>

							<div class="tab-pane" id="link05">
								<div class="contpaso paso5">									           
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['ista_paso_5']?></h4>
												</div>
											</div>
											<div class="card-body ">
												<div class="grid">
													<div class="col-4"><strong><?=$textos['ista_articulacion']?></strong> </div>
													<div class="col-8"><?=$ista['articulacion']?></div>
												
													<div class="col-4"><strong><?=$textos['ista_gestion']?></strong> </div>
													<div class="col-8"><?=$ista['gestion']?></div>
												</div>
											</div>
										</div>							
								</div><!-- grid paso5 -->
							</div>							
						</div>
		</div><!-- end content -->
	</body>
</html>
