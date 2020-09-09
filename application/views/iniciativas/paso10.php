
			<div class="row contpaso paso10">
				<div class="col-md-9 col-lg-9 col-xl-7 col-12 mr-auto ml-auto">
					<div class="card card-profile" id="paso10_exito">
						<div class="card-avatar">
							<a href="#pablo">
								<img class="img" src="img/yes.png">
							</a>
						</div>
						<div class="card-body">
							<h6 class="badge badge-success"><?=$textos['submit_titulo_exito']?></h6>
							<h4 class="card-title"><?=$textos['submit_subtitulo_exito']?></h4>
							<p class="card-description"><?=nl2br($textos['submit_descripcion_exito'])?></p>		
							<div class="toolbar" style="text-align:center; clear:both">
								<a href="<?=base_url()?>admin/exportarpdf/generarPerfil/<?=$perfil['idperfil']?>" target="_blank" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="" data-original-title="Descargar el PDF del perfil completo">
									<i class="material-icons">picture_as_pdf</i>
									<div class="ripple-container"></div>
								</a>
							</div>					
						</div>
					</div>

					<div class="card card-profile" id="paso10_error">
						<div class="card-avatar">
							<a href="#pablo">
								<img class="img" src="img/no.png">
							</a>
						</div>
						<div class="card-body">
							<h6 class="badge badge-success"><?=$textos['submit_titulo_error']?></h6>
							<h4 class="card-title"><?=$textos['submit_subtitulo_error']?></h4>
							<p class="card-description"><?=nl2br($textos['submit_descripcion_error'])?></p>							
						</div>
					</div>
									
					
				</div>
            </div><!-- row paso10 -->