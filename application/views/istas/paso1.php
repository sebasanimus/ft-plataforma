
			<div class="row contpaso paso1">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
							<h4 class="card-title"><?=$textos['ista_paso_1']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label for="title" class="bmd-label-floating"> <?=$textos['ista_investigador']?> *</label>
										<input type="text" class="form-control" id="investigador" name="investigador" required="true" maxlength="250" value="<?=$ista['investigador']?>">
										<small><?=$textos['ista_investigador_descripcion']?></small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="objetivo" class="bmd-label-floating"> <?=$textos['ista_objetivo']?> *</label>
										<textarea class="form-control" name="objetivo" id="objetivo" rows="5" required="true" maxlength="4000"><?=$ista['objetivo']?></textarea>
										<small>
										<?=$textos['ista_objetivo_descripcion']?>
										</small>
									</div>
								</div>
							</div>
							<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
						</div>
					</div>
				</div><!-- col-md-12 -->
				

			</div><!-- row paso1 -->
