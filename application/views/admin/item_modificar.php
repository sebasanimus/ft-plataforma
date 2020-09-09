<div class="content">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">attach_money</i>
						</div>
						<h4 class="card-title"><?=(!empty($item))?'Modificar':'Crear'?> Ítem Financiero</h4>
						<p class="card-category" style="color:grey">&nbsp;</p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						<div class="nav-item dropdown opciones-toolbar" style="">	
							<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons text_align-center">more_vert</i>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item dropdown-item-rose" href="admin/propuestas/ver/<?=$idpropuesta?>">Ver Propuesta</a>
								<a class="dropdown-item dropdown-item-rose" href="admin/items/modificar/<?=$idpropuesta?>/0">Nuevo Item</a>
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

						<form id="form" data-parsley-validate class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">
							<?$disabled = (isset($readonly) && $readonly)? 'disabled' : '' ?>
							<fieldset <?=$disabled?> >

								<div class="row">
									<label class="col-sm-2 col-form-label" for="idorganismo">Organismo <span class="required">*</span></label>
									<div class="col-sm-10">
										<div class="form-group">
											<select class="form-control" name="idorganismo" id="idorganismo" required="required">
											<?if(!empty($item)):?>
												<option value="<?=$organismo['idorganismo']?>"><?=$organismo['nombre']?> - <?=$organismo['pais']?> - <?=$organismo['nombre_largo']?></option>													
											<?endif;?>
											</select>
										</div>
									</div>
								</div>					
								
								<? input_select($item, $pais, 'pais', 'País', TRUE);?>
								<? input_select($item, $tipo_institucion, 'tipo_institucion', 'Tipo de Institución', TRUE);?>
								<? input_select($item, $participacion, 'participacion', 'Participación', TRUE);?>
								<? input_select($item, $region, 'region', 'Región', TRUE);?>
														
								<? input_number($item, 'aporte_fontagro', 'Aporte FONTAGRO', FALSE);?>
								<? input_number($item, 'aporte_bid', 'Aporte BID', FALSE);?>
								<? input_number($item, 'movilizacion_agencias', 'Movilización de Otras Agencias', FALSE);?>
								<? input_number($item, 'aporte_contrapartida', 'Aporte de Contrapartida', FALSE);?>
								<? input_number($item, 'aporte_agencias', 'Aporte de O. Agencias', FALSE);?>

								<div class="row">
									<label class="col-sm-2 col-form-label">Total</label>
									<div class="col-sm-10">
										<div class="form-group">
											<label id="total" class="form-control"></label>
										</div>
									</div>
								</div>
								<br/>
							
							</fieldset>
							<div class="ln_solid"></div>
							<?if(empty($readonly)):?>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button class="btn btn-fill" onclick="window.history.back();" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
									<button class="btn btn-fill btn-rose" type="submit"><i class="material-icons">save</i> Guardar</button>
									</div>
								</div>
							<?endif?>
						</form>
				 
						
					</div><!-- card-body -->
				</div><!-- card -->
			</div><!-- col-md-12 -->
		</div><!-- row -->
	</div><!-- container-fluid -->
</div><!-- content -->