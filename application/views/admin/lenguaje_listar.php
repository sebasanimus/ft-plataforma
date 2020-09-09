<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">language</i>
						</div>
						<h4 class="card-title">Administrador de Lenguajes</h4>
						<p class="card-category" style="color:grey">Se muestran todos las lenguajes del sistema. Pruebe buscar por <b>nombre</b></p>
					</div>
					<div class="card-body">
						<div class="toolbar" style="text-align:center; clear:both">

							<!--<a href="admin/lenguajes/modificar/0" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo" >
								<i class="material-icons">add</i>
								<div class="ripple-container"></div>
							</a>-->
							<?if($this->session->userdata('role')==1):?>
							<a href="admin/webstories/textos" class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Modificar info y textos en común" >
								<i class="material-icons">short_text</i>
								<div class="ripple-container"></div>
							</a>
							<?endif?>
							
						</div>
						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Id</th>
										<th>Nombre</th>
										<th>Código</th>
										<th>Habilitado</th>
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