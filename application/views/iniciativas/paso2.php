<?
$paisesStr = '';
$jsExtra2 = '';
foreach($paises as $val){	
	if($val['id']==24) continue;	//es el pais vacio						
	$paisesStr .='<option value="'.$val['id'].'" >'.$val['nombre'].'</option>';
}
if (!empty($perfil['ejecutor']) && $perfil['ejecutor']['idpais']){
	$jsExtra2 .= "$('select[name=\"ejecutor[idpais]\"]').val(".$perfil['ejecutor']['idpais'].");";
	$jsExtra2 .= "$('select[name=\"ejecutor[idpais]\"]').trigger('change');";
}
$orgsTxt = '<option value=""></option>';
foreach($organismos as $val){	
	$nombre_largo = empty($val['nombre_largo']) ? '': ' - '.$val['nombre_largo'] ;  
	if(!empty($val['pais'])) $nombre_largo .= ' - '.$val['pais'];							
	$orgsTxt .= '<option value="'.$val['idorganismo'].'">'.$val['nombre'].$nombre_largo.'</option>';
}
if (!empty($perfil['ejecutor']) && $perfil['ejecutor']['idorganismo']){
	$jsExtra2 .= "$('select[name=\"ejecutor[idorganismo]\"]').val(".$perfil['ejecutor']['idorganismo'].");";
	$jsExtra2 .= "$('select[name=\"ejecutor[idorganismo]\"]').selectpicker('refresh');";	
}
?>
<div class="row contpaso paso2">
	<div class="col-md-12">
		<div class="header ml-auto mr-4 pt-3 pb-2">
            <h3 class="title"><?=$textos['plataforma']?></h3>
			<p class="category"><?=nl2br($textos['plataforma_descripcion'])?></p>
			<p>
				<strong><?=$textos['plataforma_incorporar']?></strong>
			</p>
			<div style="width:100%; text-align:right">
				<button type="button" class="btn btn-defaul" onclick="modalOrganismo()"><i class="material-icons">create</i> <?=$textos['solicitar_nuevo']?></button>
			</div>	
        </div>
        <div class="card ">
            <div class="card-header card-header-rose card-header-text">
                <div class="card-text">
                    <h4 class="card-title"><?=$textos['organismo_ejecutor']?></h4>
                </div>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-sm-12 pt-3 pb-2">
                        <select class="selectpicker selectpickerOrgEje" data-size="7" name="ejecutor[idorganismo]" data-style="btn btn-dark btn-round <?=(!empty($perfil['ejecutor']) && $perfil['ejecutor']['idorganismo'])? '':'faltante'?>" data-live-search="true" title="<?=$textos['seleccione_ejecutor']?>">
							<?=$orgsTxt?>							
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name" class="bmd-label-floating"> <?=$textos['nombre_y_apellido']?> *</label>
                            <input type="text" class="form-control" name="ejecutor[nombre]" value="<?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['nombre_contacto']?>" maxlength="100" required="true">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="cargo" class="bmd-label-floating"> <?=$textos['cargo']?> *</label>
                            <input type="text" class="form-control" name="ejecutor[cargo]" value="<?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['cargo_contacto']?>" maxlength="100" required="true">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email" class="bmd-label-floating"> <?=$textos['email']?> *</label>
                            <input type="email" class="form-control" name="ejecutor[email]" value="<?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['email_contacto']?>" maxlength="100" required="true">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone" class="bmd-label-floating"> <?=$textos['telefono']?> *</label>
                            <input type="text" class="form-control" name="ejecutor[telefono]" value="<?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['telefono_contacto']?>" maxlength="100" required="true">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group <?=empty($perfil['ejecutor']['idpais'])?'has-danger':''?>">
							<select class="selectpicker" data-style="select-with-transition" title="<?=$textos['seleccionar_pais']?>" name="ejecutor[idpais]" required="true" data-size="7">
								<?=$paisesStr?>
							</select>
                        </div>
                    </div>
                </div>
                <div class="category form-category">* <?=$textos['datos_requeridos']?></div>
            </div>
        </div>
    </div>

    <div class="col-12">
    	<div class="card ">
            <div class="card-header card-header-rose card-header-text">
                <div class="card-text">
                    <h4 class="card-title"><?=$textos['organismos_coejecutores']?></h4>
                </div>
            </div>
            <div class="card-body ">
				<?for($i=1; $i<=4; $i++):
					$style = ($i>1 && empty($perfil['coejecutor'][$i]['idorganismo']))? 'display:none': '';
					?>
					<div class="coejecutor" style="<?=$style?>">
					
						<div class="row">
							<div class="col-sm-12 pt-3 pb-0">
								<div class="bigSelect">
									<select class="selectOrg bigSelect" name="coejecutor[<?=$i?>][idorganismo]" data-placeholder="<?=$textos['seleccione_coejecutor']?>">
										<?=$orgsTxt?>
										<?if(!empty($perfil['coejecutor']) && $perfil['coejecutor'][$i]['idorganismo']){
											$jsExtra2 .= "$('select[name=\"coejecutor[".$i."][idorganismo]\"]').val(".$perfil['coejecutor'][$i]['idorganismo'].");";
											$jsExtra2 .= "$('select[name=\"coejecutor[".$i."][idorganismo]\"]').trigger('change');";
										}?>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="<?=empty($perfil['coejecutor'][$i]['idorganismo'])? 'display:none': ''?>">
							<div class="col-12">
								<div class="form-group">
									<label for="name" class="bmd-label-floating"> <?=$textos['nombre_y_apellido']?> *</label>
									<input type="text" class="form-control" name="coejecutor[<?=$i?>][nombre]" value="<?=empty($perfil['coejecutor'][$i])?'':$perfil['coejecutor'][$i]['nombre_contacto']?>" maxlength="100" required="true">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="cargo" class="bmd-label-floating"> <?=$textos['cargo']?> *</label>
									<input type="text" class="form-control" name="coejecutor[<?=$i?>][cargo]" value="<?=empty($perfil['coejecutor'][$i])?'':$perfil['coejecutor'][$i]['cargo_contacto']?>" maxlength="100" required="true">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="email" class="bmd-label-floating"> <?=$textos['email']?> *</label>
									<input type="email" class="form-control" name="coejecutor[<?=$i?>][email]" value="<?=empty($perfil['coejecutor'][$i])?'':$perfil['coejecutor'][$i]['email_contacto']?>" maxlength="100" required="true">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="phone" class="bmd-label-floating"> <?=$textos['telefono']?> *</label>
									<input type="text" class="form-control" name="coejecutor[<?=$i?>][telefono]" value="<?=empty($perfil['coejecutor'][$i])?'':$perfil['coejecutor'][$i]['telefono_contacto']?>" maxlength="100" required="true">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group <?=empty($perfil['coejecutor'][$i]['idpais'])?'has-danger':''?>">
									<select class="selectpicker" data-style="select-with-transition" title="<?=$textos['seleccionar_pais']?>" name="coejecutor[<?=$i?>][idpais]" required="true" data-size="7">
										<?=$paisesStr?>
										<?if(!empty($perfil['coejecutor']) && $perfil['coejecutor'][$i]['idpais']){
											$jsExtra2 .= "$('select[name=\"coejecutor[".$i."][idpais]\"]').val(".$perfil['coejecutor'][$i]['idpais'].");";
											$jsExtra2 .= "$('select[name=\"coejecutor[".$i."][idpais]\"]').trigger('change');";
										}?>
									</select>
								</div>
							</div>
						</div>
					</div>
				<?endfor?>
				<div style="width:100%; text-align:center">
					<button type="button" class="btn btn-primary btn-round btn-fab" id="masCoEjecutor" onclick="mostarCoEjecutor()"><i class="material-icons">add</i></button>
				</div>	
				<div>
					<small><?=$textos['aclaracion_coejecutor']?></small>
				</div>		
			</div>
		</div>
	</div>
    <div class="col-12">
        <div class="card ">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-text">
					<h4 class="card-title"><?=$textos['organismo_asociado']?></h4>
				</div>
			</div>
			<div class="card-body ">
			<?for($i=1; $i<=16; $i++):
					$style = ($i>1 && empty($perfil['asociado'][$i]['idorganismo']))? 'display:none': '';
					?>
					<div class="asociado" style="<?=$style?>">
						<div class="row">
							<div class="col-sm-12 pt-3 pb-0">
								<div class="bigSelect">
									<select class="selectOrg" name="asociado[<?=$i?>][idorganismo]" data-placeholder="<?=$textos['seleccione_asociado']?>">
										<?=$orgsTxt?>
										<?if(!empty($perfil['asociado']) && !empty($perfil['asociado'][$i]['idorganismo'])){
											$jsExtra2 .= "$('select[name=\"asociado[".$i."][idorganismo]\"]').val(".$perfil['asociado'][$i]['idorganismo'].");";
											$jsExtra2 .= "$('select[name=\"asociado[".$i."][idorganismo]\"]').trigger('change');";
										}?>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="<?=empty($perfil['asociado'][$i]['idorganismo'])? 'display:none': ''?>">
							<div class="col-12">
								<div class="form-group">
									<label for="name" class="bmd-label-floating"> <?=$textos['nombre_y_apellido']?> *</label>
									<input type="text" class="form-control" name="asociado[<?=$i?>][nombre]" value="<?=empty($perfil['asociado'][$i])?'':$perfil['asociado'][$i]['nombre_contacto']?>" maxlength="100" required="true">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="cargo" class="bmd-label-floating"> <?=$textos['cargo']?> *</label>
									<input type="text" class="form-control" name="asociado[<?=$i?>][cargo]" value="<?=empty($perfil['asociado'][$i])?'':$perfil['asociado'][$i]['cargo_contacto']?>" maxlength="100" required="true">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="email" class="bmd-label-floating"> <?=$textos['email']?> *</label>
									<input type="email" class="form-control" name="asociado[<?=$i?>][email]" value="<?=empty($perfil['asociado'][$i])?'':$perfil['asociado'][$i]['email_contacto']?>" maxlength="100" required="true">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="phone" class="bmd-label-floating"> <?=$textos['telefono']?> *</label>
									<input type="text" class="form-control" name="asociado[<?=$i?>][telefono]" value="<?=empty($perfil['asociado'][$i])?'':$perfil['asociado'][$i]['telefono_contacto']?>" maxlength="100" required="true">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group <?=empty($perfil['asociado'][$i]['idpais'])?'has-danger':''?>">
									<select class="selectpicker" data-style="select-with-transition" title="<?=$textos['seleccionar_pais']?>" name="asociado[<?=$i?>][idpais]" required="true" data-size="7">
										<?=$paisesStr?>
										<?if(!empty($perfil['asociado']) && !empty($perfil['asociado'][$i]['idpais'])){
											$jsExtra2 .= "$('select[name=\"asociado[".$i."][idpais]\"]').val(".$perfil['asociado'][$i]['idpais'].");";
											$jsExtra2 .= "$('select[name=\"asociado[".$i."][idpais]\"]').trigger('change');";
										}?>
									</select>
								</div>
							</div>
						</div>
					</div>
				<?endfor?>
				<div style="width:100%; text-align:center">
					<button type="button" class="btn btn-primary btn-round btn-fab" id="masAsociado" onclick="mostarAsociado()"><i class="material-icons">add</i></button>
				</div>	
			</div>
        </div>
    </div>
</div><!-- row paso2 -->

<script>
function jsExtra2(){
	<?=$jsExtra2?>
}
</script>


<div class="modal fade" id="organismoModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-rose text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title"><?=$textos['solicitar_nuevo']?></h4>                    
					</div>
                </div>
                <div class="modal-body">
					<p class="description text-center"><?=$textos['solicitar_descripcion']?></p>
					<div class="card-body">

						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">flag</i></div>
								</div>
								<select class="selectpicker selectCopado" id="org_pais" data-style="select-with-transition" title="<?=$textos['seleccionar_pais']?>" data-size="7">
									<?=$paisesStr?>
								</select>
							</div>
						</div>

						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">flag</i></div>
								</div>
								<select class="selectpicker selectCopado" id="org_tipo_institucion" data-style="select-with-transition" title="<?=$textos['seleccionar_tipo_inst']?>" data-size="7">
									<?foreach($tipo_institucion as $val):?>							
										<option value="<?=$val['value']?>"><?=$val['label']?></option>';
									<?endforeach?>
								</select>
							</div>
						</div>

						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">title</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<input type="text" id="org_nombre" placeholder="<?=$textos['solicitar_sigla']?>" class="form-control"  maxlength="100" />	
									<span class="bmd-help"><?=$textos['solicitar_sigla']?></span>
								</div>
							</div>
						</div>
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">text_fields</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<input type="text" id="org_nombre_largo" placeholder="<?=$textos['solicitar_nombre']?>" class="form-control" maxlength="100" />	
									<span class="bmd-help"><?=$textos['solicitar_nombre']?></span>
								</div>
							</div>
						</div>
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">link</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<input type="text" id="org_link" placeholder="<?=$textos['solicitar_link']?>" class="form-control" maxlength="100" />	
									<span class="bmd-help"><?=$textos['solicitar_link']?></span>
								</div>
							</div>
						</div>
												
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarOrganismo()" class="btn btn-primary btn-link btn-wd btn-lg"><?=$textos['enviar']?></a>
                </div>
            </div>
        </div>
    </div>
</div>