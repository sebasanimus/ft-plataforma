

			<div class="row contpaso paso3">
				<div class="col-md-12">     
			   		<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['paso_3']?></h4>
							</div>
						</div>
				 		<div class="card-body ">
				   			<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label for="monto" class="bmd-label-floating"> <?=$textos['monto_solicitado']?> *</label>
										<input type="number" class="form-control" name="monto" required="true"  min="0" step="1" value="<?=empty($perfil['monto'])?0:round($perfil['monto'])?>">
										<small>
										<?=$textos['monto_solicitado_descripcion']?> 
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="contrapartida" class="bmd-label-floating"> <?=$textos['monto_contrapartida']?> *</label>
										<input type="number" class="form-control" name="monto_contrapartida"  min="0" step="1" required="true" value="<?=empty($perfil['monto_contrapartida'])?0:round($perfil['monto_contrapartida'])?>" >
										<small>
										<?=$textos['monto_contrapartida_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
					   				<div class="alert alert-secondary mt-3" role="alert">
										<div class="form-group">
											<label for="total" class="bmd-label-floating"> <?=$textos['monto_total']?> *</label>
											<input type="number" class="form-control" id="monto_total" disabled value="<?=$perfil['monto_total']?>" >
											<small>
											<?=$textos['monto_total_descripcion']?>
											</small>
										</div>
									</div>
						 		</div>		
								<div class="col-12">
									<div class="form-group">
										<label for="plazo" class="bmd-label-floating"> <?=$textos['plazo_ejecucion']?> *</label>
										<input type="number" class="form-control" name="plazo"  min="0" step="1" required="true" value="<?=$perfil['plazo']?>" >
										<small>
										<?=$textos['plazo_ejecucion_descripcion']?> 
										</small>
									</div>
								</div>			   
					 		</div>
							 <div class="category form-category">* <?=$textos['datos_requeridos']?></div>
				   		</div>
				   		
				 	</div>
			   	</div><!-- col-md-12 -->
			</div><!-- row paso3 -->