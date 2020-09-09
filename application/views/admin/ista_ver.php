<div class="content">
	<div class="container-fluid">
		<div class="header text-center">
            <h3 class="title"><?=$propuesta['identificador']?> - <?=$ista['titulo_simple']?></h3>
            <p class="category"><?=$callista['titulo']?>: <?=$callista['descripcion']?></p>
        </div>
		<div class="row">

			<div class="col-lg-2 col-md-4">
                <ul class="nav nav-pills nav-pills-rose flex-column" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#link0" role="tablist">Info General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link01" role="tablist">01 - <?=$textos['ista_paso_1']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link02" role="tablist">02 - <?=$textos['ista_paso_2']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link03" role="tablist">03 - <?=$textos['ista_paso_3']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link04" role="tablist">04 - <?=$textos['ista_paso_4']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link05" role="tablist">05 - <?=$textos['ista_paso_5']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link06" role="tablist">06 - <?=$textos['ista_paso_6']?></a>
                    </li>
                </ul>
			</div>
			
            <div class="col-lg-10 col-md-8">
                <div class="tab-content">
                    <div class="tab-pane active" id="link0">
						<div class="row contpaso paso0">
							<div class="col-md-12">               
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
											<h4 class="card-title">Info General</h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> Usuarios</label>
													<?foreach($usuarios as $usuario):?>
													<label class="form-control"><?=$usuario['nombre']?> - <?=$usuario['email']?> - <?=$usuario['institucion']?> - <?=$usuario['posicion']?></label>
													<?endforeach?>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> Porcentaje completo</label>
													<label class="form-control"><?=$ista['porcentaje']?> %</label>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> Última vez guardado</label>
													<label class="form-control"><?=fromYYYYMMDDtoDDMMYYY($ista['actualizado'],false)?></label>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> Envíado</label>
													<label class="form-control">
													 <?if(empty($ista['enviado'])):?>
													 	<span class="badge badge-pill badge-default"><i class="fa fa-times fa-fw" aria-hidden="true"></i></span>
													 <?else:?>
														<span class="badge badge-pill badge-success" title="<?=fromYYYYMMDDtoDDMMYYY($ista['enviado'],false)?>"><i class="fa fa-check fa-fw" aria-hidden="true"></i></span>
													 <?endif?>
													</label>
												</div>
											</div>
											<?foreach($rechazos as $rechazo):?>
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating">Revisión <?=fromYYYYMMDDtoDDMMYYY($rechazo['created'],false)?> - <?=$rechazo['nombre']?> (<?=$rechazo['email']?>)</label>
													<label class="form-control"><?=$rechazo['comentario']?></label>
												</div>
											</div>
											<?endforeach?>
											<?if(!empty($ista['enviado'])):?>
											<div class="col-12">
												<div class="form-group">
													<button class="btn btn-danger btn-fill" onclick="abrirModalRechazo();" type="button">Solicitar Revisión</button>
												</div>
											</div>
											<?endif?>
										</div>
									</div>
								</div>
							</div><!-- col-md-12 -->
						</div><!-- row paso0 -->
                    </div>
                    <div class="tab-pane" id="link01">
						<div class="row contpaso paso1">
							<div class="col-md-12">
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
										<h4 class="card-title"><?=$textos['ista_paso_1']?></h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">
											<div class="col-12">
												<div class="form-group">
													<label for="title" class="bmd-label-floating"> <?=$textos['ista_investigador']?> *</label>
													<label class="form-control" id="investigador"><?=$ista['investigador']?></label>
													<small><?=$textos['ista_investigador_descripcion']?></small>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="objetivo" class="bmd-label-floating"> <?=$textos['ista_objetivo']?> *</label>
													<label class="form-control"><?=$ista['objetivo']?></label>
													<small><?=$textos['ista_objetivo_descripcion']?></small>
												</div>
											</div>
										</div>
										<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
									</div>
								</div>
							</div>
						</div><!-- row paso1 -->
                    </div>
                    <div class="tab-pane" id="link02">
						<div class="row contpaso paso2">
							<div class="col-md-12">
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
										<h4 class="card-title"><?=$textos['ista_paso_2']?></h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">								
											<div class="col-12">
												<div class="form-group">
													<label for="resumen_ejecutivo" class="bmd-label-floating"> <?=$textos['ista_resumen_ejecutivo']?> *</label>
													<label class="form-control"><?=$ista['resumen_ejecutivo']?></label>
													<small><?=$textos['ista_resumen_ejecutivo_descripcion']?></small>
												</div>
											</div>							
											<div class="col-12">
												<div class="form-group">
													<label for="resultados" class="bmd-label-floating"> <?=$textos['ista_resultados']?> *</label>
													<label class="form-control" name="resultados" id="resultados" rows="5" required="true" maxlength="4000"><?=$ista['resultados']?></label>
													<small><?=$textos['ista_resultados_descripcion']?></small>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="productos" class="bmd-label-floating"> <?=$textos['ista_productos']?> *</label>
													<label class="form-control"><?=$ista['productos']?></label>
													<small><?=$textos['ista_productos_descripcion']?></small>
												</div>
											</div>
										</div>
										<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
									</div>
								</div>
							</div><!-- col-md-12 -->
						</div><!-- row paso2 -->
                    </div>
                    <div class="tab-pane" id="link03">
						<div class="row contpaso paso3">
							<div class="col-md-12">
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
										<h4 class="card-title"><?=$textos['ista_paso_3']?></h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">								
											<div class="col-12">
												<div class="form-group">
													<label for="hallazgos" class="bmd-label-floating"> <?=$textos['ista_hallazgos']?> *</label>
													<label class="form-control" ><?=$ista['hallazgos']?></label>
													<small><?=$textos['ista_hallazgos_descripcion']?></small>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="innovaciones" class="bmd-label-floating"> <?=$textos['ista_innovaciones']?> *</label>
													<label class="form-control"><?=$ista['innovaciones']?></label>
													<small><?=$textos['ista_innovaciones_descripcion']?></small>
												</div>
											</div>
										</div>
										<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
									</div>
								</div>
							</div><!-- col-md-12 -->	
						</div><!-- row paso3 -->
                    </div>
                    <div class="tab-pane" id="link04">						
						<div class="row contpaso paso4">
							<div class="col-md-12">
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
										<h4 class="card-title"><?=$textos['ista_paso_4']?></h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">								
											<div class="col-12">
												<div class="form-group">
													<label for="historias" class="bmd-label-floating"> <?=$textos['ista_historias']?> *</label>
													<label class="form-control" ><?=$ista['historias']?></label>
													<small><?=$textos['ista_historias_descripcion']?></small>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="oportunidades" class="bmd-label-floating"> <?=$textos['ista_oportunidades']?> *</label>
													<label class="form-control" ><?=$ista['oportunidades']?></label>
													<small><?=$textos['ista_oportunidades_descripcion']?></small>
												</div>
											</div>
										</div>
										<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
									</div>
								</div>
							</div><!-- col-md-12 -->
						</div><!-- row paso4 -->
                    </div>
                    <div class="tab-pane" id="link05">
						<div class="row contpaso paso5">
							<div class="col-md-12">
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
										<h4 class="card-title"><?=$textos['ista_paso_5']?></h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">								
											<div class="col-12">
												<div class="form-group">
													<label for="articulacion" class="bmd-label-floating"> <?=$textos['ista_articulacion']?> *</label>
													<label class="form-control" ><?=$ista['articulacion']?></label>
													<small><?=$textos['ista_articulacion_descripcion']?></small>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="gestion" class="bmd-label-floating"> <?=$textos['ista_gestion']?> *</label>
													<label class="form-control" ><?=$ista['gestion']?></label>
													<small><?=$textos['ista_gestion_descripcion']?></small>
												</div>
											</div>
										</div>
										<div class="category form-category">* <?=$textos['ista_datos_requeridos']?></div>
									</div>
								</div>
							</div><!-- col-md-12 -->
							

						</div><!-- row paso5 -->
                    </div>
                    <div class="tab-pane" id="link06">	
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
													Sin archivo
												</span>
												<span class="adentro conarchivo" style="<?=empty($ista['adjunto'])?'display:none':''?>">
													<a target="_blank" href="<?=base_url()?>admin/istas/descargarAdjunto/<?=$ista['idista']?>"><i class="material-icons">description</i> <span id="archivoNombre"><?=$ista['adjunto']?></a></span>
												</span>
											</div>										
											
											<small>
											<?=nl2br($textos['ista_adjunto_descripcion'])?>
											</small>
										</div>			   			
									</div>
								</div>
							</div><!-- col-md-12 -->
						</div><!-- row paso6 -->
                    </div>
                </div>
            </div>
			 
			<div style="width:100%; text-align:center">
				<button class="btn btn-fill" onclick="window.history.back();" type="button"><i class="material-icons">keyboard_arrow_left</i> Volver</button>
			</div>
				
		</div><!-- end row -->
	</div><!-- end container-fluid -->
</div><!-- end content -->


<div class="modal fade" id="rechazoModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-rose text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Solicitar Revisión ISTA</h4>                    
					</div>
                </div>
                <div class="modal-body">
					<div class="card-body">
						<p>Indique los ajustes solicitados. El sistema enviará una notificación con este mensaje al investigador.</p>
												
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">text_fields</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<textarea id="motivo" placeholder="Motivo" class="form-control" rows="8"></textarea>	
									<span class="bmd-help">Motivo</span>
								</div>
							</div>
						</div>
												
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:rechazar()" class="btn btn-primary btn-link btn-wd btn-lg">Solicitar Revisión</a>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
#adjuntoArea{
	width: 80%;
	height: 300px;
	text-align: center;
	border-width: 2px;
	border-color: #BBBBBB;
	border-style: dashed;
	clear: both;
	display: block;
	margin: 10px 10%;
	border-radius: 20px;
}
#adjuntoArea.highlight{
	background-color: rgba(0,0,255,0.2);
}
#adjuntoArea .adentro {
	display: block;
	font-size: 25px;
	line-height: 300px;
}
</style>