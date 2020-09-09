<div class="content">
    <div class="container-fluid">

		<div class="row">

            <div class="col-md-8 ml-auto mr-auto">
             	<div class="page-categories">
                	<h3 class="title text-center">Webstory: <?=(!empty($webstory))?$webstory['titulo_simple']:'Nueva'?></h3>
                	<br />
					<ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#link7" role="tablist">
								<i class="material-icons">web</i> Descripción
							</a>
						</li>
						<?if(!empty($webstory)):?>
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#link8" role="tablist">
								<i class="material-icons">attach_file</i> Adjuntos
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#link9" role="tablist">
								<i class="material-icons">verified_user</i> Badges ODS
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#link10" role="tablist">
								<i class="material-icons">equalizer</i> Indicadores
							</a>
						</li>
							<?if($this->session->userdata('role')!=4):?>
							<li class="nav-item">
								<a class="nav-link " data-toggle="tab" href="#linkPais" role="tablist">
									<i class="material-icons">flag</i> Paises
								</a>
							</li>
							<?endif?>
						<?endif?>
					</ul>
				</div>
			</div>

			<div class="tab-content tab-space tab-subcategories col-md-12">
				<div class="tab-pane active" id="link7">				
					<div class="card ">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">web</i>
							</div>
							<h4 class="card-title">Datos generales de la Webstory</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
							
						</div><!-- card-header -->

						<div class="card-body ">
							<?if(!empty($webstory)):?>
							<div class="toolbar" style="text-align:center; clear:both">
								<a href="javascript:editable()" id="boton-editar" class="btn btn-warning btn-round btn-fab <?=empty($readonly)? 'hidden' : ''?>" rel="tooltip" data-placement="bottom" title="Editar webstory" >
									<i class="material-icons">create</i>
									<div class="ripple-container"></div>
								</a>								
								
								<a href="<?=base_url()?>webstories/<?=$webstory['url']?>" target="_blank" id="boton-editar" class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Ver Online (interno)" >
									<i class="material-icons">open_in_new</i>
									<div class="ripple-container"></div>
								</a>
								<a href="<?=LINK_WEBSTORIES?><?=$webstory['url']?>" target="_blank" id="boton-editar" class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Ver Online Para compartir" >
									<i class="material-icons">share</i>
									<div class="ripple-container"></div>
								</a>
								<a href="<?=base_url()?>exportarposter/generarPDF/<?=$webstory['url']?>/es" target="_blank" id="boton-editar" class="btn btn-success btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Generar y Ver Poster (Español)" >
									<i class="material-icons">book</i>
									<div class="ripple-container"></div>
								</a>
								<a href="<?=base_url()?>exportarposter/generarPDF/<?=$webstory['url']?>/en" target="_blank" id="boton-editar" class="btn btn-success btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Generar y Ver Poster (Inglés)" >
									<i class="material-icons">book</i>
									<div class="ripple-container"></div>
								</a>								
							</div>
							<?endif?>
							<div class="nav-item dropdown opciones-toolbar" style="">	
								<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
									<i class="material-icons text_align-center">more_vert</i>
								</a>
								<div class="dropdown-menu">
									<a class="dropdown-item dropdown-item-rose" href="admin/webstories/listar">Listar Webstories</a>
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
									<div class="row">
										<label class="col-sm-2 col-form-label" for="idpropuesta">Propuesta <span class="required">*</span></label>
										<div class="col-sm-10">
											<div class="form-group">
												<select class="form-control" name="idpropuesta" id="idpropuesta" required="required">
												<?if(!empty($webstory)):?>
													<option value="<?=$propuesta['idpropuesta']?>"><?=$propuesta['titulo_simple'].' ('.$propuesta['identificador'].')'?></option>													
												<?endif;?>
												</select>
											</div>
										</div>
									</div>

									
									<? input_imagen($webstory, 'foto_principal', 'Imagen Principal', 'webstories', true)?>
									<? input_text('text', $webstory, 'url', 'Url', 'Url para ingresar a la webstory', true, 255)?>
									<? input_imagen($webstory, 'foto_link', 'Imagen desde Link', 'webstories', false)?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'titulo', 'Título Webstory', 'Escribir un título sencillo, atractivo, que cuente la temática o los alcances del proyecto', false, 250); /*100*/?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'bajada', 'Bajada', 'Resumen del proyecto, la información que amplía el título', false, 250);/*250*/?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'contexto', 'Contexto de la historia', 'Describir el problema, los antecedentes y/o la situación que motiva la iniciativa', false, 800);/*700*/?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'iniciativa_titulo', 'Iniciativa Volanta', 'Una oración corta que anticipe o complemente el título', false, 250);/*100*/?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'iniciativa_descripcion', 'Iniciativa Descripción', 'Describe el proyecto, sus objetivos y alcances', false, 800);/*550*/?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'solucion_titulo', 'Solución Volanta', 'Una oración corta que anticipe o complemente el título', false, 250);/*100*/?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'solucion_descripcion', 'Solución Descripción', 'Describe propiamente la solución', false, 1100);/*1000*/?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'cita_texto', 'Cita', 'Una oración con una cita o una frase significativa', false, 250);/*140*/?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'cita_fuente', 'Fuente de la Cita', 'Fuente o una referencia que legitime la frase', false, 250);/*50*/?>
									<? input_imagen($webstory, 'foto_cita', 'Fondo Cita', 'webstories', false)?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'resultados', 'Resultados', 'Responde a la pregunta, qué mejoras hay con respecto al contexto original', false, 1000);/*700*/?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'estadisticas_titulo', 'Estadísticas Título', '', false, 250);/*150*/?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'infografia_titulo', 'Infografía Título', '', false, 250);/*100*/?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'infografia_volanta', 'Infografía Volanta', 'Una oración corta que anticipe o complemente el título de la infografía', false, 250);/*150*/?>
									<? input_lenguaje_imagen($lenguajes, $datas_lang, 'infografia', 'Infografía', 'webstories', true)?>
									<? input_lenguaje('textarea',$lenguajes, $datas_lang, 'codigo_infografia', 'Código infografía', 'Código de Flourish')?>									
									<? input_text('url', $webstory, 'video', 'Video (Youtube)', 'Url del video de yotube', false, 250)/*100*/?>
									<? input_lenguaje('textarea',$lenguajes, $datas_lang, 'codigo_estadisticas', 'Código estádisticas', 'Código de Flourish')?>
									
									<?if($this->session->userdata('role')==4):?>	
										<? input_check($webstory, 'publica_inv', 'Lista para revisar', true)?>
									<?else:?>
										<? input_text('url', $webstory, 'link_publicacion', 'Link publicación', 'Url de la publicacion', false, 250)?>
										<? input_lenguaje('text', $lenguajes, $datas_lang, 'link_publicacion_titulo', 'Texto Link Publicación', 'El texto del botón de la publicación', false, 100);?>
										<? input_check($webstory, 'habilitado', 'Habilitado', true)?>	
									<?endif?>
						
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
								<i class="material-icons">attach_file</i>
							</div>
							<h4 class="card-title">Adjuntos de la webstory</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
						</div>
						<div class="card-body">
							<div class="toolbar" style="text-align:center; clear:both">
								<button onclick="abrirModal()" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Adjunto" >
									<i class="material-icons">add</i>
									<div class="ripple-container"></div>
								</button>	
							</div>							
							
							<div class="material-datatables">
								<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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

				<div class="tab-pane" id="link9">				
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
									<input type="hidden" name="idwebstory" value="<?=$idwebstory?>" />
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

				<div class="tab-pane" id="link10">				
					<div class="card">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">equalizer</i>
							</div>
							<h4 class="card-title">Indicadores</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
						</div>
						<div class="card-body">
							<div class="toolbar" style="text-align:center; clear:both">
								<button onclick="abrirModalIndicador()" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Indicador" >
									<i class="material-icons">add</i>
									<div class="ripple-container"></div>
								</button>	
							</div>

							<div class="material-datatables">
								<table id="miindicatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr>
											<th>Ícono</th>
											<th>Nombre</th>
											<th>Valor</th>
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

				<div class="tab-pane" id="linkPais">				
					<div class="card">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">flag</i>
							</div>
							<h4 class="card-title">Paises y organismos</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
						</div>
						<div class="card-body">
							<div class="toolbar" style="text-align:center; clear:both">
								<button onclick="abrirModalPais()" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Pais / Organismo" >
									<i class="material-icons">add</i>
									<div class="ripple-container"></div>
								</button>	
							</div>

							<div class="material-datatables">
								<table id="mipaistable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr>
											<th>Pais</th>
											<th>Organismo</th>
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

			</div>

		</div><!-- end row -->

	</div><!-- container-fluid -->
</div><!-- content -->


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
                        <p class="description text-center">Agregue un adjunto a la webstory</p>
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


<div class="modal fade" id="indicadorModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Nuevo Indicador</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" id="ind_form" method="" action="">
                        <p class="description text-center">Agregue un indicador a la webstory</p>
                        <div class="card-body">

							<!--<div class="form-group bmd-form-group">
                                <div class="input-group selector-icono">
                                  	<input type="text" class="form-control use-material-icon-picker" value="" name="icon" id="ind_icon" style="text-align: center;"/>
                                </div>
                            </div>-->
							<input type="hidden" value="0" name="idwebstoryindicador" id="ind_idindicador"/>
							<input type="hidden" value="<?=$idwebstory?>" name="idwebstory"/>

							<div class="form-group bmd-form-group">
                                <div class="input-group">
                                  	<div class="input-group-prepend">
									  	<div class="input-group-text"><i class="material-icons">I</i></div>
                                  	</div>
                                  	<div class="picker form-control" style="z-index: 5000;">
										<input type="text" readonly class="inputpicker" name="icon" id="ind_icon" placeholder="Elegí tu icono preferido...">
									</div>
                                </div>
                            </div>
							
							<? modal_input_lenguaje('text', $lenguajes, 'nombre', 'ind', 'Nombre', 'Nombre', 255);?>
							<? modal_input_text('number', 'valor', 'ind', 'format_list_numbered', 'Valor', 'Valor del indicador') ?>
							
							<? modal_input_text('text', 'prefijo', 'ind', 'exposure_plus_1', 'Prefijo + o -', '',2) ?>		
							<? modal_input_text('text', 'unidad', 'ind', 'timer_3', 'Unidad', '',5) ?>								

                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarIndicador()" id="ind_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="paisModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Nuevo país / organismo</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" id="pai_form" method="" action="">
                        <p class="description text-center">Agregue un país / organismo a la webstory</p>
                        <div class="card-body">
							
							<input type="hidden" value="0" name="idwebstoryorganismo" id="pai_idwebstoryorganismo"/>
							<input type="hidden" value="<?=$idwebstory?>" name="idwebstory"/>

							<? modal_input_select($paises, 'pais', 'pai', 'map', 'País');?>	

							<div class="row">
								<label class="col-sm-12 col-form-label" for="idorganismo" style="text-align:center">Organismo</label>
								<div class="col-sm-12">
									<div class="form-group">
										<select class="form-control" name="idorganismo" id="pai_idorganismo"></select>
									</div>
								</div>
							</div>						

                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarPais()" id="pai_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>
