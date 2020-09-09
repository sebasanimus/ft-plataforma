<div class="content">
    <div class="container-fluid">

		<div class="row">

            <div class="col-md-8 ml-auto mr-auto">
             	<div class="page-categories">
                	<h3 class="title text-center">Propuesta: <?=(!empty($propuesta))?$propuesta['identificador']:'Nueva'?></h3>
                	<br />
					<ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#link7" role="tablist">
								<i class="material-icons">list</i> Descripción
							</a>
						</li>
						
					</ul>
				</div>
			</div>

			<div class="tab-content tab-space tab-subcategories col-md-12">
				<div class="tab-pane active" id="link7">				
					<div class="card ">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">list</i>
							</div>
							<h4 class="card-title">Datos generales de la Propuesta</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
							
						</div><!-- card-header -->

						<div class="card-body ">
						
							<div class="nav-item dropdown opciones-toolbar" style="">	
								<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
									<i class="material-icons text_align-center">more_vert</i>
								</a>
								<div class="dropdown-menu">
									<a class="dropdown-item dropdown-item-rose" href="admin/propuestas/listar">Listar Propuestas</a>
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
							
								<fieldset id="fieldset" disabled >

									<? input_text('text', $propuesta, 'identificador', 'Identificador', 'Identificador', TRUE);?>						
									<div class="row">
										<label class="col-sm-2 col-form-label" for="anio">Año <span class="required">*</span></label>
										<div class="col-sm-10">
											<div class="form-group">
												<select class="selectpicker form-control alcien" data-style="select-with-transition" title="Seleccione" data-size="5" name="anio" id="anio" required="required">													
													<? for($i=(date("Y")+1); $i>=1998 ; $i-- ):?>
														<option value="<?=$i?>" <?=(!empty($propuesta) && $propuesta['anio']==$i)?'SELECTED':''?> ><?=$i?></option>
													<? endfor;?>
												</select>
											</div>
										</div>
									</div>
									<? input_select($propuesta, $estado, 'estado', 'Estado', TRUE);?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'titulo_completo', 'Título Completo');?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'titulo_simple', 'Título Simple');?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'plataforma', 'Plataforma');?>
									<? input_select($propuesta, $operacion, 'operacion', 'Operacion', TRUE);?>
									<? input_select($propuesta, $linea_estrategica, 'linea_estrategica', 'Linea Estrategica', TRUE);?>
									<? input_select($propuesta, $tipo_investigacion, 'tipo_investigacion', 'Tipo de Investigación', TRUE);?>
									<? input_select($propuesta, $tipo_innovacion, 'tipo_innovacion', 'Tipo de Innovación', TRUE);?>

									<? input_lenguaje('text', $lenguajes, $datas_lang, 'otras_agencias', 'Otras Agencias');?>
								</fieldset>
								<br/><hr/><br/>

								<? /*input_select($propuesta, $sector_productivo, 'idsectorproductivo', 'Sector Productivo', TRUE);*/?>
								<div class="row">
									<label class="col-sm-2 col-form-label" for="idtemas">Temas</label>
									<div class="col-sm-10">
										<div class="form-group">
										<? foreach($temas as $opcion):?>
											<div class="form-check form-check-inline">
												<label class="form-check-label <?=(!empty($temasSelect[$opcion['id']]))?'form-check-seleccionado':''?>">
													<input class="form-check-input" name="idtemas[]" type="checkbox" value="<?=$opcion['id']?>" <?=(!empty($temasSelect[$opcion['id']]))?'CHECKED':''?>> <?=$opcion['nombre']?>
													<span class="form-check-sign"><span class="check"></span></span>
												</label>
											</div>
										<? endforeach;?>											
										</div>
									</div>
								</div>
								<?foreach($sector_productivo as $sector):?>	
								<div class="row">
									<label class="col-sm-2 col-form-label">Sector Productivo</label>
									<div class="col-sm-10">
										<div class="form-group">
											<div class="form-check form-check-inline">
												<label class="form-check-label <?=(!empty($sectorSelect[$sector['id']]))?'form-check-seleccionado':''?>">
													<input class="form-check-input sector-input" name="idsectores[]" type="checkbox" value="<?=$sector['id']?>" <?=(!empty($sectorSelect[$sector['id']]))?'CHECKED':''?>> <?=$sector['nombre']?>
													<span class="form-check-sign"><span class="check"></span></span>
												</label>
											</div>											
										</div>
									</div>
								</div>
									
								<div class="row subsector<?=$sector['id']?>" style="<?=(!empty($sectorSelect[$sector['id']]))?'':'display:none'?>">
									<label class="col-sm-3 col-form-label"></label>
									<div class="col-sm-9">
										<div class="form-group">
											<?foreach($sector['subsectores'] as $subsector):?>
											<div class="form-check form-check-inline">
												<label class="form-check-label <?=(!empty($sector['select'][$subsector['id']]))?'form-check-seleccionado':''?>">
													<input class="form-check-input" name="idsubsectores[]" type="checkbox" value="<?=$subsector['id']?>" <?=(!empty($sector['select'][$subsector['id']]))?'CHECKED':''?>> <?=$subsector['nombre']?>
													<span class="form-check-sign"><span class="check"></span></span>
												</label>
											</div>													
											<?endforeach;?>											
										</div>
									</div>
								</div>
								<?endforeach;?>
						
								<br/>
								<div class="ln_solid"></div>
								<div class="form-group" id="botonera" >
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<button class="btn btn-fill" onclick="cancelar()" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
										<button class="btn btn-fill btn-rose" type="submit"><i class="material-icons">save</i> Guardar</button>
									</div>
								</div>
							</form>
								
						</div><!-- card-body -->
					</div><!-- card -->
				
				</div><!-- tab-pane -->
				

			</div>

		</div><!-- end row -->

	</div><!-- container-fluid -->
</div><!-- content -->

