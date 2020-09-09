<div class="content">
	<div class="container-fluid">
		<div class="header text-center">
            <h3 class="title"><?=$perfil['titulo_corto']?></h3>
            <p class="category"><?=$iniciativa['titulo']?>: <?=$iniciativa['descripcion']?></p>
        </div>
		<div class="row">

			<div class="col-lg-2 col-md-4">
                <ul class="nav nav-pills nav-pills-rose flex-column" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#link0" role="tablist">Info General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link01" role="tablist">01 - <?=$textos['paso_1']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link02" role="tablist">02 - <?=$textos['paso_2']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link03" role="tablist">03 - <?=$textos['paso_3']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link04" role="tablist">04 - <?=$textos['paso_4']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link05" role="tablist">05 - <?=$textos['paso_5']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link06" role="tablist">06 - <?=$textos['paso_6']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link07" role="tablist">07 - <?=$textos['paso_7']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link08" role="tablist">08 - <?=$textos['paso_8']?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#link09" role="tablist">09 - <?=$textos['paso_9']?></a>
                    </li>
					<?if($perfil['idestadoperfil']>1):?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#linkPre" role="tablist">Preselección</a>
                    </li>
					<?endif?>
					<?if($perfil['idestadoperfil']>21):?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#linkSel" role="tablist">Selección</a>
                    </li>
					<?endif?>
                </ul>
			</div>
			
            <div class="col-lg-10 col-md-8">
                <div class="tab-content">
                    <div class="tab-pane active" id="link0">
						<div class="row contpaso paso0">
							<div class="col-md-12">               
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
											<h4 class="card-title">Info General</h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> Nombre Completo</label>
													<label class="form-control"><?=$usuario['nombre']?></label>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> Email</label>
													<label class="form-control"><?=$usuario['email']?></label>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> <?=$textos['institucion']?></label>
													<label class="form-control"><?=$usuario['institucion']?></label>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> <?=$textos['posicion']?></label>
													<label class="form-control"><?=$usuario['posicion']?></label>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> Porcentaje completo</label>
													<label class="form-control"><?=$perfil['porcentaje']?> %</label>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="antecedentes" class="bmd-label-floating"> Última vez guardado</label>
													<label class="form-control"><?=fromYYYYMMDDtoDDMMYYY($perfil['actualizado'],false)?></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div><!-- col-md-12 -->
						</div><!-- row paso0 -->
                    </div>
                    <div class="tab-pane" id="link01">
						<?php $this->load->view('admin/perfil_paso1'); ?>
                    </div>
                    <div class="tab-pane" id="link02">
						<?php $this->load->view('admin/perfil_paso2'); ?>
                    </div>
                    <div class="tab-pane" id="link03">
						<?php $this->load->view('admin/perfil_paso3'); ?>
                    </div>
                    <div class="tab-pane" id="link04">
						<?php $this->load->view('admin/perfil_paso4'); ?> 
                    </div>
                    <div class="tab-pane" id="link05">
						<?php $this->load->view('admin/perfil_paso5'); ?>
                    </div>
                    <div class="tab-pane" id="link06">
						<?php $this->load->view('admin/perfil_paso6'); ?>
                    </div>
                    <div class="tab-pane" id="link07">
						<?php $this->load->view('admin/perfil_paso7'); ?> 
                    </div>
                    <div class="tab-pane" id="link08">
						<?php $this->load->view('admin/perfil_paso8'); ?> 
                    </div>
                    <div class="tab-pane" id="link09">
						<?php $this->load->view('admin/perfil_paso9'); ?>
                    </div>
                    <div class="tab-pane" id="linkPre">
						<div class="row contpaso paso0">
							<div class="col-md-12">               
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
											<h4 class="card-title">Preselección</h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">
											<div class="col-12">
												<?if(!empty($perfil['adjunto_pre_propuesta'])):?>
													<button class="btn btn-facebook" onclick="window.location.href='admin/perfiles/descargarPropuesta/<?=$perfil['idperfil']?>'">
														<i class="fa fa-file-word-o"></i> Propuesta
													</button>
												<?endif?>
											</div>
											<div class="col-12">
												<?if(!empty($perfil['adjunto_pre_presupuesto'])):?>
													<button class="btn btn-excel" onclick="window.location.href='admin/perfiles/descargarPresupuesto/<?=$perfil['idperfil']?>'">
														<i class="fa fa-file-excel-o"></i> Presupuesto
													</button>
												<?endif?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="tab-pane" id="linkSel">
						<div class="row contpaso paso0">
							<div class="col-md-12">               
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
											<h4 class="card-title">Selección</h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">
											<div class="col-12">
												<?if(!empty($perfil['adjunto_seleccion'])):?>
													<button class="btn btn-facebook" onclick="window.location.href='admin/perfiles/descargarSeleccion/<?=$perfil['idperfil']?>'">
														<i class="fa fa-file-word-o"></i> Propuesta
													</button>
												<?endif?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
			 
			<div style="width:100%; text-align:center">
				<button class="btn btn-fill" onclick="window.history.back();" type="button"><i class="material-icons">keyboard_arrow_left</i> Volver</button>
			</div>
				
		</div><!-- end row -->
	</div><!-- end container-fluid -->
</div><!-- end content -->
