<div class="content">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">person</i>
						</div>
						<h4 class="card-title"><?=(!empty($iniciativa))?'Modificar':'Crear'?> Iniciativa</h4>
						<p class="card-category" style="color:grey"></p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						<div class="nav-item dropdown opciones-toolbar" style="">	
							<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons text_align-center">more_vert</i>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item dropdown-item-rose" href="admin/iniciativas/listar">Listar Iniciativas</a>
								<?if(!empty($idiniciativa)):?>
									<a class="dropdown-item dropdown-item-rose" href="admin/iniciativas/modificar/<?=$idiniciativa?>">Modificar iniciativa</a>
								<?endif?>
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
					  		<fieldset <?=empty($readonly) ? '' : 'disabled'?> >
							<? input_lenguaje('text', $lenguajes, $datas_lang, 'titulo', 'Título Iniciativa', 'Escribir un título', TRUE, 120);?>
							<? input_select($iniciativa, $tipos, 'idoperacion', 'Tipo', TRUE);?>
							<? input_select($iniciativa, $estados, 'idestado', 'Estado', TRUE);?>
							<? input_text('text', $iniciativa, 'identificador', 'Identificador', '', FALSE, 100)?>
							<? input_text('datetimepicker', $iniciativa, 'fecha_desde', 'Publicar desde (GMT)', '', TRUE)?>	
							<? input_text('datetimepicker', $iniciativa, 'fecha_hasta', 'Publicar hasta (GMT)', '', TRUE)?>	
							<? input_text('datetimepicker', $iniciativa, 'fecha_preseleccion', 'Fecha Limite Propuesta Preseleccion (GMT)', '', TRUE)?>	
							<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'descripcion', 'Descripción', 'Resumen de la iniciativa, la información que amplía el título', false);?>

							<? input_lenguaje('text', $lenguajes, $datas_lang, 'link_terminos', 'Link a términos', 'Términos de referencia', FALSE, 100);?>
							<? input_imagen($iniciativa, 'foto', 'Foto Principal', 'noticias', false)?>		
							
							<? input_text('url', $iniciativa, 'link_preseleccionados', 'Link Preseleccionados', '', FALSE, 255)?>
							<? input_text('url', $iniciativa, 'link_ganadores', 'Link Ganadores', '', FALSE, 255)?>

							<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'html_intro', 'Intro', '', false, 0);?>
							<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'html_parte1', 'HTML parte 1', '', false, 0, 'tinymce');?>
							<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'html_parte2', 'HTML parte 2', '', false, 0, 'tinymce');?>

							<br/>
							<div class="ln_solid"></div>
							<?if(empty($readonly)):?>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button class="btn btn-fill" onclick="window.history.back();" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
									<button class="btn btn-fill btn-rose" type="submit"><i class="material-icons">save</i> Guardar</button>
									</div>
								</div>
							<?endif?>
							</fieldset>

						</form>

					</div><!-- card-body -->
				</div><!-- card -->
			</div><!-- col-md-12 -->
		</div><!-- row -->
	</div><!-- container-fluid -->
</div><!-- content -->
