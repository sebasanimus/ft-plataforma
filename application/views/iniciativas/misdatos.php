<div class="content">
    <div class="container-fluid">
		<h3>Mis datos</h3>
        <br>
        <div class="row">
			<div class="col-md-10 ml-auto mr-auto">
				<div class="card card-signup p-0">				
					<div class="card-body">					
						<div class="col-md-12 mr-auto pt-5 pb-5">
							<?if(!empty($error)): ?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<i class="material-icons">close</i>
									</button>
									<span>
										<b> Error - </b> <?=$error?>
									</span>
								</div>
							<?endif;?>
							<form class="form" method="post" action="">                      
								<div class="form-group has-default">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
											<i class="material-icons">mail</i>
											</span>
										</div>
										<input type="email" class="form-control" name="username" placeholder="<?=$textos['email']?>" value="<?=$usuario['email']?>" maxlength="100" required>
									</div>
								</div>
								<div class="form-group has-default">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
											<i class="material-icons">face</i>
											</span>
										</div>
										<input type="text" class="form-control" name="nombre" placeholder="<?=$textos['nombre']?>" value="<?=$usuario['nombre']?>" maxlength="100" required>
									</div>
								</div>
								<div class="form-group has-default">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
											<i class="material-icons">lock_outline</i>
											</span>
										</div>
										<input type="password" name="password" placeholder="<?=$textos['password']?>" class="form-control" maxlength="100" >
									</div>
								</div>
								<div class="form-group has-default">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
											<i class="material-icons">location_city</i>
											</span>
										</div>
										<input type="text" name="institucion" class="form-control" placeholder="<?=$textos['institucion']?>" value="<?=$usuario['institucion']?>" maxlength="100" required>
									</div>
								</div>
								<div class="form-group has-default">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
											<i class="material-icons">work</i>
											</span>
										</div>
										<input type="text" name="posicion" class="form-control" placeholder="<?=$textos['posicion']?>" value="<?=$usuario['posicion']?>" maxlength="100" required>
									</div>
								</div>
								<div class="form-group has-default">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">
											<i class="material-icons">notifications_active</i>
											</span>
										</div>
										<div class="togglebutton" style="margin-top: 10px;">
											<label>
												<input type="checkbox" name="alerta_mail" <?=empty($usuario['alerta_mail']) ? '' : 'checked="checked"'?>  > 
												<span class="toggle"></span>
												<?=$textos['notificaciones_mail']?>
											</label>
										</div>
									</div>
								</div>
						
								<div class="text-center">
									<button type="submit" class="btn btn-primary btn-round mt-4"><?=$textos['modificar_datos']?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
        </div>

    	
	</div><!-- container-fluid -->
</div><!-- content -->
