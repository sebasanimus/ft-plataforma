<div class="content">
    <div class="container-fluid">

		<div class="row">

            <div class="col-md-8 ml-auto mr-auto">
             	<div class="page-categories">
                	<h3 class="title text-center">Tech: <?=(!empty($webstory))?$webstory['titulo_simple']:'Nueva'?></h3>
                	<br />
					<ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#link7" role="tablist">
								<i class="material-icons">web</i> Descripción
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
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#linkPais" role="tablist">
								<i class="material-icons">flag</i> Paises
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
								<i class="material-icons">web</i>
							</div>
							<h4 class="card-title">Datos generales del Tech / Webstory</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
							
						</div><!-- card-header -->

						<div class="card-body ">
							<?if(!empty($webstory)):?>
							<div class="toolbar" style="text-align:center; clear:both">
								<a href="javascript:editable()" id="boton-editar" class="btn btn-warning btn-round btn-fab <?=empty($readonly)? 'hidden' : ''?>" rel="tooltip" data-placement="bottom" title="Editar Tech" >
									<i class="material-icons">create</i>
									<div class="ripple-container"></div>
								</a>
								<a href="<?=base_url()?>exportartech/generarPDF/<?=$tech['idtech']?>/es" target="_blank" id="boton-editar" class="btn btn-success btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Generar y ver PDF (Español)" >
									<i class="material-icons">open_in_new</i>
									<div class="ripple-container"></div>
								</a>	
								<a href="<?=base_url()?>exportartech/generarPDF/<?=$tech['idtech']?>/en" target="_blank" id="boton-editar" class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Generar y ver PDF (Inglés)" >
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
									<a class="dropdown-item dropdown-item-rose" href="admin/techies/listar">Listar Techies</a>
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
								
									<? input_imagen($webstory, 'foto_principal', 'Imagen Principal', 'webstories', true)?>

									<? input_lenguaje('text', $lenguajes, $datas_lang, 'tech_titulo', 'Título Tech', 'Escribir un título sencillo, atractivo, que cuente la temática o los alcances del proyecto', false, 250); /*100*/?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'tech_solucion', 'Solución tecnológica', '', false, 350);?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'tech_descripcion', 'Descripción', '', false, 350);/*250*/?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'tech_resultados', 'Resultados', '', false);/*700*/?>

									<?if($this->session->userdata('role')==4):?>	
										<? input_check($tech, 'publica_inv', 'Lista para revisar', true)?>
									<?else:?>
										<? input_check($tech, 'habilitado', 'Habilitado', true)?>	
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
