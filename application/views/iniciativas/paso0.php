
			<div class="row contpaso paso0">
				<div class="col-md-9 col-lg-9 col-xl-7 col-12 mr-auto ml-auto">
				
					<div class="card ">
						<div class="cardImage rounded-lg rounded-top" style="background-image: url('<?=base_url()?>uploads/noticias/<?=$iniciativa['foto']?>')"></div>
						<div class="card-body ">
							<h3><?=$textos['bienvenida']?> <?=$iniciativa['titulo']?></h3>
							<p><?=nl2br($textos['bienvenida_descripcion'])?></p>
							<div class="form-check mr-auto pt-2">
								<label class="form-check-label">
								<input class="form-check-input" type="checkbox" value="1" id="leyo_manual" name="leyo_manual" <?=empty($perfil['leyo_manual'])?'':'checked'?> required> <?=$textos['he_leido']?>
								<span class="form-check-sign" id="check_aceptar" data-toggle="tooltip" title="<?=$textos['debe_aceptar']?>">
									<span class="check"></span>
								</span>
								<a href="<?=$textos['link_manual']?>" target="_blank"><?=$textos['ver_manual']?></a>.
								<a href="<?=$textos['link_plan']?>" target="_blank"><?=$textos['ver_plan']?></a>.
								<a href="<?=$iniciativa['link_terminos']?>" target="_blank"><?=$textos['ver_terminos']?></a>.
								<a href="<?=$textos['link_instructivo']?>" target="_blank"><?=$textos['ver_instructivo']?></a>.
								</label>
							</div>
						</div>
					</div>					
					
				</div>
            </div><!-- row paso0 -->