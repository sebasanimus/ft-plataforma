
			<div class="row contpaso paso7">
				<div class="col-md-9 col-lg-9 col-xl-7 col-12 mr-auto ml-auto">
					<div class="card card-profile" id="paso10_exito">
						<div class="card-avatar">
							<a href="#pablo">
								<img class="img" src="img/yes.png">
							</a>
						</div>
						<div class="card-body">
							<h6 class="badge badge-success"><?=$textos['ista_submit_titulo_exito']?></h6>
							<h4 class="card-title"><?=$textos['ista_submit_subtitulo_exito']?></h4>
							<p class="card-description"><?=nl2br($textos['ista_submit_descripcion_exito'])?></p>		
							<button type="button" onclick="terminar()"  class="btn btn-dark"><?=$textos['ista_submit_boton']?></button>					
						</div>
					</div>

					<div class="card card-profile" id="paso10_error">
						<div class="card-avatar">
							<a href="#pablo">
								<img class="img" src="img/no.png">
							</a>
						</div>
						<div class="card-body">
							<h6 class="badge badge-success"><?=$textos['ista_submit_titulo_error']?></h6>
							<h4 class="card-title"><?=$textos['ista_submit_subtitulo_error']?></h4>
							<p class="card-description"><?=nl2br($textos['ista_submit_descripcion_error'])?></p>							
						</div>
					</div>
									
					
				</div>
            </div><!-- row paso7 -->