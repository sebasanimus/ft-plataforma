

			<div class="row contpaso paso4">
				<div class="col-md-12">               
			   		<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['paso_4']?></h4>
							</div>
						</div>
				 		<div class="card-body ">
				   			<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label for="congruencia" class="bmd-label-floating"> <?=$textos['congruencia']?> *</label>
										<textarea class="form-control" name="congruencia" rows="5" required="true" maxlength="4000"><?=$perfil['congruencia']?></textarea>
										<small>
										<?=$textos['congruencia_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="regionalidad" class="bmd-label-floating"> <?=$textos['regionalidad']?> *</label>
										<textarea class="form-control" name="regionalidad" rows="5" required="true" maxlength="4000"><?=$perfil['regionalidad']?></textarea>
										<small>
										<?=$textos['regionalidad_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="capacidadtec" class="bmd-label-floating"> <?=$textos['capacidad']?> *</label>
										<textarea class="form-control" name="capacidad" rows="5" required="true" maxlength="4000"><?=$perfil['capacidad']?></textarea>
										<small>
										<?=$textos['capacidad_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="articulacion" class="bmd-label-floating"> <?=$textos['articulacion']?> *</label>
										<textarea class="form-control" name="articulacion" rows="5" required="true" maxlength="2000"><?=$perfil['articulacion']?></textarea>
										<small>
										<?=$textos['articulacion_descripcion']?>
										</small>
									</div>
								</div>					 
				  			</div>
				   			<div class="category form-category">* <?=$textos['datos_requeridos']?></div>
				 		</div>
			   		</div>
			 	</div><!-- col-md-12 -->
			</div><!-- row paso4 -->