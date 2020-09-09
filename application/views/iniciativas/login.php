<!DOCTYPE html>
<html lang="es">
	<head>
    	<?php $this->load->view('iniciativas/estruc/header'); ?>
  	</head>

	
<body class="off-canvas-sidebar">
	<?php $this->load->view('iniciativas/estruc/login_navbar'); ?>
  
 	<div class="wrapper wrapper-full-page">
    	<div class="page-header login-page" style="background-image: url('material/assets/img/register.jpg'); background-size: cover; background-position: top center;">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
						<form class="form" method="post" action="">
							<div class="card card-login card-hidden">
								<div class="card-header card-header-rose text-center">
									<h4 class="card-title"><?=$textos['login']?></h4> 
								</div>
								<div class="card-body">
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
									<span class="bmd-form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="material-icons">email</i>
												</span>
											</div>
											<input type="email" name="username" class="form-control" placeholder="<?=$textos['email']?>" required>
										</div>
									</span>
									<span class="bmd-form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<i class="material-icons">lock_outline</i>
												</span>
											</div>
											<input type="password" name="password" class="form-control" placeholder="<?=$textos['password']?>" required>
										</div>
									</span>
								</div>
								<div class="card-footer justify-content-center pb-4">
									<button type="submit"  class="btn btn-info btn-round mt-4"><?=$textos['ingresar']?></button>
								</div>
								<div class="infoLinks rounded-lg rounded-bottom bg-light text-center pt-4 pb-4">
									<a href="<?=base_url()?>iniciativas/registro" class="btn btn-dark btn-sm"><?=$textos['no_tiene_cuenta']?></a> <br>
									<a href="<?=base_url()?>iniciativas/olvido" class="text-muted"><?=$textos['olvido']?></a>
								</div>
							</div>              
						</form>
					</div>
				</div>
			</div>
			<?php $this->load->view('iniciativas/estruc/login_footer'); ?>
		</div>
  	</div>

  	<?php $this->load->view('iniciativas/estruc/login_script'); ?>
</body>

</html>