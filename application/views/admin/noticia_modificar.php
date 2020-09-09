<div class="content">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">person</i>
						</div>
						<h4 class="card-title"><?=(!empty($noticia))?'Modificar':'Crear'?> Noticia  del proyecto: <a style="color:black" href="<?=base_url()?>admin/propuestas/<?=$this->session->userdata('role')==4? 'investigador':'ver'?>/<?=$propuesta['idpropuesta']?>"><?=$propuesta['titulo_simple']?></a></h4>
						<p class="card-category" style="color:grey"></p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						<div class="nav-item dropdown opciones-toolbar" style="">	
							<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons text_align-center">more_vert</i>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item dropdown-item-rose" href="admin/noticias/listar/<?=$propuesta['idpropuesta']?>">Listar Noticias</a>
								<?if(!empty($idnoticia)):?>
									<a class="dropdown-item dropdown-item-rose" href="admin/noticias/modificar/<?=$propuesta['idpropuesta']?>/<?=$idnoticia?>">Modificar noticia</a>
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

							<? input_imagen($noticia, 'foto', 'Foto Principal', 'noticias', false)?>
							<? input_text('datetimepicker', $noticia, 'publicada', 'Publicar desde', '', false)?>	
							<? input_text('datetimepicker', $noticia, 'hasta', 'Publicar hasta <br>(dejar vacio para que no se despublique)', '', false)?>	
							<? input_lenguaje('text', $lenguajes, $datas_lang, 'titulo', 'Título Noticia', 'Escribir un título sencillo, atractivo', false, 250);?>
							<? input_select($noticia, $tiposnoticia, 'idtiponoticia', 'Tipo', TRUE);?>
							<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'bajada', 'Bajada', 'Resumen de la noticia, la información que amplía el título', false, 250);?>
							<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'contenido', 'Contenido', '', false, 0, 'tinymce');?>
							<?if($this->session->userdata('role')==4):?>	
							<? input_check($noticia, 'publica_inv', 'Lista para revisar', true)?>
							<?else:?>
							<? input_check($noticia, 'aprobada_admin', 'Aprobada', true)?>		
							<?endif?>
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
