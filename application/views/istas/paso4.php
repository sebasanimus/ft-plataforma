
			<div class="row contpaso paso4">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
							<h4 class="card-title"><?=$textos['ista_paso_4']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<div class="row">								
								<div class="col-12">
									<div class="form-group">
										<label for="historias" class="bmd-label-floating"> <?=$textos['ista_historias']?> *</label>
										<textarea class="form-control" name="historias" id="historias" rows="5" required="true" maxlength="4000"><?=$ista['historias']?></textarea>
										<small>
										<?=$textos['ista_historias_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="oportunidades" class="bmd-label-floating"> <?=$textos['ista_oportunidades']?> *</label>
										<textarea class="form-control" name="oportunidades" id="oportunidades" rows="5" required="true" maxlength="4000"><?=$ista['oportunidades']?></textarea>
										<small>
										<?=$textos['ista_oportunidades_descripcion']?>
										</small>
									</div>
								</div>
							</div>
							<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
						</div>
					</div>
				</div><!-- col-md-12 -->
				

			</div><!-- row paso4 -->
