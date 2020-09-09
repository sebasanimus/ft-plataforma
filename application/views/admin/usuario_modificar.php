<div class="content">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">person</i>
						</div>
						<h4 class="card-title"><?=(!empty($usuario))?'Modificar':'Crear'?> Usuario</h4>
						<p class="card-category" style="color:grey"><?=(!empty($usuario))?'Deje el password vacio para no modificarlo':'Cree un nuevo acceso al sistema'?></p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						<div class="nav-item dropdown opciones-toolbar" style="">	
							<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons text_align-center">more_vert</i>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item dropdown-item-rose" href="admin/usuarios/listar">Listar Usuarios</a>
								<?if(!empty($idusuario)):?>
									<a class="dropdown-item dropdown-item-rose" href="admin/usuarios/modificar/<?=$idusuario?>">Modificar usuario</a>
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
							
							<div class="row">
								<label class="col-sm-2 col-form-label" for="idtipousuario">Tipo <span class="required">*</span></label>
								<div class="col-sm-10">
									<div class="form-group">
										<select class="selectpicker form-control alcien" id="idtipousuario" name="idtipousuario" required="required" data-style="select-with-transition" title="Seleccione..." data-size="5">
											<? foreach($tipousuario as $tipo) :?>
												<option value="<?=$tipo->idtipousuario?>" <?=(!empty($usuario) && $usuario['idtipousuario']==$tipo->idtipousuario)?'SELECTED':''?> ><?=$tipo->tipo?></option>
											<? endforeach;?>
										</select>
									</div>
								</div>
							</div>

							<?=input_text('email', $usuario, 'email', 'Email', 'Email único para ingresar al sistema', true)?>

							<?if(empty($readonly)):?>
							<?=input_text('password', array(), 'password', 'Password', '', empty($usuario))?>
							<?=input_text('password', array(), 'password-confirm', 'Confirmar Password', '', empty($usuario))?>
							<?endif?>

							<?=input_text('text', $usuario, 'nombre', 'Nombre', 'Nombre y Apellido', false)?>
							<?=input_text('text', $usuario, 'institucion', 'Institución', 'Institución que representa', false)?>
							<?=input_text('text', $usuario, 'posicion', 'Posición', 'Posición en la institución', false)?>

							<div class="row">
								<label class="col-sm-2 col-form-label" for="avatar">Avatar <span class="required">*</span></label>
								<div class="col-sm-10">
									<div class="form-group">
										<?if(empty($readonly)):?>
										<select class="image-picker show-html form-control" name="avatar">
											<option data-img-src="img/avatar/01.png" data-img-class="first" data-img-alt="Avatar 1" value="01" <?=(!empty($usuario) && $usuario['avatar']=='01')?'selected':''?> >  Avatar 1  </option>
											<option data-img-src="img/avatar/02.png" data-img-alt="Avatar 2" value="02" <?=(!empty($usuario) && $usuario['avatar']=='02')?'selected':''?> >  Avatar 2  </option>
											<option data-img-src="img/avatar/03.png" data-img-alt="Avatar 3" value="03" <?=(!empty($usuario) && $usuario['avatar']=='03')?'selected':''?> >  Avatar 3  </option>
											<option data-img-src="img/avatar/04.png" data-img-alt="Avatar 4" value="04" <?=(!empty($usuario) && $usuario['avatar']=='04')?'selected':''?> >  Avatar 4  </option>
											<option data-img-src="img/avatar/05.png" data-img-alt="Avatar 5" value="05" <?=(!empty($usuario) && $usuario['avatar']=='05')?'selected':''?> >  Avatar 5  </option>
											<option data-img-src="img/avatar/06.png" data-img-alt="Avatar 6" value="06" <?=(!empty($usuario) && $usuario['avatar']=='06')?'selected':''?> >  Avatar 6  </option>
											<option data-img-src="img/avatar/07.png" data-img-alt="Avatar 7" value="07" <?=(!empty($usuario) && $usuario['avatar']=='07')?'selected':''?> >  Avatar 7  </option>
											<option data-img-src="img/avatar/08.png" data-img-alt="Avatar 8" value="08" <?=(!empty($usuario) && $usuario['avatar']=='08')?'selected':''?> >  Avatar 8  </option>
											<option data-img-src="img/avatar/09.png" data-img-alt="Avatar 9" value="09" <?=(!empty($usuario) && $usuario['avatar']=='09')?'selected':''?> >  Avatar 9  </option>
											<option data-img-src="img/avatar/10.png" data-img-alt="Avatar 10" value="10" <?=(!empty($usuario) && $usuario['avatar']=='10')?'selected':''?> > Avatar 10 </option>
											<option data-img-src="img/avatar/11.png" data-img-alt="Avatar 11" value="11" <?=(!empty($usuario) && $usuario['avatar']=='11')?'selected':''?> > Avatar 11 </option>
											<option data-img-src="img/avatar/12.png" data-img-alt="Avatar 12" data-img-class="last" value="12" <?=(!empty($usuario) && $usuario['avatar']=='12')?'selected':''?> > Avatar 12 </option>
										</select>
										<?else:?>
										<div class="thumbnail"><img class="image_picker_image" src="img/avatar/<?=(!empty($usuario))?$usuario['avatar']:'01'?>.png"></div>
										<?endif?>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-2 col-form-label" for="idtipousuario">Propuestas </label>
								<div class="col-sm-10">
									<div class="form-group">
										<select class="form-control" id="idpropuestas" name="idpropuestas[]"  multiple>
											<? foreach($propuestas as $prop) :?>
												<option value="<?=$prop['idpropuesta']?>" SELECTED><?=$prop['titulo_simple']?></option>
											<? endforeach;?>
										</select>
									</div>
								</div>
							</div>
							<?=input_check($usuario, 'alerta_mail', 'Recibir alertas por mail', true)?>
							<?=input_check($usuario, 'alerta_nuevo_organismo', 'Recibir alerta: Org. Sugerido', false)?>
							<?=input_check($usuario, 'alerta_contenidos', 'Recibir alerta: Contenidos', false)?>
							<?=input_check($usuario, 'habilitado', 'Habilitado', true)?>
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
