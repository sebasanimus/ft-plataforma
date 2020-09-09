<div class="content">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">show_chart</i>
						</div>
						<h4 class="card-title"><?=(!empty($tecnica))?'Modificar':'Crear'?> Dato técnico</h4>
						<p class="card-category" style="color:grey">&nbsp;</p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						<div class="nav-item dropdown opciones-toolbar" style="">	
							<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons text_align-center">more_vert</i>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item dropdown-item-rose" href="admin/propuesta/ver/<?=$idpropuesta?>">Ver Propuesta</a>
								<a class="dropdown-item dropdown-item-rose" href="admin/tecnicas/modificar/<?=$idpropuesta?>/0">Nuevo Dato Técnico</a>
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
								<? input_select($tecnica, $componente, 'componente', 'Componente', TRUE);?>

								<div class="row">
									<label class="col-sm-2 col-form-label" for="indicastandar">Indicador Estandar <span class="required">*</span></label>
									<div class="col-sm-10">
										<div class="form-group">
											<select class="form-control" name="indicastandar" id="indicastandar" required="required" >
												<option value="">Seleccione...</option>
												<? foreach($indicastandar as $opcion):?>
													<option class="componente componente<?=$opcion['idcomponente']?>" value="<?=$opcion['id']?>" <?=(!empty($tecnica) && $tecnica['indicastandar']==$opcion['id'])?'SELECTED':''?> ><?=$opcion['nombre']?></option>
												<? endforeach;?>
											</select>
										</div>
									</div>
								</div>

								<? input_lenguaje('text', $lenguajes, $datas_lang, 'indicador', 'Indicador Original');?>
								<? input_select($tecnica, $paisindicador, 'paisindicador', 'País indicador', FALSE);?>
								<? input_text('text', $tecnica, 'localidad', 'Localidad', 'Localidad', FALSE);?>
								<? input_text('text', $tecnica, 'anio_ind', 'Año Indicador', 'Año Indicador', FALSE);?>	
								<? input_select($tecnica, $unidades, 'unidad', 'Unidad', TRUE);?>
								<? input_text('text', $tecnica, 'antes', 'Antes', 'Antes', FALSE);?>
								<? input_number($tecnica, 'despues_san', 'Después', 'Después', FALSE);?>	
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