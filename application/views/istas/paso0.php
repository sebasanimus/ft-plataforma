
			<div class="row contpaso paso0">
				<div class="col-md-9 col-lg-9 col-xl-7 col-12 mr-auto ml-auto">
				
					<div class="card ">
						<div class="cardImage rounded-lg rounded-top" style="background-image: url('<?=base_url()?>uploads/noticias/productividad.jpg')"></div>
						<div class="card-body ">
							<h3><?=$textos['ista_bienvenida']?> <?=$callista['titulo']?></h3>
							<p><?=$callista['descripcion']?></p>
							<p><?=$callista['antecedentes']?></p>
							<p><?=$callista['objetivos']?></p>
							<p><?=$callista['metodologia']?></p>
							<p><?=$callista['calendario']?></p>
							<p><?=$callista['normas']?></p>
							<!--<div class="form-check mr-auto pt-2">
								<label class="form-check-label">
								<input class="form-check-input" type="checkbox" value="1" id="leyo_manual" name="leyo_manual" <?=empty($ista['leyo_manual'])?'':'checked'?> required> <?=$textos['ista_he_leido']?>
								<span class="form-check-sign" id="check_aceptar" data-toggle="tooltip" title="<?=$textos['ista_debe_aceptar']?>">
									<span class="check"></span>
								</span>								
								</label>
							</div>-->
							<input class="form-check-input" type="hidden" value="1" id="leyo_manual" name="leyo_manual" /> 
						</div>
					</div>					
					
				</div>
            </div><!-- row paso0 -->