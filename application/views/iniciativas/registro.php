<!DOCTYPE html>
<html lang="es">
	<head>
    	<?php $this->load->view('iniciativas/estruc/header'); ?>
  	</head>

	
<body class="off-canvas-sidebar">
	<?php $this->load->view('iniciativas/estruc/login_navbar'); ?>

  <div class="wrapper wrapper-full-page">
  	<div class="page-header register-page" style="background-image: url('material/assets/img/register.jpg')">
	  <div class="container">
        <div class="row">
          <div class="col-md-10 ml-auto mr-auto">
            <div class="card card-signup p-0">
              
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 lightGrey pt-4 pb-4 pl-2 pr-2">
                    <div class="info info-horizontal">
                      <div class="icon icon-rose">
                        <div class="iconBg rounded-circle bg-primary">
                            <i class="material-icons">person_add</i>
                        </div>
                        
                      </div>
                      <div class="description">
                        <h4 class="info-title"><?=$textos['perfiles']?></h4>
                        <p class="description">
							<?=$textos['perfiles_descripcion']?>.
                        </p>
                      </div>
                    </div>
                    <div class="info info-horizontal">
                      <div class="icon icon-white">
                          <div class="iconBg rounded-circle bg-secondary">
                            <i class="material-icons">art_track</i>
                          </div>
                      </div>
                      <div class="description">
                        <h4 class="info-title"><?=$textos['convocatorias']?></h4>
                        <p class="description">
							<?=$textos['convocatorias_descripcion']?>
                        </p>
                      </div>
                    </div>
                    <div class="info icon-white info-horizontal">
                      <div class="icon">
                        <div class="iconBg rounded-circle bg-info">
                          <i class="material-icons">attach_file</i>
                        </div>
                      </div>
                      <div class="description">
                        <h4 class="info-title"><?=$textos['instructivo']?></h4>
                        <p class="description">
                          <a href="https://www.fontagro.org/wp-content/uploads/2020/01/convocatoria-2020-ESPANOL-.pdf" target="_blank" class="text-info download"><?=$textos['instructivos_descripcion']?> <i class="material-icons">arrow_forward</i></a>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mr-auto pt-5 pb-5">
                    <h2 class="card-title pl-4"><?=$textos['registro']?></h2>
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
                          <input type="email" class="form-control" name="username" placeholder="<?=$textos['email']?>" value="<?=empty($oldata)?'':$oldata['username']?>" maxlength="100" required>
                        </div>
                      </div>
					  <div class="form-group has-default">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">face</i>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="nombre" placeholder="<?=$textos['nombre']?>" value="<?=empty($oldata)?'':$oldata['nombre']?>" maxlength="100" required>
                        </div>
                      </div>
                      <div class="form-group has-default">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">lock_outline</i>
                            </span>
                          </div>
                          <input type="password" name="password" placeholder="<?=$textos['password']?>" class="form-control" maxlength="50" required>
                        </div>
                      </div>
                      <div class="form-group has-default">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">location_city</i>
                            </span>
                          </div>
                          <input type="text" name="institucion" class="form-control" placeholder="<?=$textos['institucion']?>" value="<?=empty($oldata)?'':$oldata['institucion']?>" maxlength="100" required>
                        </div>
                      </div>
                      <div class="form-group has-default">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="material-icons">work</i>
                            </span>
                          </div>
                          <input type="text" name="posicion" class="form-control" placeholder="<?=$textos['posicion']?>" value="<?=empty($oldata)?'':$oldata['posicion']?>" maxlength="100" required>
                        </div>
                      </div>
                     
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-round mt-4"><?=$textos['registrarse']?></button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $this->load->view('iniciativas/estruc/login_footer'); ?>
    </div>
  </div>

  <?php $this->load->view('iniciativas/estruc/login_script'); ?>
 
</body>

</html>