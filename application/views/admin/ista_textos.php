<div class="content">
    <div class="container-fluid">

		<div class="row">
           
			<div class="tab-content tab-space tab-subcategories col-md-12">
				<div class="tab-pane active" id="link7">				
					<div class="card ">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">web</i>
							</div>
							<h4 class="card-title">Información en común a todos los Perfiles</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
							
						</div><!-- card-header -->

						<div class="card-body ">
							
							
							<div class="nav-item dropdown opciones-toolbar" style="">	
								<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
									<i class="material-icons text_align-center">more_vert</i>
								</a>
								<div class="dropdown-menu">
									<a class="dropdown-item dropdown-item-rose" href="admin/perfiles/listar">Listar Perfiles</a>
								</div>
							</div>
							<?if(isset($error) && !empty($error)): ?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<i class="material-icons">close</i>
									</button>
									<span>
										<b> Error - </b> <?=$error?>
									</span>
								</div>
							<?endif;?>

							<form id="form" data-parsley-validate class="form-horizontal" method="POST" enctype="multipart/form-data">
							<?$disabled = empty($readonly)? '' : 'disabled' ?>
								<fieldset id="fieldset" <?=$disabled?> >
																		
									<? 
										$area='';
										foreach($campos_lang as $campo){
											if($area!=$campo['area']){
												$area=$campo['area'];
												echo '<br/><br/><h3>'.$area.'</h3><br/><br/>';
											}
											input_lenguaje($campo['tipo'], $lenguajes, $infos, $campo['nombre'], $campo['titulo'], $campo['descripcion'], FALSE, $campo['max']);
										}
									?>
			
						
								<br/>
								</fieldset>
								<div class="ln_solid"></div>
								<div class="form-group <?=empty($readonly)?'':'hidden'?>" id="botonera" >
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<button class="btn btn-fill" onclick="cancelar()" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
										<button class="btn btn-fill btn-rose" type="submit"><i class="material-icons">save</i> Guardar</button>
									</div>
								</div>
							</form>
								
						</div><!-- card-body -->
					</div><!-- card -->
				
				</div><!-- tab-pane -->


			</div>

		</div><!-- end row -->

	</div><!-- container-fluid -->
</div><!-- content -->
