<div class="content">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">person</i>
						</div>
						<h4 class="card-title"><?=(!empty($noticia))?'Modificar':'Crear'?> Noticia</h4>
						
					</div><!-- card-header -->

                	<div class="card-body ">						
						<form id="form" action="iniciativas/perfiles/testSaving" data-parsley-validate class="form-horizontal" method="POST" enctype="multipart/form-data">
					  		<fieldset>
							  <p class="js-form-status-holder"></p>
								<? input_imagen($noticia, 'foto', 'Foto Principal', 'noticias', false)?>
								<? input_text('datetimepicker', $noticia, 'publicada', 'Publicar desde', '', false)?>	
								<? input_text('datetimepicker', $noticia, 'hasta', 'Publicar hasta', '', false)?>	
								<? input_text('text', $noticia, 'titulo', 'Título Noticia', 'Escribir un título sencillo, atractivo', false, 250);?>
								<? input_text('textarea', $noticia, 'bajada', 'Bajada', 'Resumen de la noticia, la información que amplía el título', false, 250);?>
								<? input_text('textarea', $noticia, 'contenido', 'Contenido', '', false, 0, 'tinymce');?>
									
							
								<br/>
								<div class="ln_solid"></div>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button class="btn btn-fill" onclick="window.history.back();" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
									<button class="btn btn-fill btn-rose" type="submit"><i class="material-icons">save</i> Guardar</button>
									</div>
								</div>
							</fieldset>

						</form>

					</div><!-- card-body -->
				</div><!-- card -->
			</div><!-- col-md-12 -->
		</div><!-- row -->
	</div><!-- container-fluid -->
</div><!-- content -->
