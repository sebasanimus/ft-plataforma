

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
										<label for="monto" class="bmd-label-floating"> <?=$textos['monto_solicitado']?></label>
										<label class="form-control"><?=empty($perfil['monto'])?0:$perfil['monto']?></label>
										<small>
										<?=$textos['monto_solicitado_descripcion']?> 
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="contrapartida" class="bmd-label-floating"> <?=$textos['monto_contrapartida']?></label>
										<label class="form-control"><?=empty($perfil['monto_contrapartida'])?0:$perfil['monto_contrapartida']?></label>
										<small>
										<?=$textos['monto_contrapartida_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
					   				<div class="alert alert-secondary mt-3" role="alert">
										<div class="form-group">
											<label for="total" class="bmd-label-floating"> <?=$textos['monto_total']?></label>
											<label class="form-control"><?=$perfil['monto_total']?></label>
											<small>
											<?=$textos['monto_total_descripcion']?>
											</small>
										</div>
									</div>
						 		</div>		
								<div class="col-12">
									<div class="form-group">
										<label for="plazo" class="bmd-label-floating"> <?=$textos['plazo_ejecucion']?></label>
										<label class="form-control"><?=$perfil['plazo']?></label>
										<small>
										<?=$textos['plazo_ejecucion_descripcion']?> 
										</small>
									</div>
								</div>			   
					 		</div>
				   		</div>
				   		
				 	</div>
			   	</div><!-- col-md-12 -->
			</div><!-- row paso3 -->