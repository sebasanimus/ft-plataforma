<div class="content">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">place</i>
						</div>
						<h4 class="card-title"><?=$breve['nombre']?> En Breve</h4>
						<p class="card-category" style="color:grey">Datos específicos del país</p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						<div class="nav-item dropdown opciones-toolbar" style="">	
							<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons text_align-center">more_vert</i>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item dropdown-item-rose" href="admin/fontagro/modificar">Volver</a>
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
							<?$disabled = (isset($readonly) && $readonly)? 'disabled' : '' ?>
							<fieldset <?=$disabled?> >
								
								<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'contenido', 'Contenido principal. Variables: #miembroDesde, #yaAportado, #aniosMiembro, #consorcios, #totalConsorcios, #aporteFontagro, #consorciosLider, #totalConsorciosLider');?>
								<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'fortalecimiento', 'Contenido: Fortalecimiento');?>	
							
							</fieldset>
							<div class="ln_solid"></div>
							<? if(empty($readonly)): ?>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button class="btn btn-fill" onclick="window.history.back();" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
									<button class="btn btn-fill btn-rose" type="submit"><i class="material-icons">save</i> Guardar</button>
									</div>
								</div>
							<? endif;?>
						</form>


					</div><!-- card-body -->
				</div><!-- card -->
			</div><!-- col-md-12 -->
		</div><!-- row -->
	</div><!-- container-fluid -->
</div><!-- content -->

