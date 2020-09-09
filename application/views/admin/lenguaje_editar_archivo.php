<div class="content">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">language</i>
						</div>
						<h4 class="card-title">Editar Archivo Lenguaje: <?=$lenguaje['nombre']?></h4>
						<p class="card-category" style="color:grey">&nbsp;</p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						<div class="nav-item dropdown opciones-toolbar" style="">	
							<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons text_align-center">more_vert</i>
							</a>
							<div class="dropdown-menu">								
								<?if(empty($esapp)):?>
									<a class="dropdown-item dropdown-item-rose" href="admin/lenguajes/listar">Listar Lenguajes</a>
								<?endif;?>
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

					
						<form id="form" data-parsley-validate class="form-horizontal form-label-right" method="POST">
							<? escupirArray($json_data); ?>
							<br/>

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
		
		<?php
		function escupirArray($array, $path='', $nombre='', $level=0){
			foreach($array as $key=>$elemento){
				$nombreReal = empty($nombre)? ucfirst($key) : $nombre.' - '.ucfirst($key);   
				$pathReal = empty($path)? $key : $path.'_'.$key;
				if($level==0){
					echo '<h3>'.$nombreReal.'</h3><div class="ln_solid"></div>';
				}
				if(is_array($elemento)){
					escupirArray($elemento, $pathReal, $nombreReal, $level+1);
				}else{
					echo '<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12" style="text-align:left" for="'.$pathReal.'">'.$nombreReal.'</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<textarea class="form-control col-md-7 col-xs-12" name="'.$pathReal.'">'.$elemento.'</textarea>
							</div>
						</div>';
				}
			}

		}
		?>