<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">list</i>
						</div>
						<h4 class="card-title">Administrador de Organismos Solicitados</h4>
						<p class="card-category" style="color:grey">Pruebe buscar por <b>sigla</b>, <b>nombre</b>, <b>país</b> o <b>usuario</b></p>
					</div>
					<div class="card-body">
						<div class="toolbar" style="text-align:center; clear:both">

							
						</div>
						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Fecha</th>
										<th>Sigla</th>
										<th>Nombre completo</th>
										<th>Link</th>
										<th>País</th>
										<th>Tipo</th>
										<th>Usuario</th>
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


<div class="modal fade" id="organismoModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-rose text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Agregar organismo</h4>                    
					</div>
                </div>
                <div class="modal-body">
					<div class="card-body">
						<input type="hidden" value="0" id="org_idsugerido">
						<p>Se le enviara un mail al investigador avisando que se agregó el organismo</p>
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">flag</i></div>
								</div>
								<select class="selectpicker selectCopado" id="org_pais" data-style="select-with-transition" title="Seleccione País" data-size="7">
								<?foreach($paises as $val):?>							
									<option value="<?=$val['id']?>"><?=$val['nombre']?></option>';
								<?endforeach?>
								</select>
							</div>
						</div>

						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">flag</i></div>
								</div>
								<select class="selectpicker selectCopado" id="org_tipo_institucion" data-style="select-with-transition" title="Seleccione Tipo" data-size="7">
								<?foreach($tipo_institucion as $val):?>							
									<option value="<?=$val['id']?>"><?=$val['nombre']?></option>';
								<?endforeach?>
								</select>
							</div>
						</div>

						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">title</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<input type="text" id="org_nombre" placeholder="Sigla" class="form-control"  maxlength="100" />	
									<span class="bmd-help">Sigla</span>
								</div>
							</div>
						</div>
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">text_fields</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<input type="text" id="org_nombre_largo" placeholder="Nombre completo" class="form-control" maxlength="100" />	
									<span class="bmd-help">Nombre completo</span>
								</div>
							</div>
						</div>
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">link</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<input type="text" id="org_link" placeholder="Link" class="form-control" maxlength="100" />	
									<span class="bmd-help">Link</span>
								</div>
							</div>
						</div>
												
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarOrganismo()" class="btn btn-primary btn-link btn-wd btn-lg">Guardar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rechazoModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-rose text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Rechazar organismo</h4>                    
					</div>
                </div>
                <div class="modal-body">
					<div class="card-body">
						<p>Se le enviara un mail al investigador avisando el motivo del rechazo</p>
						<input type="hidden" value="0" id="rec_idsugerido">
						
						<div class="form-group bmd-form-group">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="material-icons">title</i></div>
								</div>
								<div class="form-group" style="flex: 1 1 auto;">	 
									<textarea id="rec_motivo" placeholder="Motivo" class="form-control"></textarea>	
									<span class="bmd-help">Motivo</span>
								</div>
							</div>
						</div>
												
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:rechazarOrganismo()" class="btn btn-primary btn-link btn-wd btn-lg">Rechazar</a>
                </div>
            </div>
        </div>
    </div>
</div>