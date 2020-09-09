

			<div class="row contpaso paso5">
				<div class="col-md-12">               
			   		<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['paso_5']?></h4>
							</div>
						</div>
				 		<div class="card-body ">
				   			<div class="row">
							   <div class="col-12">
									<div class="form-group">
										<label for="name" class="bmd-label-floating"> <?=$textos['impacto']?> *</label>
										<textarea class="form-control" name="impacto" required="true"  maxlength="800"><?=$perfil['impacto']?></textarea>
										<small>
										<?=$textos['impacto_descripcion']?>
										</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="beneficiarios" class="bmd-label-floating"> <?=$textos['beneficiarios']?> *</label>
										<textarea class="form-control" name="beneficiarios" rows="5" required="true" maxlength="750"><?=$perfil['beneficiarios']?></textarea>
										<small>
										<?=$textos['beneficiarios_descripcion']?>
										</small>
									</div>
								</div>					 
				  			</div>
				   			<div class="category form-category">* <?=$textos['datos_requeridos']?></div>
				 		</div>
			   		</div>
			 	</div><!-- col-md-12 -->
			</div><!-- row paso5 -->