<div class="content">
    <div class="container-fluid">
    	<div class="row">

			<div class="col-md-8 ml-auto mr-auto">
             	<div class="page-categories">
                	<h3 class="title text-center">Fontagro en Breve</h3>
                	<br />
					<ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#link1" role="tablist">
								<i class="material-icons">map</i> Descripción
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#link2" role="tablist">
								<i class="material-icons">place</i> Países
							</a>
						</li>
					</ul>
				</div>
			</div>

        	<div class="tab-content tab-space tab-subcategories col-md-12">
				<div class="tab-pane active" id="link1">
					<div class="card ">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">map</i>
							</div>
							<h4 class="card-title"> Datos generales de fontagro en breve</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
							
						</div><!-- card-header -->

						<div class="card-body ">
							<div class="toolbar" style="text-align:center; clear:both">
								<a href="javascript:editable()" id="boton-editar" class="btn btn-warning btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Editar propuesta" >
									<i class="material-icons">create</i>
									<div class="ripple-container"></div>
								</a>	
								<a href="<?=base_url()?>exportar/enBreveGeneral/es" target="_blank" id="boton-editar" class="btn btn-success btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Exportar en Español" >
									<i class="material-icons">save_alt</i>
									<div class="ripple-container"></div>
								</a>	
								<a href="<?=base_url()?>exportar/enBreveGeneral/en" target="_blank" id="boton-editar" class="btn btn-info btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Exportar en Inglés" >
									<i class="material-icons">save_alt</i>
									<div class="ripple-container"></div>
								</a>								
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
									
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'sobreTitulo', 'Título: Sobre FONTAGRO');?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'sobre', 'Contenido: Sobre FONTAGRO');?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'gobernanzaTitulo', 'Título: Gobernanza');?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'gobernanza', 'Contenido: Gobernanza');?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'misionTitulo', 'Título: Misión');?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'mision', 'Contenido: Misión');?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'planTitulo', 'Título: Plan');?>
									<? input_lenguaje('textarea', $lenguajes, $datas_lang, 'plan', 'Contenido: Plan');?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'enCifrasTitulo', 'Título: Cifras');?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'participacionTitulo', 'Título: Participación');?>
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'origenTitulo', 'Título: Origen fondos');?>						
						

									<? input_lenguaje('text', $lenguajes, $datas_lang, 'proyectosAprobados', 'Título: Número de Proyectos aprobados');?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'montoTotal', 'Título: Monto Total Aprobado U$S');?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'otrosInvercionistas', 'Título: Aporte de otros Inversionistas');?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'paisesBeneficiados', 'Título: Países beneficiados');?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'tecnologiasGeneradas', 'Título: Tecnologías generadas');?>
									<? input_number($fontagro, 'tecnologias_generadas', 'Tecnologías generadas', 'Tecnologías generadas', TRUE);?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'tecnologiasNuevas', 'Título: Tecnologías nuevas para ALC');?>	
									<? input_number($fontagro, 'tecnologias_nuevas', 'Tecnologías generadas', 'Tecnologías nuevas para ALC', TRUE);?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'tecnologiasRelevantes', 'Título: Tecnología de relevancia mundial');?>	
									<? input_number($fontagro, 'tecnologias_relevantes', 'Tecnologías generadas', 'Tecnología de relevancia mundial', TRUE);?>	

									<? input_lenguaje('text', $lenguajes, $datas_lang, 'miembro', 'Título: Miembro');?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'lider', 'Título: Lider');?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'aporteContrapartida', 'Título: Aporte Contrapartida');?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'BID', 'Título: BID');?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'otrasAgencias', 'Título: Otras Agencias');?>
									
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'fortalecimiento', 'Título: Fortalecimiento');?>		
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'paisesMiembro', 'Título: Miembros');?>		
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'anio', 'Tabla: Año');?>		
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'ejemplos', 'Título: Ejemplos');?>	
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'institucionLider', 'Tabla: Lider');?>		
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'miembros', 'Tabla: Miembros');?>		
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'tema', 'Tabla: Tema');?>		
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'monto', 'Tabla: Monto');?>	
										
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'paises', 'Tabla: País');?>									
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'contribucion', 'Tabla: Contribución');?>		
									<? input_lenguaje('text', $lenguajes, $datas_lang, 'participacion', 'Tabla: Participación');?>		
								
								</fieldset>
								<div class="ln_solid"></div>
								<div class="form-group hidden" id="botonera">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<button class="btn btn-fill" onclick="cancelar();" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
										<button class="btn btn-fill btn-rose" type="submit"><i class="material-icons">save</i> Guardar</button>
									</div>
								</div>
							</form>
					
						</div><!-- card-body -->
					</div><!-- card -->
				</div><!-- tab-pane -->

				<div class="tab-pane" id="link2">
					<div class="card">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">place</i>
							</div>
							<h4 class="card-title">Paises</h4>
							<p class="card-category" style="color:grey">Se muestran todos los países miembros de fontagro</p>
						</div>
						<div class="card-body">
							<div class="material-datatables">
								<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr>
											<th>País</th>
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

			</div><!-- end tab-content -->
		</div> <!-- end row-->
	</div><!-- container-fluid -->
</div><!-- content -->
