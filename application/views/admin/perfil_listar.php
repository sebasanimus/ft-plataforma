<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">list</i>
						</div>
						<h4 class="card-title">Administrador de Perfiles de la iniciativa: <b><?=$iniciativa['titulo']?></b></h4>
						<p class="card-category" style="color:grey">Se muestranlos perfiles de la iniciativa . Pruebe buscar por <b>titulo</b>, <b>usuario</b> o <b>mail</b></p>
					</div>
					<div class="card-body">
						<div class="toolbar" style="text-align:center; clear:both">
							
							<a href="javascript:abrirModalNotificacion()"  class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Crear Alerta" >
								<i class="material-icons">notifications_active</i>
								<div class="ripple-container"></div>
							</a>

							<a href="<?=base_url().'admin/perfiles/descargar/'.$idiniciativa?>"  class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Descargar CSV" >
								<i class="material-icons">contact_mail</i>
								<div class="ripple-container"></div>
							</a>
							
							<a href="<?=base_url().'admin/exportarpdf/convocatoria/'.$idiniciativa?>"  class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Descargar los PDF de los perfiles completos" >
								<i class="material-icons">picture_as_pdf</i>
								<div class="ripple-container"></div>
							</a>
							
							<a href="<?=base_url().'admin/perfiles/descargarResumen/'.$idiniciativa?>"  class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Descargar el resumen de los perfiles completos" >
								<i class="material-icons">table_chart</i>
								<div class="ripple-container"></div>
							</a>
							
							<a href="<?=base_url().'admin/exportarpdf/convocatoriaPre/'.$idiniciativa?>"  class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Descargar la pre-seleccion" >
								<i class="material-icons">description</i>
								<div class="ripple-container"></div>
							</a>

							<a href="<?=base_url().'admin/exportarpdf/convocatoriaSel/'.$idiniciativa?>"  class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Descargar la Seleccion" >
								<i class="material-icons">assignment</i>
								<div class="ripple-container"></div>
							</a>
							
						</div>
						<br/>
						<div class="row">
                			<div class="col-4">
								Tipo: <code><?=$iniciativa['tipo']?></code>
							</div>
                			<div class="col-4">
								Desde: <code><?=$iniciativa['fecha_desde']?> (GMT)</code>
							</div>
                			<div class="col-4">
								Hasta: <code><?=$iniciativa['fecha_hasta']?> (GMT)</code>
							</div>
                			<div class="col-4">
								Inscriptos: <code><?=$estadisticas['total']?></code>
							</div>
                			<div class="col-4">
								Promedio completitud: <code><?=round($estadisticas['promedio'])?>%</code>
							</div>
                			<div class="col-4">
								Completos: <code><?=$estadisticas['completos']?></code>
							</div>
                			<div class="col-4">
								Última semana: <code><?=$estadisticas['semana']?> ingresos</code>
							</div>
                			<div class="col-4">
								Preseleccionados: <code><?=$estadisticas['preseleccionados']?> (<?=$estadisticas['preseleccionados_completos']?> completos)</code>
							</div>
                			<div class="col-4">
								Seleccionados: <code><?=$estadisticas['seleccionados']?> (<?=$estadisticas['seleccionados_completos']?> completos)</code>
							</div>
						</div>
						<br/><br/>
						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Id</th>
										<th>Titulo</th>
										<th>Usuario</th>
										<th>Email</th>
										<th>Porcentaje</th>
										<th>Último</th>
										<th>Estado</th>
										<th>Pre</th>
										<th>Sel</th>
										<th class="disabled-sorting text-right">Acciones</th>
									</tr>
								</thead>                     
								<tbody>
								</tbody>
							</table>  
						</div>
					</div><!-- end content-->
				</div><!--  end card  -->
			</div><!-- end col-md-12 -->
		</div><!-- end row -->
	</div><!-- end container-fluid -->
</div><!-- end content -->


<div class="modal fade" id="alertaModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-rose text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Crear Alerta</h4>                    
					</div>
                </div>
                <div class="modal-body">
					<div class="card-body">
						<input type="hidden" value="<?=$idiniciativa?>" id="al_idiniciativa">
						<p>Se creará una alerta para los investigadores de esta iniciativa. Se les enviará mail a todos aquellos que no hayan deshabilitado esa opción.</p>
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">people</i></div>
								</div>
								<select class="selectpicker selectCopado" id="al_quienes" data-style="select-with-transition" title="A quienes" data-size="6">														
									<option value="1">A Todos</option>
									<option value="2">Solo con el perfil completo</option>
									<option value="3">Solo con el perfil INcompleto</option>
									<option value="4">Solo en estado Inicial</option>
									<option value="5">Solo en estado Pre-seleccionado</option>
									<option value="6">Solo en estado Seleccionado</option>
								</select>
							</div>
						</div>

						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">title</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<input type="text" id="al_titulo" placeholder="Título" class="form-control"  maxlength="255" />	
									<span class="bmd-help">Título</span>
								</div>
							</div>
						</div>
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">text_fields</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<textarea id="al_contenido" placeholder="Contenido" class="form-control" rows="5"></textarea>	
									<span class="bmd-help">Contenido</span>
								</div>
							</div>
						</div>
												
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:crearAlerta()" class="btn btn-primary btn-link btn-wd btn-lg">Crear</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="estadoModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-rose text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Cambiar Estado</h4>                    
					</div>
                </div>
                <div class="modal-body">
					<div class="card-body">
						<input type="hidden" value="0" id="es_idperfil">
						<p>Cambiar el estado del perfil "<span id="es_titulo"></span>"</p>
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">local_offer</i></div>
								</div>
								<select class="selectpicker selectCopado" id="es_estado" data-style="select-with-transition" title="Estado" data-size="3">														
									<?foreach($estados as $estado):?>
										<option value="<?=$estado['idestadoperfil']?>"><?=$estado['nombre']?></option>
									<?endforeach?>
								</select>
							</div>
						</div>
																
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:cambiarEstado()" class="btn btn-primary btn-link btn-wd btn-lg">Cambiar</a>
                </div>
            </div>
        </div>
    </div>
</div>