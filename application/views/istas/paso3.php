
			<div class="row contpaso paso3">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
							<h4 class="card-title"><?=$textos['ista_paso_3']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<div class="row">								
								<div class="col-12">
									<div class="form-group">
										<label for="hallazgos" class="bmd-label-floating"> <?=$textos['ista_hallazgos']?> *</label>
										<textarea class="form-control" name="hallazgos" id="hallazgos" rows="5" required="true" maxlength="4000"><?=$ista['hallazgos']?></textarea>
										<small>
										<?=$textos['ista_hallazgos_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="innovaciones" class="bmd-label-floating"> <?=$textos['ista_innovaciones']?> *</label>
										<textarea class="form-control" name="innovaciones" id="innovaciones" rows="5" required="true" maxlength="4000"><?=$ista['innovaciones']?></textarea>
										<small>
										<?=$textos['ista_innovaciones_descripcion']?>
										</small>
									</div>
								</div>
							</div>
							<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
						</div>
					</div>
				</div><!-- col-md-12 -->
				

			</div><!-- row paso3 -->
