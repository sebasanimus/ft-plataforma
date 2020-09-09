<div class="content">
	<form action="iniciativas/perfiles/preseleccionSaving" method="POST" id="formPpal" enctype="multipart/form-data">
		<input type="hidden" name="idperfil" value="<?=$perfil['idperfil']?>" />
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="stepsLineBox pb-4">
						<div class="stepsLine">
							<div class="stepBox step1">
								<span class="number">01</span>
								<span class="stepTxt"><?=$textos['paso_1_preseleccion']?></span>
							</div>
							<div class="stepBox step2">
								<span class="number">02</span>
								<span class="stepTxt"><?=$textos['paso_2_preseleccion']?></span>
							</div>
						</div>
					</div>
					
				</div>
			</div><!-- row -->
		
			<div class="row contpaso paso1">
				<div class="col-md-12">               
			   		<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['paso_1_preseleccion']?></h4>
							</div>
						</div>
				 		<div class="card-body ">
						 	<div class="row">
								<div  id="adjuntoArea1">
									<span class="adentro sinarchivo" style="<?=empty($perfil['adjunto_pre_propuesta'])?'':'display:none'?>">
										Suelte aquí el archivo con la propuesta (word)
									</span>
									<span class="adentro conarchivo" style="<?=empty($perfil['adjunto_pre_propuesta'])?'display:none':''?>">
										<a target="_blank" href="<?=base_url()?>iniciativas/perfiles/descargarPropuesta/<?=$perfil['idperfil']?>"><i class="material-icons">description</i> <span id="archivoNombre1"><?=$perfil['adjunto_pre_propuesta']?></a></span>
									</span>
								</div>
								
								<div id="progress-wrp1" class="progress-container progress-primary" style="text-align:center; width:80%; margin: 0 10%; visibility: hidden;">
									<span class="progress-badge">Subiendo 0%</span>
									<div class="progress">
										<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
										</div>
									</div>
								</div>
								<div class="form-group bmd-form-group" style="text-align:center; width:100%">                                
									<div class="fileinput fileinput-new" id="fileinputAdjunto1" data-provides="fileinput">										
										<div>
											<span class="btn btn-outline-secondary btn-file">
												<span class="fileinput-new"><?=empty($perfil['adjunto_pre_propuesta'])?'Seleccionar':'Cambiar'?> Archivo</span>
												<span class="fileinput-exists">Cambiar Archivo</span>
												<input type="file" name="adjuntofile" id="adjuntofile1" style="z-index:200">
												<input type="hidden" name="adjunto_pre_propuesta" value="<?=$perfil['adjunto_pre_propuesta']?>">
											</span>
										</div>
									</div>                                
								</div>
								<small>
								<?=nl2br($textos['perfil_adjunto_propuesta'])?>
								</small>
							</div>			   			
				 		</div>
			   		</div>
			 	</div><!-- col-md-12 -->
			</div><!-- row paso1 -->

			<div class="row contpaso paso2">
				<div class="col-md-12">               
			   		<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['paso_2_preseleccion']?></h4>
							</div>
						</div>
						<div class="card-body ">
						 	<div class="row">
								<div id="adjuntoArea2">
									<span class="adentro sinarchivo" style="<?=empty($perfil['adjunto_pre_presupuesto'])?'':'display:none'?>">
										Suelte aquí el archivo con el presupuesto (excel)
									</span>
									<span class="adentro conarchivo" style="<?=empty($perfil['adjunto_pre_presupuesto'])?'display:none':''?>">
										<a target="_blank" href="<?=base_url()?>iniciativas/perfiles/descargarPresupuesto/<?=$perfil['idperfil']?>"><i class="material-icons">description</i> <span id="archivoNombre2"><?=$perfil['adjunto_pre_presupuesto']?></a></span>
									</span>
								</div>
								
								<div id="progress-wrp2" class="progress-container progress-primary" style="text-align:center; width:80%; margin: 0 10%; visibility: hidden;">
									<span class="progress-badge">Subiendo 0%</span>
									<div class="progress">
										<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
										</div>
									</div>
								</div>
								<div class="form-group bmd-form-group" style="text-align:center; width:100%">                                
									<div class="fileinput fileinput-new" id="fileinputAdjunto2" data-provides="fileinput">										
										<div>
											<span class="btn btn-outline-secondary btn-file">
												<span class="fileinput-new"><?=empty($perfil['adjunto_pre_presupuesto'])?'Seleccionar':'Cambiar'?> Archivo</span>
												<span class="fileinput-exists">Cambiar Archivo</span>
												<input type="file" name="adjuntofile2" id="adjuntofile2" style="z-index:200">
												<input type="hidden" name="adjunto_pre_presupuesto" value="<?=$perfil['adjunto_pre_presupuesto']?>">
											</span>
										</div>
									</div>                                
								</div>
								<small>
								<?=nl2br($textos['perfil_adjunto_presupuesto'])?>
								</small>
							</div>			   			
				 		</div>
					</div>
				</div>
			</div>

			<div class="row contpaso paso3">
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
							<p class="card-description"><?=nl2br($textos['submit_descripcion_exito_pre'])?></p>	
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
							<p class="card-description"><?=nl2br($textos['submit_descripcion_error_pre'])?></p>							
						</div>
					</div>	
					
				</div>
            </div><!-- row paso3 -->

			<div class="container-fluid text-right">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-6 text-left">
							<button type="button" id="anterior" class="btn btn-light"><?=$textos['anterior']?></button>
						</div>
						<div class="col-sm-6 text-right">
							<button type="button" id="guardar" class="btn btn-primary"><?=$textos['guardar']?></button>
							<button type="button" id="siguiente" class="btn btn-dark"><?=$textos['siguiente']?></button>
						</div>
					</div>					
				</div>
          	</div>

		</div><!-- container-fluid -->
	</form>
</div><!-- content -->
