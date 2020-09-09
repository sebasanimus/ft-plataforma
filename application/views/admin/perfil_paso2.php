<div class="row contpaso paso2">
	<div class="col-md-12">		
        <div class="card ">
            <div class="card-header card-header-rose card-header-text">
                <div class="card-text">
                    <h4 class="card-title"><?=$textos['organismo_ejecutor']?></h4>
                </div>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-sm-12 pt-3 pb-2">
						<label class="form-control"><b><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['organismo']?></b></label>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name" class="bmd-label-floating"> <?=$textos['nombre_y_apellido']?></label>
                            <label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['nombre_contacto']?></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="cargo" class="bmd-label-floating"> <?=$textos['cargo']?></label>
                            <label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['cargo_contacto']?></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email" class="bmd-label-floating"> <?=$textos['email']?></label>
                            <label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['email_contacto']?></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone" class="bmd-label-floating"> <?=$textos['telefono']?></label>
                            <label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['telefono_contacto']?></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="phone" class="bmd-label-floating"> País</label>
                            <label class="form-control" ><?=empty($perfil['ejecutor'])?'':$perfil['ejecutor']['pais']?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
    	<div class="card ">
            <div class="card-header card-header-rose card-header-text">
                <div class="card-text">
                    <h4 class="card-title"><?=$textos['organismos_coejecutores']?></h4>
                </div>
            </div>
            <div class="card-body ">
				<?foreach($perfil['coejecutor'] as $coejecutor):?>
					<div class="coejecutor" style="border-bottom-width : 2px; border-bottom-color : #00C825; border-bottom-style : solid;">					
						<div class="row">
							<div class="col-sm-12 pt-3 pb-2">
								<label class="form-control"><b><?=empty($coejecutor)?'':$coejecutor['organismo']?></b></label>                        
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label for="name" class="bmd-label-floating"> <?=$textos['nombre_y_apellido']?></label>
									<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['nombre_contacto']?></label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="cargo" class="bmd-label-floating"> <?=$textos['cargo']?></label>
									<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['cargo_contacto']?></label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="email" class="bmd-label-floating"> <?=$textos['email']?></label>
									<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['email_contacto']?></label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="phone" class="bmd-label-floating"> <?=$textos['telefono']?></label>
									<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['telefono_contacto']?></label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="phone" class="bmd-label-floating"> País</label>
									<label class="form-control" ><?=empty($coejecutor)?'':$coejecutor['pais']?></label>
								</div>
							</div>
						</div>
					</div>
				<?endforeach?>	
				<div>
					<small><?=$textos['aclaracion_coejecutor']?></small>
				</div>		
			</div>
		</div>
	</div>
    <div class="col-12">
        <div class="card ">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-text">
					<h4 class="card-title"><?=$textos['organismo_asociado']?></h4>
				</div>
			</div>
			<div class="card-body ">
				<?foreach($perfil['asociado'] as $asociado):?>
					<div class="coejecutor" style="border-bottom-width : 2px; border-bottom-color : #00C825; border-bottom-style : solid;">					
						<div class="row">
							<div class="col-sm-12 pt-3 pb-2">
								<label class="form-control"><b><?=empty($asociado)?'':$asociado['organismo']?></b></label>                        
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label for="name" class="bmd-label-floating"> <?=$textos['nombre_y_apellido']?></label>
									<label class="form-control" ><?=empty($asociado)?'':$asociado['nombre_contacto']?></label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="cargo" class="bmd-label-floating"> <?=$textos['cargo']?></label>
									<label class="form-control" ><?=empty($asociado)?'':$asociado['cargo_contacto']?></label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="email" class="bmd-label-floating"> <?=$textos['email']?></label>
									<label class="form-control" ><?=empty($asociado)?'':$asociado['email_contacto']?></label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="phone" class="bmd-label-floating"> <?=$textos['telefono']?></label>
									<label class="form-control" ><?=empty($asociado)?'':$asociado['telefono_contacto']?></label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="phone" class="bmd-label-floating"> País</label>
									<label class="form-control" ><?=empty($asociado)?'':$asociado['pais']?></label>
								</div>
							</div>
						</div>
					</div>
				<?endforeach?>	
			</div>
        </div>
    </div>
</div><!-- row paso2 -->
