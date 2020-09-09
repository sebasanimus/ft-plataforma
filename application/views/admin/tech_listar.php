<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">picture_as_pdf</i>
						</div>
						<h4 class="card-title">Administrador de Tech</h4>
						<p class="card-category" style="color:grey">Se muestran todos los webstories del sistema. Pruebe buscar por <b>título</b></p>
					</div>
					<div class="card-body">
						<div class="toolbar" style="text-align:center; clear:both">

							<button onclick="abrirModalTech()" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Tech" >
								<i class="material-icons">add</i>
								<div class="ripple-container"></div>
							</button>
							<!--<a href="admin/webstories/textos" class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Modificar info y textos en común" >
								<i class="material-icons">short_text</i>
								<div class="ripple-container"></div>
							</a>-->			

						</div>
						<div class="table-responsive">
							<table id="midatatable" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Propuesta</th>
										<th>Webstory</th>
										<th>Título Tech</th>
										<th class="th-description">Habilitado</th>
										<th class="disabled-sorting text-right" style="min-width:150px">Acciones</th>
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


<div class="modal fade" id="techModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Nuevo fontagro Tech</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" id="tech_form" method="" action="">
                        <div class="card-body">							
							<div class="row">
								<label class="col-sm-12 col-form-label" for="idpropuesta" style="text-align:center">Propuesta</label>
								<div class="col-sm-12">
									<div class="form-group">
										<select class="form-control" name="idpropuesta" id="idpropuesta"></select>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-12 col-form-label" for="idwebstory" style="text-align:center">Webstory</label>
								<div class="col-sm-12">
									<div class="form-group">
										<select class="form-control" name="idwebstory" id="idwebstory"></select>
									</div>
								</div>
							</div>						

                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarTech()" id="tech_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>