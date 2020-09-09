
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">person</i>
						</div>
						<h4 class="card-title">Administrador de Usuarios</h4>
						<p class="card-category" style="color:grey">Se muestran todos los usuarios del sistema. Pruebe buscar por <b>usuario</b> o <b>tipo</b></p>
					</div>
					<div class="card-body">
						<div class="toolbar" style="text-align:center; clear:both">

							<a href="admin/usuarios/modificar/0" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo" >
								<i class="material-icons">add</i>
								<div class="ripple-container"></div>
							</a>
							
						</div>
						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
									<th>Usuario</th>
									<th>Nombre</th>
									<th>Tipo</th>
									<th>Propuestas</th>
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