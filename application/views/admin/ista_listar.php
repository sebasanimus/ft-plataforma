<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">list</i>
						</div>
						<h4 class="card-title">Administrador de Istas: <b><?=$callista['titulo']?></b></h4>
						<p class="card-category" style="color:grey">Se muestran los istas. Pruebe buscar por <b>titulo</b> o <b>identificador</b> </p>
					</div>
					<div class="card-body">
						<div class="toolbar" style="text-align:center; clear:both">
							
							<a href="javascript:abrirModalNotificacion()"  class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Crear Alerta" >
								<i class="material-icons">notifications_active</i>
								<div class="ripple-container"></div>
							</a>

							<a href="<?=base_url().'admin/istas/descargar/'.$idcallista?>"  class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Descargar CSV" >
								<i class="material-icons">contact_mail</i>
								<div class="ripple-container"></div>
							</a>
							
							<a href="<?=base_url().'admin/exportarpdf/convocatoriaIstas/'.$idcallista?>"  class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Descargar los PDF de los istas enviados" >
								<i class="material-icons">picture_as_pdf</i>
								<div class="ripple-container"></div>
							</a>
							
							
						</div>
						<br/>
						<div class="row">
                			<div class="col-4">
								Desde: <code><?=$callista['fecha_desde']?> (GMT)</code>
							</div>
                			<div class="col-4">
								Hasta: <code><?=$callista['fecha_hasta']?> (GMT)</code>
							</div>
                			<div class="col-4">
								Inscriptos: <code><?=$estadisticas['total']?></code>
							</div>
                			<div class="col-4">
								Promedio completitud: <code><?=round($estadisticas['promedio'])?>%</code>
							</div>
                			<div class="col-4">
								Enviados: <code><?=$estadisticas['completos']?></code>
							</div>
                			<div class="col-4">
								Última semana: <code><?=$estadisticas['semana']?> ingresos</code>
							</div>
						</div>
						<br/><br/>
						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Id</th>
										<th>Titulo</th>
										<th>Porcentaje</th>
										<th>Último</th>
										<th>Enviado</th>
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
						<input type="hidden" value="<?=$idcallista?>" id="al_idcallista">
						<p>Se creará una alerta para los investigadores de esta Ista. Se les enviará mail a todos aquellos que no hayan deshabilitado esa opción.</p>
						<!--<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">people</i></div>
								</div>
								<select class="selectpicker selectCopado" id="al_quienes" data-style="select-with-transition" title="A quienes" data-size="3">														
									<option value="1">A Todos</option>
									<option value="2">Solo con el ista completo</option>
									<option value="3">Solo con el ista INcompleto</option>
								</select>
							</div>
						</div>-->

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