

			<div class="row contpaso paso7">
				<div class="col-md-12">               
			   		<div class="card ">
						<!--<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['paso_7']?></h4>
							</div>
						</div>-->
				 		<div class="card-body ">
				   			<div class="row">
							   <div class="col-12">
									<div class="form-group">
										<label for="antecedentes" class="bmd-label-floating"> <?=$textos['marco_logico']?> *</label>
										<textarea class="form-control" name="marco_logico" rows="7" required="true" maxlength="3000"><?=$perfil['marco_logico']?></textarea>
										<small>
										<?=$textos['marco_logico_descripcion']?>
										</small>
									</div>
								</div>					 
							  </div>
							  <div class="category form-category">* <?=$textos['datos_requeridos']?></div>
				 		</div>
			   		</div>
				</div><!-- col-md-12 -->

				<?for($i=1; $i<=10; $i++):
					$style = ($i>1 && empty($perfil['componente'][$i]['nombre']))? 'display:none': '';
					?>
				<div class="col-md-12 componente" style="<?=$style?>" >               
			   		<div class="card">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['componente']?></h4>
							</div>
							<div class="close-card" style="display:none">
								<a href="javascript:hideComponente()"><i class="material-icons">close</i></a>
							</div>
						</div>
				 		<div class="card-body ">
				   			<div class="row">
							   <div class="col-12">
									<div class="form-group">
										<label for="antecedentes" class="bmd-label-floating"> <?=$textos['componente_nombre']?> *</label>
										<input type="text" class="form-control" name="componente[<?=$i?>][nombre]" required="true" maxlength="100"  value="<?=empty($perfil['componente'][$i])?'':$perfil['componente'][$i]['nombre']?>">
										<small>
											<?=$textos['componente_nombre_descripcion']?>
										</small>										
									</div>
								</div> 	
								<div class="col-12">									
									<div class="form-group">
										<label for="antecedentes" class=""> <?=$textos['componente_actividad']?> *</label>
										<textarea class="form-control" name="componente[<?=$i?>][actividad]" required="true" rows="5" maxlength="3000" ><?=empty($perfil['componente'][$i])?'':$perfil['componente'][$i]['actividad']?></textarea>
										<small>
											<?=$textos['componente_actividad_descripcion']?>
										</small>										
									</div>									
								</div>	
								<div class="col-12">									
									<div class="form-group">
										<label for="antecedentes" class=""> <?=$textos['componente_producto']?> *</label>
										<textarea class="form-control" name="componente[<?=$i?>][producto]" required="true" rows="5" maxlength="3000" ><?=empty($perfil['componente'][$i])?'':$perfil['componente'][$i]['producto']?></textarea>
										<small>
											<?=$textos['componente_producto_descripcion']?>
										</small>										
									</div>									
								</div>
								<div class="col-12">									
									<div class="form-group">
										<label for="antecedentes" class=""> <?=$textos['componente_resultado']?> *</label>
										<textarea class="form-control" name="componente[<?=$i?>][resultado]" required="true" rows="5" maxlength="3000" ><?=empty($perfil['componente'][$i])?'':$perfil['componente'][$i]['resultado']?></textarea>
										<small>
											<?=$textos['componente_resultado_descripcion']?>
										</small>										
									</div>									
								</div>				 
							</div>						
				 		</div>
			   		</div>
				</div><!-- col-md-12 -->
				<?endfor?>
				<div style="width:100%; text-align:center">
					<button type="button" class="btn btn-primary btn-round" id="masComponente" onclick="mostarComponente()"><i class="material-icons">add</i> <?=$textos['componente_agregar']?></button>
				</div>

			</div><!-- row paso7 -->