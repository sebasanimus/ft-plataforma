<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">web</i>
						</div>
						<h4 class="card-title">Administrador de Webstories</h4>
						<p class="card-category" style="color:grey">Se muestran todos los webstories del sistema. Pruebe buscar por <b>título</b></p>
					</div>
					<div class="card-body">
						<div class="toolbar" style="text-align:center; clear:both">

							<a href="admin/webstories/ver/0" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nueva Webstory" >
								<i class="material-icons">add</i>
								<div class="ripple-container"></div>
							</a>
							<?if($this->session->userdata('role')==1):?>
							<a href="admin/webstories/textos" class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Modificar info y textos en común" >
								<i class="material-icons">short_text</i>
								<div class="ripple-container"></div>
							</a>
							<?endif?>
						</div>
						<div class="table-responsive">
							<table id="midatatable" class="table table-shopping" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th class="disabled-sorting text-center"></th>
										<th>Propuesta</th>
										<th class="th-description">Url</th>
										<th class="th-description">Habilitada</th>
										<th class="disabled-sorting text-right" style="min-width:300px">Acciones</th>
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