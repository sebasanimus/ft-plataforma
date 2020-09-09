

			<div class="row contpaso paso6">
				<div class="col-md-12">               
			   		<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['paso_6']?></h4>
							</div>
						</div>
				 		<div class="card-body ">
						 	<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label for="antecedentes" class="bmd-label-floating"> <?=$textos['antecedentes']?> *</label>
										<textarea class="form-control" name="antecedentes" rows="7" required="true" maxlength="4000"><?=$perfil['antecedentes']?></textarea>
										<small>
										<?=$textos['antecedentes_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="finproyecto" class="bmd-label-floating"> <?=$textos['fin_proyecto']?> *</label>
										<textarea class="form-control" name="fin_proyecto" rows="5" required="true" maxlength="800"><?=$perfil['fin_proyecto']?></textarea>
										<small>
										<?=$textos['fin_proyecto_descripcion']?> 
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="proposito" class="bmd-label-floating"> <?=$textos['proposito']?> *</label>
										<textarea class="form-control" name="proposito" rows="5" required="true" maxlength="800"><?=$perfil['proposito']?></textarea>
										<small>
										<?=$textos['proposito_descripcion']?> 
										</small>
									</div>
								</div>
							</div>
				   			<div class="category form-category">* <?=$textos['datos_requeridos']?></div>
				 		</div>
			   		</div>
			 	</div><!-- col-md-12 -->
			</div><!-- row paso6 -->