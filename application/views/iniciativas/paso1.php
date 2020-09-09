<?
$jsExtra1 = '';
$sectorTxt = '<option value=""></option>';
foreach($sectores as $val){								
	$sectorTxt .= '<option value="'.$val['value'].'">'.$val['label'].'</option>';
}
$subsectorTxT = '';
foreach($subsectores as $subsector){
	$clase = (!empty($perfil['subsectorSelect'][$subsector['value']]))?'form-check-seleccionado':''; 
	$checked = (!empty($perfil['subsectorSelect'][$subsector['value']]))?'CHECKED':''; 
	$subsectorTxT .= '<div class="form-check form-check-inline delsector" data-sector="'.$subsector['idsector'].'">';
	$subsectorTxT .=  	'<label class="form-check-label '.$clase.'">';
	$subsectorTxT .=		'<input class="form-check-input temascheck" name="idsubsectores[]" type="checkbox" value="'.$subsector['value'].'" '.$checked.'/> '.$subsector['label'];
	$subsectorTxT .=		'<span class="form-check-sign"><span class="check"></span></span>';
	$subsectorTxT .=	'</label>';
	$subsectorTxT .= '</div>';
}
?>

			<div class="row contpaso paso1">
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
							<h4 class="card-title"><?=$textos['paso_1']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label for="title" class="bmd-label-floating"> <?=$textos['titulo']?> *</label>
										<input type="text" class="form-control" id="title" name="titulo" required="true" maxlength="250" value="<?=$perfil['titulo']?>">
										<small><?=$textos['titulo_descripcion']?></small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="stitle" class="bmd-label-floating"> <?=$textos['titulo_corto']?> *</label>
										<input type="text" class="form-control" name="titulo_corto" required="true" maxlength="60"  value="<?=$perfil['titulo_corto']?>">
										<small><?=$textos['titulo_corto_descripcion']?></small>
									</div>
								</div>
							</div>
							<div class="category form-category">* <?=$textos['datos_requeridos']?></div>
						</div>
					</div>
				</div><!-- col-md-12 -->
				<div class="col-md-12">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['ods']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<div class="row justify-content-center ods">
								<div class="col-lg-12 text-center"> 
									<?foreach($badges as $badge):?>
									<div class="choice <?=(!empty($perfil['badgesObtenidas'][$badge['idbadgeods']]))?'active':''?>" data-toggle="wizard-checkbox" >
										<input type="checkbox" name="ods[]" value="<?=$badge['idbadgeods']?>" <?=(!empty($perfil['badgesObtenidas'][$badge['idbadgeods']]))?'checked':''?>>
										<div class="icon">
											<img src="uploads/badges/<?=$badge['foto']?>" alt="<?=$badge['nombre']?>">
										</div>
									</div>
									<?endforeach?>
								</div>
								<small><?=$textos['ods_descripcion']?></small>
							</div>
						</div>					
					</div>
				</div><!-- col-md-12 -->

				<div class="col-md-6">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['linea_estrategica']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<select class="selectpicker" data-style="select-with-transition" name="linea_estrategica" title="<?=$textos['seleccionar']?>" data-size="7">
								<?foreach($estrategica as $val):?>								
								<option value="<?=$val['value']?>" <?=$perfil['linea_estrategica']==$val['value']?'selected':''?>><?=$val['label']?></option>
								<?endforeach?>
							</select>	
						</div>						
					</div>	
				</div><!-- col-md-6 -->

				<div class="col-md-6">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['tipo_de_innovacion']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<select class="selectpicker" data-style="select-with-transition" name="tipo_innovacion" title="<?=$textos['seleccionar']?>" data-size="7">
								<?foreach($tipoInnovacion as $val):?>								
								<option value="<?=$val['value']?>" <?=$perfil['tipo_innovacion']==$val['value']?'selected':''?>><?=$val['label']?></option>
								<?endforeach?>
							</select>	
						</div>						
					</div>	
				</div><!-- col-md-6 -->

				<div class="col-md-6">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['tipo_de_investigacion']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<select class="selectpicker" data-style="select-with-transition" name="tipo_investigacion" title="<?=$textos['seleccionar']?>" data-size="7">
								<?foreach($tipoInvestigacion as $val):?>								
								<option value="<?=$val['value']?>" <?=$perfil['tipo_investigacion']==$val['value']?'selected':''?> ><?=$val['label']?></option>
								<?endforeach?>
							</select>	
						</div>						
					</div>	
				</div><!-- col-md-6 -->

				<div class="col-md-6">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['solucion_tecnologica']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<select class="selectpicker" data-style="select-with-transition" name="solucion_tecnologica" title="<?=$textos['seleccionar']?>" data-size="7">
								<?foreach($solucion as $val):?>								
								<option value="<?=$val['value']?>" <?=$perfil['solucion_tecnologica']==$val['value']?'selected':''?> ><?=$val['label']?></option>
								<?endforeach?>
							</select>	
						</div>						
					</div>	
				</div><!-- col-md-6 -->

				<div class="col-md-12">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['temas']?></h4>
							</div>
						</div>
						<div class="card-body temas">
							<div class="columns">
								<? foreach($temas as $opcion):?>
									<div class="form-check form-check-inline">
										<label class="form-check-label <?=(!empty($perfil['temasSelect'][$opcion['value']]))?'form-check-seleccionado':''?>">
											<input class="form-check-input temascheck" name="idtemas[]" type="checkbox" value="<?=$opcion['value']?>" <?=(!empty($perfil['temasSelect'][$opcion['value']]))?'CHECKED':''?>> <?=$opcion['label']?>
											<span class="form-check-sign"><span class="check"></span></span>
										</label>
									</div>
								<? endforeach;?>	
							</div>							
						</div>						
					</div>	
				</div><!-- col-md-12 -->

				<div class="col-md-12">
					<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['sector_productivo']?></h4>
							</div>
						</div>
						<div class="card-body ">
							<?for($i=1; $i<=6; $i++):
								$style = ($i>1 && empty($perfil['sector'][$i]['idsector']))? 'display:none': '';
								?>
								<div class="sector" style="<?=$style?>">
									<div class="row">
										<div class="col-sm-12 pt-3 pb-0">
											<div class="bigSelect">
												<select class="selectOrg bigSelect" name="sector[<?=$i?>][idsector]" data-placeholder="<?=$textos['seleccionar']?>">
													<?=$sectorTxt?>
													<?if(!empty($perfil['sector']) && $perfil['sector'][$i]['idsector']){
														$jsExtra1 .= "$('select[name=\"sector[".$i."][idsector]\"]').val(".$perfil['sector'][$i]['idsector'].");";
														$jsExtra1 .= "$('select[name=\"sector[".$i."][idsector]\"]').trigger('change');";
													}?>
												</select>
											</div>
										</div>
									</div>
									<div class="row card-body " style="<?=empty($perfil['sector'][$i]['idsector'])? 'display:none': ''?>">
										<div class="columns">
											<?=$subsectorTxT?>
										</div>
									</div>
								</div>
							<?endfor?>
							<div style="width:100%; text-align:center">
								<button type="button" class="btn btn-primary btn-round btn-fab" id="masSector" onclick="mostarSector()"><i class="material-icons">add</i></button>
							</div>	
						</div>						
					</div>	
				</div><!-- col-md-12 -->

			</div><!-- row paso1 -->

<script>
function jsExtra1(){
	<?=$jsExtra1?>
}
</script>