<!DOCTYPE html>
<html lang="es">
	<head>
		<base href="<?=base_url()?>" >
		<meta charset="utf-8" />
		<title><?=$perfil['titulo_corto']?></title>
		<link href="<?=base_url()?>pdf_resources/stylePerfil.css" rel="stylesheet">
		<link href="<?=base_url()?>pdf_resources/gridlex.min.css" rel="stylesheet">
	</head>

  	<body class="">
		<div class="content">
		
				<div class="header">
					<div class="grid">
						<div class="col-6">
							<h5><?=$iniciativa['titulo']?> </h5>
						</div>
						<div class="col-6 alignRight">
							<h5>ID: <?=$perfil['idperfil']?></h5>
						</div>
					</div>
					<h1 class="title"><?=$perfil['titulo_corto']?></h1>
					<h6 class="category"><?=$iniciativa['titulo']?>: <?=$iniciativa['descripcion']?></h6>
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
													<div class="col-6">
														<div class="grid-noBottom">
															<div class="col-4">
																<strong>Nombre:</strong>
															</div>
															<div class="col-8">
																<label class="form-control"><?=$usuario['nombre']?></label>
															</div>
														</div>

														<div class="grid-noBottom">
															<div class="col-4">
																<strong>Email:</strong>
															</div>
															<div class="col-8">
																<label class="form-control"><?=$usuario['email']?></label>
															</div>
														</div>

														
													</div>
													<div class="col-6">
														<div class="grid-noBottom">
															<div class="col-4">
																<strong><?=$textos['institucion']?>:</strong>
															</div>
															<div class="col-8">
																<label class="form-control"><?=$usuario['institucion']?></label>
															</div>
														</div>
														<div class="grid-noBottom">
															<div class="col-4">
																<strong><?=$textos['posicion']?>:</strong>
															</div>
															<div class="col-8">
																<label class="form-control"><?=$usuario['posicion']?></label>
															</div>
														</div>

														<!--<div class="grid-noBottom">
															<div class="col-4">
																<strong>Porcentaje completo:</strong>
															</div>
															<div class="col-8">
																<label class="form-control"><?=$perfil['porcentaje']?> %</label>
															</div>
														</div>

														<div class="grid-noBottom">
															<div class="col-4">
																<strong>Última vez guardado:</strong>
															</div>
															<div class="col-8">
																<label class="form-control"><?=fromYYYYMMDDtoDDMMYYY($perfil['actualizado'],false)?></label>
															</div>
														</div>-->
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
											<h4 class="card-title"><?=$textos['paso_1']?></h4>
											</div>
										</div>
										<div class="card-body ">
											<div class="grid-noBottom">
												<div class="col-12">
													<div class="grid-noBottom">
														<div class="col-2"><strong><?=$textos['titulo']?></strong> </div>
														<div class="col-10"><?=$perfil['titulo']?></div>
													</div>
												</div>
												<div class="col-12">
													<div class="grid-noBottom">
														<div class="col-2"><strong><?=$textos['titulo_corto']?></strong> </div>
														<div class="col-10"><?=$perfil['titulo_corto']?></div>
													</div>
												</div>
											</div>
										</div>
										</div>
									
									
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['ods']?></h4>
												</div>
											</div>
											<div class="card-body ">
												<div class="grid ods">
													<?foreach($badges as $badge):?>
														<?if(!empty($perfil['badgesObtenidas'][$badge['idbadgeods']])):?>
															<div class="col-1">
																<div>
																	<img src="uploads/badges/<?=$badge['foto']?>" alt="<?=$badge['nombre']?>">
																</div>	
															</div>
														<?endif?>
													<?endforeach?>
												</div>
									
											</div>					
										</div>
									
									
									
										<div class="grid-noBottom">
											<div class="col-6">
												<div class="card ">
													<div class="card-header card-header-text">
														<div class="card-text">
															<h4 class="card-title"><?=$textos['linea_estrategica']?></h4>
														</div>
													</div>
													<div class="card-body ">
														<label type="text" class="form-control" ><?=empty($estrategica)? '' : $estrategica['nombre']?></label>
													</div>						
												</div>	
											</div><!-- col-md-6 -->
											<div class="col-6">
												<div class="card ">
													<div class="card-header card-header-text">
														<div class="card-text">
															<h4 class="card-title"><?=$textos['tipo_de_innovacion']?></h4>
														</div>
													</div>
													<div class="card-body ">
														<label type="text" class="form-control" ><?=empty($tipoInnovacion)? '' : $tipoInnovacion['nombre']?></label>
													</div>						
												</div>	
											</div><!-- col-md-6 -->
											<div class="col-6">
												<div class="card ">
													<div class="card-header card-header-text">
														<div class="card-text">
															<h4 class="card-title"><?=$textos['tipo_de_investigacion']?></h4>
														</div>
													</div>
													<div class="card-body ">
														<label type="text" class="form-control" ><?=empty($tipoInvestigacion)? '' : $tipoInvestigacion['nombre']?></label>
													</div>						
												</div>	
											</div><!-- col-md-6 -->

											<div class="col-6">
												<div class="card ">
													<div class="card-header card-header-text">
														<div class="card-text">
															<h4 class="card-title"><?=$textos['solucion_tecnologica']?></h4>
														</div>
													</div>
													<div class="card-body ">
														<label type="text" class="form-control" ><?=empty($solucion)? '' : $solucion['nombre']?></label>
													</div>						
												</div>	
											</div><!-- col-md-6 -->

										</div>
								

									
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['temas']?></h4>
												</div>
											</div>
											<div class="card-body temas">
												<?foreach($temas as $tema):?>
													<label type="text" class="form-control"><?=$tema['nombre']?></label>
												<?endforeach?>
											</div>						
										</div>	
									

									
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['sector_productivo']?></h4>
												</div>
											</div>
											<div class="card-body ">
												<?foreach($perfil['sector'] as $sector):?>
													<label type="text" class="form-control"><strong><?=$sector['nombre']?></strong>: 
														<?foreach($sector['subsectores'] as $subsector):?>
															<?=$subsector['nombre']?> - 
														<?endforeach?>
													</label>
												<?endforeach?>
											</div>						
										</div>	
									

								</div><!-- grid paso1 -->
							</div>

							<div class="tab-pane" id="link02">
								<div class="contpaso paso2">
										
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['organismo_ejecutor']?></h4>
												</div>
											</div>
											<div class="card-body bloque">
												
													<div class="cardTitle">
														<label class="form-control"><strong><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['organismo']?></strong></label>                        
													</div>
												
												<div class="grid-noBottom">
													<div class="col-12">
														<div class="form-group">
															<label for="name" class="bmd-label-floating"> <?=$textos['nombre_y_apellido']?>: </label>
															<label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['nombre_contacto']?></label>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label for="cargo" class="bmd-label-floating"> <?=$textos['cargo']?>: </label>
															<label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['cargo_contacto']?></label>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label for="email" class="bmd-label-floating"> <?=$textos['email']?>: </label>
															<label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['email_contacto']?></label>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label for="phone" class="bmd-label-floating"> <?=$textos['telefono']?>: </label>
															<label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['telefono_contacto']?></label>
														</div>
													</div>
													<div class="col-6">
														<div class="form-group">
															<label for="phone" class="bmd-label-floating"> País: </label>
															<label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['pais']?></label>
														</div>
													</div>
												</div>
											</div>
										</div>
								

									
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['organismos_coejecutores']?></h4>
												</div>
											</div>
											<div class="card-body ">
												<?foreach($perfil['coejecutor'] as $coejecutor):?>
													<div class="coejecutor bloque">					
														
														<div class="cardTitle">
															<label class="form-control"><strong><?=empty($coejecutor)?'':$coejecutor['organismo']?></strong></label>                        
														</div>
														
														<div class="grid-noBottom">
															<div class="col-12">
																<div class="form-group">
																	<label for="name" class="bmd-label-floating"> <?=$textos['nombre_y_apellido']?></label>
																	<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['nombre_contacto']?></label>
																</div>
															</div>
															<div class="col-6">
																<div class="form-group">
																	<label for="cargo" class="bmd-label-floating"> <?=$textos['cargo']?></label>
																	<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['cargo_contacto']?></label>
																</div>
															</div>
															<div class="col-6">
																<div class="form-group">
																	<label for="email" class="bmd-label-floating"> <?=$textos['email']?></label>
																	<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['email_contacto']?></label>
																</div>
															</div>
															<div class="col-6">
																<div class="form-group">
																	<label for="phone" class="bmd-label-floating"> <?=$textos['telefono']?></label>
																	<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['telefono_contacto']?></label>
																</div>
															</div>
															<div class="col-6">
																<div class="form-group">
																	<label for="phone" class="bmd-label-floating"> País</label>
																	<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['pais']?></label>
																</div>
															</div>
														</div>
													</div>
												<?endforeach?>	
												
											</div>
										</div>
								
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['organismo_asociado']?></h4>
												</div>
											</div>
											<div class="card-body ">
												<?foreach($perfil['asociado'] as $asociado):?>
													<div class="coejecutor bloque">					
													
															<div class="cardTitle">
																<label class="form-control"><strong><?=empty($asociado)?'':$asociado['organismo']?></strong></label>                        
															</div>
														
														<div class="grid-noBottom">
															<div class="col-12">
																<div class="form-group">
																	<label for="name" class="bmd-label-floating"> <?=$textos['nombre_y_apellido']?></label>
																	<label class="form-control" ><?=empty($asociado)?'':$asociado['nombre_contacto']?></label>
																</div>
															</div>
															<div class="col-6">
																<div class="form-group">
																	<label for="cargo" class="bmd-label-floating"> <?=$textos['cargo']?></label>
																	<label class="form-control" ><?=empty($asociado)?'':$asociado['cargo_contacto']?></label>
																</div>
															</div>
															<div class="col-6">
																<div class="form-group">
																	<label for="email" class="bmd-label-floating"> <?=$textos['email']?></label>
																	<label class="form-control" ><?=empty($asociado)?'':$asociado['email_contacto']?></label>
																</div>
															</div>
															<div class="col-6">
																<div class="form-group">
																	<label for="phone" class="bmd-label-floating"> <?=$textos['telefono']?></label>
																	<label class="form-control" ><?=empty($asociado)?'':$asociado['telefono_contacto']?></label>
																</div>
															</div>
															<div class="col-6">
																<div class="form-group">
																	<label for="phone" class="bmd-label-floating"> País</label>
																	<label class="form-control" ><?=empty($asociado)?'':$asociado['pais']?></label>
																</div>
															</div>
														</div>
													</div>
												<?endforeach?>	
											</div>
										</div>
									
									</div>
							</div>

							<div class="tab-pane" id="link03">		
								<div class="contpaso paso3">
									   
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['paso_3']?></h4>
												</div>
											</div>
											<div class="card-body ">
												<div class="grid-noBottom">
													<div class="col-4"><strong><?=$textos['monto_solicitado']?></strong> </div>
													<div class="col-8"><?=empty($perfil['monto'])?0:$perfil['monto']?></div>
												
													<div class="col-4"><strong><?=$textos['monto_contrapartida']?></strong> </div>
													<div class="col-8"><?=empty($perfil['monto_contrapartida'])?0:$perfil['monto_contrapartida']?></div>
												
													<div class="col-4"><strong><?=$textos['monto_total']?></strong> </div>
													<div class="col-8"><?=$perfil['monto_total']?></div>
												
													<div class="col-4"><strong><?=$textos['plazo_ejecucion']?></strong> </div>
													<div class="col-8"><?=$perfil['plazo']?></div>
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
													<h4 class="card-title"><?=$textos['paso_4']?></h4>
												</div>
											</div>
											<div class="card-body ">

												<div class="grid">
													<div class="col-4"><strong><?=$textos['congruencia']?></strong> </div>
													<div class="col-8"><?=$perfil['congruencia']?></div>
												
													<div class="col-4"><strong><?=$textos['regionalidad']?></strong> </div>
													<div class="col-8"><?=$perfil['regionalidad']?></div>
												
													<div class="col-4"><strong><?=$textos['capacidad']?></strong> </div>
													<div class="col-8"><?=$perfil['capacidad']?></div>
												
													<div class="col-4"><strong><?=$textos['articulacion']?></strong> </div>
													<div class="col-8"><?=$perfil['articulacion']?></div>
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
													<h4 class="card-title"><?=$textos['paso_5']?></h4>
												</div>
											</div>
											<div class="card-body ">
												<div class="grid">
													<div class="col-4"><strong><?=$textos['impacto']?></strong> </div>
													<div class="col-8"><?=$perfil['impacto']?></div>
												
													<div class="col-4"><strong><?=$textos['beneficiarios']?></strong> </div>
													<div class="col-8"><?=$perfil['beneficiarios']?></div>
												</div>
											</div>
										</div>
							
								</div><!-- grid paso5 -->
							</div>

							<div class="tab-pane" id="link06">
								<div class="contpaso paso6">
									              
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['paso_6']?></h4>
												</div>
											</div>
											<div class="card-body ">
													
												<div class="grid">
													<div class="col-4"><strong><?=$textos['antecedentes']?></strong> </div>
													<div class="col-8"><?=$perfil['antecedentes']?></div>
												
													<div class="col-4"><strong><?=$textos['fin_proyecto']?></strong> </div>
													<div class="col-8"><?=$perfil['fin_proyecto']?></div>

													<div class="col-4"><strong><?=$textos['proposito']?></strong> </div>
													<div class="col-8"><?=$perfil['proposito']?></div>

													<div class="col-4"><strong><?=$textos['marco_logico']?></strong> </div>
													<div class="col-8"><?=$perfil['marco_logico']?></div>
												</div>

											</div>
										</div>
						
								</div><!-- grid paso6 -->
							</div>

							<div class="tab-pane" id="link07">	
								<div class="contpaso paso7">
									              
										
								

									<?foreach($perfil['componente'] as $componente):
										if(empty($componente['nombre'])) continue;
										?>
									<div class="componente">               
										<div class="card">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['componente']?></h4>
												</div>
											</div>
											<div class="card-body ">

												<div class="grid">
													<div class="col-4"><strong><?=$textos['componente_nombre']?></strong> </div>
													<div class="col-8"><?=$componente['nombre']?></div>
												
													<div class="col-4"><strong><?=$textos['componente_actividad']?></strong> </div>
													<div class="col-8"><?=$componente['actividad']?></div>

													<div class="col-4"><strong><?=$textos['componente_producto']?></strong> </div>
													<div class="col-8"><?=$componente['producto']?></div>

													<div class="col-4"><strong><?=$textos['componente_resultado']?></strong> </div>
													<div class="col-8"><?=$componente['resultado']?></div>
												</div>

					
											</div>
										</div>
									</div>
									<?endforeach?>
								</div><!-- grid paso7 -->
							</div>

							<div class="tab-pane" id="link08">
								<div class="contpaso paso8">
								             
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['paso_8']?></h4>
												</div>
											</div>
											<div class="card-body ">
												<div class="grid">
													<div class="col-4"><strong><?=$textos['evidencia_capacidad']?></strong> </div>
													<div class="col-8"><?=$perfil['evidencia_capacidad']?></div>
												
													<div class="col-4"><strong><?=$textos['evidencia_articulacion']?></strong> </div>
													<div class="col-8"><?=$perfil['evidencia_articulacion']?></div>

													<div class="col-4"><strong><?=$textos['evidencia_mecanismos']?></strong> </div>
													<div class="col-8"><?=$perfil['evidencia_mecanismos']?></div>
												</div>
											</div>
										</div>
									
								</div><!-- grid paso8 -->
							</div>

							<div class="tab-pane" id="link09">
								<div class="contpaso paso9">
									           
										<div class="card ">
											<div class="card-header card-header-text">
												<div class="card-text">
													<h4 class="card-title"><?=$textos['paso_9']?></h4>
												</div>
											</div>
											<div class="card-body ">
												<div class="grid">
													<div class="col-4"><strong><?=$textos['adicional_cientifica']?></strong> </div>
													<div class="col-8"><?=$perfil['adicional_cientifica']?></div>
												
													<div class="col-4"><strong><?=$textos['adicional_potencial']?></strong> </div>
													<div class="col-8"><?=$perfil['adicional_potencial']?></div>

													<div class="col-4"><strong><?=$textos['adicional_escalamiento']?></strong> </div>
													<div class="col-8"><?=$perfil['adicional_escalamiento']?></div>

													<div class="col-4"><strong><?=$textos['adicional_transferencia']?></strong> </div>
													<div class="col-8"><?=$perfil['adicional_transferencia']?></div>

													<div class="col-4"><strong><?=$textos['adicional_riesgos']?></strong> </div>
													<div class="col-8"><?=$perfil['adicional_riesgos']?></div>

													<div class="col-4"><strong><?=$textos['adicional_pmp']?></strong> </div>
													<div class="col-8"><?=$perfil['adicional_pmp']?></div>
												</div>			  
											
											</div>
										</div>
									
								</div><!-- grid paso9 -->
							</div>
						</div>
		</div><!-- end content -->
	</body>
</html>
