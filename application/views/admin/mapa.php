<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">list</i>
						</div>
						<h4 class="card-title">Administrador del Mapa del proyecto: <a style="color:black" href="<?=base_url()?>admin/propuestas/ver/<?=$propuesta['idpropuesta']?>"><?=$propuesta['titulo_simple']?></a></h4>
						<p class="card-category" style="color:grey"></p>
					</div>
					<div class="card-body">
						
						<div class="row">
							<div class="col-sm-4">
								<h5 style="width:100%; height:51px; line-height:51px">Elementos:</h5>
								<div id="contenedorElementos"></div>
							</div>
							<div class="col-md-8 panelbusqueda">
								
								<div class="toolbar" style="text-align:right; clear:both; height:51px">
									<input type="text" id="direccion"  class="form-control inputbusqueda" name="direccion" maxlength="255" value="" placeholder="Dirección"  autocomplete="off" />
									<input type="text" id="longitud"  class="form-control inputbusqueda" style="width:100px;" name="longitud" maxlength="255" value="" placeholder="Longitud" />
									<input type="text" id="latitud"  class="form-control inputbusqueda" style="width:100px;" name="latitud" maxlength="255" value="" placeholder="Latitud" />

									<button onclick="empezarMarcador()" class="btn btn-warning btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Agregar Punto" >
										<i class="material-icons">room</i>
										<div class="ripple-container"></div>
									</button>
									<button onclick="empezarPoligono()" class="btn btn-warning btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Agregar Área" >
										<i class="material-icons">map</i>
										<div class="ripple-container"></div>
									</button>									
								</div>
								<div id='mapa'></div>
							</div>

						</div>
  						<div class="col-md-12 text-center">
						 	<button class="btn btn-fill" onclick="cancelar()" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
							<button class="btn btn-fill btn-rose" onclick="guardar()"><i class="material-icons">save</i> Guardar Cambios</button>
						</div>


  					</div><!-- end content-->
				</div><!--  end card  -->
			</div><!-- end col-md-12 -->
		</div><!-- end row -->
	</div><!-- end container-fluid -->
</div><!-- end content -->

<div class="modal fade" id="elementoModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Nuevo Elemento</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" id="ele_form" method="" action="">
                        <p class="description text-center">Agregue un elemento al mapa</p>
                        <div class="card-body">
							
							<input type="hidden" value="0" name="idlocal" id="ele_idlocal"/>
							<input type="hidden" value="<?=$idmapa?>" name="idmapa"/>						

							<? modal_input_lenguaje('text', $lenguajes, 'nombre', 'ele', 'Nombre', 'Nombre', 100);?>
							<? modal_input_lenguaje('textarea', $lenguajes, 'descripcion', 'ele', 'Descripción', 'Descripción', 500);?>
							<? modal_input_text('url', 'link', 'ele', 'insert_link', 'Link', 'Link relevante') ?>
							<div class="row" id="row_esppal">
								<label class="col-sm-4 col-form-label" for="ele_esppal">Es el punto principal </label>
								<div class="col-sm-8">									
									<div class="togglebutton" style="margin-top: 15px;">
										<label>
											<input type="checkbox" name="ele_esppal" id="ele_esppal" > 
											<span class="toggle"></span>
										</label>
									</div>
								</div>
							</div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:aplicarModificacion()" id="ele_btn" class="btn btn-primary btn-link btn-wd btn-lg">Aceptar</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="adjuntoModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Nuevo Adjunto</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" method="" action="">
                        <p class="description text-center">Agregue un adjunto al punto</p>
                        <div class="card-body">
												
                            <div class="form-group bmd-form-group" style="text-align:center">                                
								<div class="fileinput fileinput-new" id="fileinputAdjunto" data-provides="fileinput">
									<div class="fileinput-new thumbnail" >
										<img id="adj_thumbnail"  src="material/assets/img/image_placeholder.jpg"  alt="...">
										<span id="adj_thumbnailtext" style="display:none"></span>
									</div>
									<div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
									<div>
										<span class="btn btn-outline-secondary btn-file">
											<span class="fileinput-new">Seleccionar Archivo</span>
											<span class="fileinput-exists">Cambiar</span>
											<input type="file" name="adjunto" id="adjunto" style="z-index:200">
										</span>
										<a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remover</a>
									</div>
								</div>                                
                            </div>
							<input type="hidden" val="0" id="adj_idlocal" />
							<div class="form-group bmd-form-group"  style="text-align:center">
								<div id="progress-wrp" class="progress-container progress-primary">
									<span class="progress-badge">0%</span>
									<div class="progress">
										<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
										</div>
									</div>
								</div>
							</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarAdjunto()" id="adj_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>