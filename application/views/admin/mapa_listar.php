<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">list</i>
						</div>
						<h4 class="card-title">Administrador de Mapas del proyecto: <?=$propuesta['titulo_simple']?></h4>
						<p class="card-category" style="color:grey">Se muestran todos los mapas del sistema. Pruebe buscar por <b>nombre</b></p>
					</div>
					<div class="card-body">
						<div class="toolbar" style="text-align:center; clear:both">

							<button onclick="abrirModalMapa()"  class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Mapa" >
								<i class="material-icons">add</i>
								<div class="ripple-container"></div>
							</button>
							
						</div>
						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Descripción</th>
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

<div class="modal fade" id="mapaModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Nuevo Mapa</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" id="map_form" method="" action="">
                        <p class="description text-center">Agregue un mapa a la propuesta</p>
                        <div class="card-body">
							
							<input type="hidden" value="0" name="idmapa" id="map_idmapa"/>
							<input type="hidden" value="<?=$idpropuesta?>" name="idpropuesta"/>						

							<? modal_input_lenguaje('text', $lenguajes, 'nombre', 'map', 'Nombre', 'Nombre', 100);?>
							<? modal_input_lenguaje('textarea', $lenguajes, 'descripcion', 'map', 'Descripción', 'Descripción', 500);?>

                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarMapa()" id="map_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>