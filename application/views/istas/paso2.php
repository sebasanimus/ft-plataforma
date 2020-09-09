
			<div class="row contpaso paso2">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
							<h4 class="card-title"><?=$textos['ista_paso_2']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<div class="row">								
								<div class="col-12">
									<div class="form-group">
										<label for="resumen_ejecutivo" class="bmd-label-floating"> <?=$textos['ista_resumen_ejecutivo']?> *</label>
										<textarea class="form-control" name="resumen_ejecutivo" id="resumen_ejecutivo" rows="5" required="true" maxlength="4000"><?=$ista['resumen_ejecutivo']?></textarea>
										<small>
										<?=$textos['ista_resumen_ejecutivo_descripcion']?>
										</small>
									</div>
								</div>							
								<div class="col-12">
									<div class="form-group">
										<label for="resultados" class="bmd-label-floating"> <?=$textos['ista_resultados']?> *</label>
										<textarea class="form-control" name="resultados" id="resultados" rows="5" required="true" maxlength="4000"><?=$ista['resultados']?></textarea>
										<small>
										<?=$textos['ista_resultados_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="productos" class="bmd-label-floating"> <?=$textos['ista_productos']?> *</label>
										<textarea class="form-control" name="productos" id="productos" rows="5" required="true" maxlength="4000"><?=$ista['productos']?></textarea>
										<small>
										<?=$textos['ista_productos_descripcion']?>
										</small>
									</div>
								</div>
							</div>
							<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
						</div>
					</div>
				</div><!-- col-md-12 -->
				

			</div><!-- row paso2 -->
