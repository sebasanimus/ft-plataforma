
			<div class="row contpaso paso5">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
							<h4 class="card-title"><?=$textos['ista_paso_5']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<div class="row">								
								<div class="col-12">
									<div class="form-group">
										<label for="articulacion" class="bmd-label-floating"> <?=$textos['ista_articulacion']?> *</label>
										<textarea class="form-control" name="articulacion" id="articulacion" rows="5" required="true" maxlength="4000"><?=$ista['articulacion']?></textarea>
										<small>
										<?=$textos['ista_articulacion_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="gestion" class="bmd-label-floating"> <?=$textos['ista_gestion']?> *</label>
										<textarea class="form-control" name="gestion" id="gestion" rows="5" required="true" maxlength="4000"><?=$ista['gestion']?></textarea>
										<small>
										<?=$textos['ista_gestion_descripcion']?>
										</small>
									</div>
								</div>
							</div>
							<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
						</div>
					</div>
				</div><!-- col-md-12 -->
				

			</div><!-- row paso5 -->
