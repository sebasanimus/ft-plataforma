

			<div class="row contpaso paso7">
				<div class="col-md-12">               
			   		<div class="card ">
						<!--<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['paso_7']?></h4>
							</div>
						</div>-->
				 		<div class="card-body ">
				   			<div class="row">
							   <div class="col-12">
									<div class="form-group">
										<label for="antecedentes" class="bmd-label-floating"> <?=$textos['marco_logico']?></label>
										<label class="form-control"><?=$perfil['marco_logico']?></label>
										<small>
										<?=$textos['marco_logico_descripcion']?>
										</small>
									</div>
								</div>					 
							  </div>
				 		</div>
			   		</div>
				</div><!-- col-md-12 -->

				<?foreach($perfil['componente'] as $componente):
					if(empty($componente['nombre'])) continue;
					?>
				<div class="col-md-12 componente">               
			   		<div class="card">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['componente']?></h4>
							</div>
						</div>
				 		<div class="card-body ">
				   			<div class="row">
							   <div class="col-12">
									<div class="form-group">
										<label for="antecedentes" class="bmd-label-floating"> <?=$textos['componente_nombre']?></label>
										<label class="form-control" ><?=$componente['nombre']?></label>
										<small>
											<?=$textos['componente_nombre_descripcion']?>
										</small>										
									</div>
								</div> 	
								<div class="col-12">									
									<div class="form-group">
										<label for="antecedentes" class=""> <?=$textos['componente_actividad']?></label>
										<label class="form-control"><?=$componente['actividad']?></label>
										<small>
											<?=$textos['componente_actividad_descripcion']?>
										</small>										
									</div>									
								</div>	
								<div class="col-12">									
									<div class="form-group">
										<label for="antecedentes" class=""> <?=$textos['componente_producto']?></label>
										<label class="form-control" ><?=$componente['producto']?></label>
										<small>
											<?=$textos['componente_producto_descripcion']?>
										</small>										
									</div>									
								</div>
								<div class="col-12">									
									<div class="form-group">
										<label for="antecedentes" class=""> <?=$textos['componente_resultado']?></label>
										<label class="form-control" ><?=$componente['resultado']?></label>
										<small>
											<?=$textos['componente_resultado_descripcion']?>
										</small>										
									</div>									
								</div>				 
							</div>						
				 		</div>
			   		</div>
				</div><!-- col-md-12 -->
				<?endforeach?>

			</div><!-- row paso7 -->