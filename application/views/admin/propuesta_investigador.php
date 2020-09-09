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
						<?if(!empty($propuesta)):?>
						<!--<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#link8" role="tablist">
								<i class="material-icons">attach_money</i> Financiera
							</a>
						</li>-->
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#link9" role="tablist">
								<i class="material-icons">show_chart</i> Técnica
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#linkAdj" role="tablist">
								<i class="material-icons">attach_file</i> Adjuntos
							</a>
						</li>
						<?/*<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#linkProd" role="tablist">
								<i class="material-icons">picture_as_pdf</i> Productos
							</a>
						</li>*/?>
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#linkBadge" role="tablist">
								<i class="material-icons">verified_user</i> Badges ODS
							</a>
						</li>
						<?endif?>
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
							<h4 class="card-title">Datos generales de la Propuesta: <?=$datas_lang['es']['titulo_simple']?></h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
							
						</div><!-- card-header -->

						<div class="card-body ">
							<?if(!empty($propuesta)):?>
							<div class="toolbar" style="text-align:center; clear:both">									
								<a href="<?=base_url()?>proyectos/<?=$propuesta['web_url']?>" target="_blank" id="boton-editar" class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Ver Online (interno)" >
									<i class="material-icons">open_in_new</i>
									<div class="ripple-container"></div>
								</a>							
							</div>
							<?endif?>
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
							<?$disabled = empty($readonly)? '' : 'disabled' ?>
								<fieldset id="fieldset" <?=$disabled?> >

															
									
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'titulo_completo', 'Título Completo');?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'titulo_simple', 'Título Simple');?>
									

									<br/><br/>
									
									
									<hr/>
									<? input_imagen($propuesta, 'web_foto', 'Imagen Principal - debe tener 1700 x 700 px. y no pesar más de 500KB', 'propuestas', false)?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'web_resumen', 'Resumen ejecutivo', 'Resumen ejecutivo', false, 0);?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'web_beneficiarios', 'Beneficiarios', 'Beneficiarios', false, 0);?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'web_solucion', 'Solución tecnológica', 'Solución', false, 0);?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'web_impacto', 'Resultados', 'Resultados', false, 0);?>
									<?if(!$tienePpal):?>
									<div class="row">
										<label class="col-sm-2 col-form-label"></label>
										<div class="col-sm-10">
											<div class="alert alert-warning" role="alert"><a target="_blank" href="<?=base_url()?>admin/mapas/listar/<?=$idpropuesta?>">El mapa no tiene un punto principal. Debe crearlo ingresando aquí</a></div>
										</div>
									</div>
									<?endif?>

									<? input_check($propuesta, 'web_publicado', 'Habilitado', true)?>
									
						
								<br/>
								</fieldset>
								<div class="ln_solid"></div>
								<div class="form-group <?=empty($readonly)?'':'hidden'?>" id="botonera" >
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<button class="btn btn-fill" onclick="cancelar()" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
										<button class="btn btn-fill btn-rose" type="submit"><i class="material-icons">save</i> Guardar</button>
									</div>
								</div>
							</form>
								
						</div><!-- card-body -->
					</div><!-- card -->
				
				</div><!-- tab-pane -->

				<div class="tab-pane" id="link8">				
					<div class="card">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">attach_money</i>
							</div>
							<h4 class="card-title">Ítems financieros de la propuesta</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
						</div>
						<div class="card-body">
							<div class="toolbar" style="text-align:center; clear:both">

								<a href="admin/items/modificar/<?=$idpropuesta?>/0" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Ítem" >
									<i class="material-icons">add</i>
									<div class="ripple-container"></div>
								</a>
								
							</div>
							<div class="material-datatables">
								<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr>
											<th>País</th>
											<th>Organismo</th>
											<th>Participación</th>
											<th>Región</th>
											<th>Aporte FONTAGRO</th>
											<th>Aporte BID</th>
											<th>Mov. de Otras Agencias</th>
											<th>Aporte de Contrapartida</th>
											<th>Aporte de O. Agencias</th>
											<th>Total</th>
											<th class="disabled-sorting text-right">Acciones</th>
										</tr>
									</thead>                     
									<tbody>
									</tbody>
								</table>  
							</div>
						</div><!-- end content-->
					</div><!--  end card  -->				
				</div><!-- end tab-pane -->

				<div class="tab-pane" id="link9">				
					<div class="card">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">show_chart</i>
							</div>
							<h4 class="card-title">Datos Técnicos de la propuesta</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
						</div>
						<div class="card-body">
							<div class="toolbar" style="text-align:center; clear:both">

								<button onclick="abrirModalTecnica()" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Dato Técnico" >
									<i class="material-icons">add</i>
									<div class="ripple-container"></div>
								</button>
								
							</div>
							<div class="material-datatables">
								<table id="midatatable2" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr>
											<th>Componente</th>
											<th>Indicador</th>
											<th>Detalle</th>
											<th>País</th>
											<th>Localidad</th>
											<th>Año</th>
											<th>Unidad</th>
											<th>Antes</th>
											<th>Después</th>
											<th class="disabled-sorting text-right">Acciones</th>
										</tr>
									</thead>                     
									<tbody>
									</tbody>
								</table>  
							</div>
						</div><!-- end content-->
					</div><!--  end card  -->				
				</div><!--  end tab-pane-->


				<div class="tab-pane" id="linkAdj">				
					<div class="card">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">attach_file</i>
							</div>
							<h4 class="card-title">Adjuntos de la propuesta</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
						</div>
						<div class="card-body">
							<div class="toolbar" style="text-align:center; clear:both">
								<button onclick="abrirModalAdj()" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Adjunto" >
									<i class="material-icons">add</i>
									<div class="ripple-container"></div>
								</button>	
							</div>							
							
							<div class="material-datatables">
								<table id="midatatableAdj" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr>
											<th></th>
											<th>Tipo</th>
											<th>Nombre</th>
											<th>Orden</th>
											<th>Habilitado</th>
											<th class="disabled-sorting text-right">Acciones</th>
										</tr>
									</thead>                     
									<tbody>
									</tbody>
								</table>  
							</div>
						</div><!-- end content-->
					</div><!--  end card  -->				
				</div><!-- end tab-pane -->

				<div class="tab-pane" id="linkProd">				
					<div class="card">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">picture_as_pdf</i>
							</div>
							<h4 class="card-title">Productos del conocimiento</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
						</div>
						<div class="card-body">
							<div class="toolbar" style="text-align:center; clear:both">
								<button onclick="abrirModalProd()" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Producto" >
									<i class="material-icons">add</i>
									<div class="ripple-container"></div>
								</button>	
							</div>							
							
							<div class="material-datatables">
								<table id="midatatableProd" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr>
											<th></th>
											<th>Tipo</th>
											<th>Nombre</th>
											<th>Número</th>
											<th>Orden</th>
											<th>Publicado</th>
											<th class="disabled-sorting text-right">Acciones</th>
										</tr>
									</thead>                     
									<tbody>
									</tbody>
								</table>  
							</div>
						</div><!-- end content-->
					</div><!--  end card  -->				
				</div><!-- end tab-pane -->

				<div class="tab-pane" id="linkBadge">				
					<div class="card">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">verified_user</i>
							</div>
							<h4 class="card-title">Badges de Objetivos de Desarrollo Sostenible</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
						</div>
						<div class="card-body">
																			
							<div class="text-align:center">
								<form id="formbadges">
									<input type="hidden" name="idpropuesta" value="<?=$idpropuesta?>" />
									<select  multiple="multiple" class="image-picker show-html form-control" name="badges[]">
										<?foreach($badges as $badge):?>
											<option data-img-src="uploads/badges/<?=$badge['foto']?>" data-img-class="first" data-img-alt="<?=$badge['nombre']?>" value="<?=$badge['idbadgeods']?>" <?=(!empty($badgesObtenidas[$badge['idbadgeods']]))?'selected':''?> >  <?=$badge['nombre']?>  </option>
										<?endforeach?>
									</select>
								</form>
								<div class="form-group"  >
									<div class="text-align:center">
										<button class="btn btn-fill btn-rose" onclick="guardarBadges()" style="margin: 0 auto; display: block;">
											<i class="material-icons">save</i> Guardar
										</button>
									</div>
								</div>
							</div>
						</div><!-- end content-->
					</div><!--  end card  -->				
				</div><!-- end tab-pane -->

			</div>

		</div><!-- end row -->

	</div><!-- container-fluid -->
</div><!-- content -->


<div class="modal fade" id="donanteModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Agregar Donante</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" id="don_form" method="" action="">
                        <p class="description text-center">Agregue un donante a la propuesta</p>
                        <div class="card-body">
							
							<input type="hidden" value="<?=$idpropuesta?>" name="idpropuesta"/>

							<div class="row">
								<label class="col-sm-12 col-form-label" for="idpropuesta" style="text-align:center">Organismo</label>
								<div class="col-sm-12">
									<div class="form-group">
										<select class="form-control" name="idorganismo" id="don_idorganismo"></select>
									</div>
								</div>
							</div>						

							<? modal_input_text('number', 'orden', 'don', 'format_list_numbered', 'Orden', 'Orden');?>

                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarDonante()" id="don_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="tecnicaModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Crear Dato Técnico</h4>                    
					</div>
                </div>
                <div class="modal-body">
					<form class="form" id="tec_form" method="" action="">
                        <div class="card-body">

							<input type="hidden" value="0" name="idtecnica" id="tec_idtecnica"/>
							<input type="hidden" value="<?=$idpropuesta?>" name="idpropuesta"/>

							<? modal_input_select($componente, 'componente', 'tec', 'toc', 'Componente');?>
							
							<div class="form-group bmd-form-group">
                                <div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="material-icons">insert_chart_outlined</i></div>
									</div>
									<select class="selectpicker selectCopado" id="tec_indicastandar" name="indicastandar" data-style="select-with-transition" title="Indicador Estandar" data-size="7">
										<? foreach($indicastandar as $opcion):?>
											<option class="componente componente<?=$opcion['idcomponente']?>" value="<?=$opcion['id']?>" <?=(!empty($tecnica) && $tecnica['indicastandar']==$opcion['id'])?'SELECTED':''?> ><?=$opcion['nombre']?></option>
										<? endforeach;?>
									</select>
                                </div>
                            </div>
														
							<? modal_input_lenguaje('text', $lenguajes, 'indicador', 'tec', 'Indicador Original', 'Indicador Original', 255);?>
							<? modal_input_select($paisindicador, 'paisindicador', 'tec', 'map', 'País indicador');?>
							<? modal_input_text('text', 'localidad', 'tec', 'flag', 'Localidad', 'Localidad');?>
							<? modal_input_text('text', 'anio_ind', 'tec', 'insert_invitation', 'Año Indicador', 'Año Indicador');?>
							<? modal_input_select($unidades, 'unidad', 'tec', 'format_underlined', 'Unidad');?>
							<? modal_input_text('number', 'antes', 'tec', 'show_chart', 'Antes', 'Valor Antes');?>
							<? modal_input_text('number', 'despues_san', 'tec', 'score', 'Después', 'Valor Después');?>								

                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarTecnica()" id="tec_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="adjuntoModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Nuevo Adjunto</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" method="" action="">
                        <p class="description text-center">Agregue un adjunto a la propuesta</p>
                        <div class="card-body">

							<div class="form-group bmd-form-group">
                                <div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="material-icons">perm_media</i></div>
									</div>
									<select class="selectpicker selectCopado" id="adj_idtipo" data-style="select-with-transition" title="Tipo de Adjunto" data-size="7">
										<?foreach($tipoadjuntos as $tipo):?>
											<option value="<?=$tipo['idtipo']?>"><?=$tipo['nombre']?></option>
										<?endforeach?>
									</select>
									<input type="hidden" value="0" id="adj_idadjunto"/>
                                </div>
                            </div>
							
							<? modal_input_lenguaje('text', $lenguajes, 'nombre', 'adj', 'Nombre', 'Nombre', 255);?>
							<? modal_input_lenguaje('text', $lenguajes, 'taller', 'adj', 'Taller', 'Taller', 255);?>
							<? modal_input_lenguaje('text', $lenguajes, 'lugar', 'adj', 'Lugar', 'Lugar', 255);?>
							<? modal_input_text('date', 'fecha', 'adj', 'date_range', 'Fecha', 'Fecha', 255) ?>
							<? modal_input_text('text', 'autor', 'adj', 'account_box', 'Autor', 'Autor', 255) ?>
							<? modal_input_text('number', 'orden', 'adj', 'format_list_numbered', 'Orden', 'Orden del adjunto') ?>

							<br/>
                            <div class="form-group bmd-form-group" style="text-align:center">                                
								<div class="fileinput fileinput-new" id="fileinputAdjunto" data-provides="fileinput">
									<div class="fileinput-new thumbnail" >
										<img id="adj_thumbnail"  src="material/assets/img/image_placeholder.jpg"  alt="...">
										<span id="adj_thumbnailtext" style="display:none"></span>
									</div>
									<div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
									<div>
										<span class="btn btn-outline-secondary btn-file">
											<span class="fileinput-new">Seleccionar Archivo</span>
											<span class="fileinput-exists">Cambiar</span>
											<input type="file" name="adjunto" id="adjunto" style="z-index:200">
										</span>
										<a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remover</a>
									</div>
								</div>                                
                            </div>

							<div class="form-group bmd-form-group"  style="text-align:center">
								<div id="progress-wrp" class="progress-container progress-primary">
									<span class="progress-badge">0%</span>
									<div class="progress">
										<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
										</div>
									</div>
								</div>
							</div>
						
							<div class="form-group bmd-form-group">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text" style="padding: 0; margin: 0;">
											<div class="form-check" style="padding: 0; margin: -35px 0 0 0;">
												<label class="form-check-label">
													<input class="form-check-input" id="adj_aceptar" type="checkbox" value=""> 
													<span class="form-check-sign">
													<span class="check"></span>
													</span>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group" style="flex: 1 1 auto;">
											<textarea  class="form-control" readonly rows="3">Otorgo al BID una licencia no exclusiva, mundial, perpetua, irrevocable, libre de regalías y para fines no comerciales de esta obra.</textarea>
									</div>
								</div>
							</div>	
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarAdjunto()" id="adj_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="productoModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Nuevo Producto de Conocimiento</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" method="" action="">
                        <p class="description text-center">Agregue un producto a la propuesta</p>
                        <div class="card-body">

							<div class="form-group bmd-form-group">
                                <div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="material-icons">perm_media</i></div>
									</div>
									<select class="selectpicker selectCopado" id="pro_idtipo" data-style="select-with-transition" title="Tipo de Producto" data-size="8">
										<?foreach($tipoproductos as $tipo):?>
											<option value="<?=$tipo['idtipo']?>"><?=$tipo['nombre']?></option>
										<?endforeach?>
									</select>
									<input type="hidden" value="0" id="pro_idproducto"/>
                                </div>
                            </div>
							
							<? modal_input_lenguaje('text', $lenguajes, 'nombre', 'pro', 'Nombre', 'Nombre', 255);?>
							<? modal_input_text('text', 'numero', 'pro', 'local_offer', 'Número', 'Indique número de componente y número de actividad. Ej 1.1', 20) ?>
							<? modal_input_text('number', 'orden', 'pro', 'format_list_numbered', 'Orden', 'Orden del producto') ?>

							<br/>
                            <div class="form-group bmd-form-group" style="text-align:center">                                
								<div class="fileinput fileinput-new" id="fileinputProducto" data-provides="fileinput">
									<div class="fileinput-new thumbnail" >
										<img id="pro_thumbnail"  src="material/assets/img/image_placeholder.jpg"  alt="...">
										<span id="pro_thumbnailtext" style="display:none"></span>
									</div>
									<div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
									<div>
										<span class="btn btn-outline-secondary btn-file">
											<span class="fileinput-new">Seleccionar Archivo</span>
											<span class="fileinput-exists">Cambiar</span>
											<input type="file" name="producto" id="producto" style="z-index:200" accept="application/pdf">
										</span>
										<a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remover</a>
									</div>
								</div>                                
                            </div>

							<div class="form-group bmd-form-group"  style="text-align:center">
								<div id="progress-wrp-pro" class="progress-container progress-primary">
									<span class="progress-badge">0%</span>
									<div class="progress">
										<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
										</div>
									</div>
								</div>
							</div>
													
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarProducto()" id="pro_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>