

			<div class="row contpaso paso6">
				<div class="col-md-12">               
			   		<div class="card ">
						<div class="card-header card-header-rose card-header-text">
							<div class="card-text">
								<h4 class="card-title"><?=$textos['ista_paso_6']?></h4>
							</div>
						</div>
				 		<div class="card-body ">
						 	<div class="row">
								<div  id="adjuntoArea">
									<span class="adentro sinarchivo" style="<?=empty($ista['adjunto'])?'':'display:none'?>">
										Suelte aquí el archivo
									</span>
									<span class="adentro conarchivo" style="<?=empty($ista['adjunto'])?'display:none':''?>">
										<a target="_blank" href="<?=base_url()?>admin/istas/descargarAdjunto/<?=$ista['idista']?>"><i class="material-icons">description</i> <span id="archivoNombre"><?=$ista['adjunto']?></a></span>
									</span>
								</div>
								
								<div id="progress-wrp" class="progress-container progress-primary" style="text-align:center; width:80%; margin: 0 10%; visibility: hidden;">
									<span class="progress-badge">Subiendo 0%</span>
									<div class="progress">
										<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
										</div>
									</div>
								</div>
								<div class="form-group bmd-form-group" style="text-align:center; width:100%">                                
									<div class="fileinput fileinput-new" id="fileinputAdjunto" data-provides="fileinput">										
										<div>
											<span class="btn btn-outline-secondary btn-file">
												<span class="fileinput-new"><?=empty($ista['adjunto'])?'Seleccionar':'Cambiar'?> Archivo</span>
												<span class="fileinput-exists">Cambiar Archivo</span>
												<input type="file" name="adjuntofile" id="adjuntofile" style="z-index:200">
												<input type="hidden" name="adjunto" value="<?=$ista['adjunto']?>">
											</span>
										</div>
									</div>                                
								</div>
								<small>
								<?=nl2br($textos['ista_adjunto_descripcion'])?>
								</small>
							</div>			   			
				 		</div>
			   		</div>
			 	</div><!-- col-md-12 -->
			</div><!-- row paso6 -->