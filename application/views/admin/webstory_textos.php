<div class="content">
    <div class="container-fluid">

		<div class="row">
           
			<div class="tab-content tab-space tab-subcategories col-md-12">
				<div class="tab-pane active" id="link7">				
					<div class="card ">
						<div class="card-header card-header-rose card-header-icon">
							<div class="card-icon">
								<i class="material-icons">web</i>
							</div>
							<h4 class="card-title">Información en común a todas las Webstories</h4>
							<p class="card-category" style="color:grey">&nbsp;</p>
							
						</div><!-- card-header -->

						<div class="card-body ">
							<div class="toolbar" style="text-align:center; clear:both">
								<a href="javascript:editable()" id="boton-editar" class="btn btn-warning btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Editar Textos" >
									<i class="material-icons">create</i>
									<div class="ripple-container"></div>
								</a>	
							
							</div>
							
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
																		
									<? input_text('url', $infos['ni'], 'twitter', 'Twitter', 'Url del twitter de fontagro', true, 100)?>
									<? input_text('url', $infos['ni'], 'vimeo', 'Vimeo', 'Url de Vimeo de fontagro', true, 100)?>
									<? input_text('url', $infos['ni'], 'youtube', 'Youtube', 'Url de Youtube de fontagro', true, 100)?>
									<? input_text('url', $infos['ni'], 'linkedin', 'Linkedin', 'Url de Linkedin de fontagro', true, 100)?>

									<? input_lenguaje('text', $lenguajes, $infos, 'sobre_fontagro', 'Sobre Fontagro', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('textarea', $lenguajes, $infos, 'descripcion', 'Descripcion de FONTAGRO', 'Fontagro es...', false, 500);?>

									<? input_lenguaje('text', $lenguajes, $infos, 'contexto', 'El contexto de la historia', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'iniciativa', 'La iniciativa implementada', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'solucion', 'La solución tecnológica', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'mapa', 'Países participantes', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'impactos_resultados', 'Resultados', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'estadisticas', 'Datos relevantes', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'video', 'Video y fotos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'infografia', 'Infografía', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'donantes', 'Principales donantes', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'informacion', 'Información del proyecto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'logos', 'Organizaciones participantes', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'prefooter', 'Otras historias de impacto', 'Traducción', TRUE, 100);?>

									<? input_lenguaje('text', $lenguajes, $infos, 'menu', 'Menú', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'historias', 'Historias de impacto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'volver', 'Volver al proyecto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'conocer_mas', 'Conocer más', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'ficha', 'Ficha técnica del proyecto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'novedades', 'Novedades del proyecto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'conoce', 'Conoce otras', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'tipo_proyecto', 'Tipo de Proyecto', 'Traducción', TRUE, 100);?>

									<? input_lenguaje('text', $lenguajes, $infos, 'tech_descripcion', 'Descripción', 'Traducción', TRUE, 100);?>
								
									<? input_lenguaje('text', $lenguajes, $infos, 'iniciativas_y_proyectos', 'Iniciativas y proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'iniciativas_en_curso', 'Iniciativas en curso', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyectos_dato_1', 'Dato 1 en proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyectos_dato_2', 'Dato 2 en proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyectos_dato_3', 'Dato 3 en proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyectos_dato_4', 'Dato 4 en proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyectos_dato_5', 'Dato 5 en proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyectos_dato_6', 'Dato 6 en proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'fuente_de_financiamiento', 'Fuente de financiamiento', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'resumen_ejecutivo', 'Resumen Ejecutivo', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'beneficiarios_proyectos', 'Beneficiarios', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'objetivos_sostenibles', 'Objetivos de desarrollo sostenible', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'novedades_proyecto', 'Novedades del proyecto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'webstory_tagline', 'Ir al webstory del proyecto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'webstory_titulo', 'Conocer más de esta historia', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'graficos_y_datos', 'Gráficos y datos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'financiamiento_pais', 'Financiamiento país', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'proyecto_anterior', 'Anterior', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'proyecto_siguiente', 'Siguiente', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'mapa_geolocalizado', 'Mapa Geolocalizado', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'publicaciones_y_recursos', 'Publicaciones y recursos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'otros_proyectos', 'Otros Proyectos', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'patrocinadores', 'Patrocinadores', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'con_el_apoyo', 'Con el apoyo de', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'el_proyecto', 'El proyecto', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'plazo_ejecucion_proyecto', 'Plazo de ejecución', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'plazo_ejecucion_meses', 'Meses', 'Traducción', TRUE, 100);?>		
									<? input_lenguaje('text', $lenguajes, $infos, 'productos_de_diseminacion', 'Productos de diseminación', 'Traducción', TRUE, 100);?>	

									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_titulo', 'Proy. home: título', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_descripcion', 'Proy. home: descripcion', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_tit_part1', 'Proy. home: Título part 1', 'Traducción', TRUE, 100);?>	
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_tit_part2', 'Proy. home: Título part 2', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_tit_part3', 'Proy. home: Título part 3', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_proy_activos', 'Proy. home: Proyectos activos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_usd_fondos', 'Proy. home: USD de fondos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_buscar_proy', 'Proy. home: Buscar proyecto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_buscar', 'Proy. home: Buscar', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_pal_clave', 'Proy. home: Palabra clave', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_tipo', 'Proy. home: Tipo', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_estado', 'Proy. home: Estado', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_tema', 'Proy. home: Tema', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_pais', 'Proy. home: País', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_anio', 'Proy. home: Anio', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_iniciativas', 'Proy. home: Iniciativas', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_ini_desc', 'Proy. home: Iniciativas desc.', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_conocer', 'Proy. home: Conocer más', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_cargar', 'Proy. home: Cargar perfil', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_ver', 'Proy. home: Ver perfil', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_editar', 'Proy. home: Editar proyecto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_ultimas', 'Proy. home: Ultimas novedades', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_delos', 'Proy. home: de los proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_proyecto', 'Proy. home: proyecto', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_organismo', 'Proy. home: organismo', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_ejecutor', 'Proy. home: ejecutor', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_ver_todos', 'Proy. home: ver todos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_convocatorias', 'Proy. home: convocatorias', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyhome_concursos', 'Proy. home: concursos', 'Traducción', TRUE, 100);?>

									<? input_lenguaje('text', $lenguajes, $infos, 'proyini_perfiles_pre', 'Iniciativa: prefiles preseleccionados', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyini_perfiles_desc', 'Iniciativa: perfiles descripcion', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyini_info', 'Iniciativa: Información y consultas', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyini_info_desc', 'Iniciativa: info descripcion', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyini_ganadores', 'Iniciativa: Perfiles ganadores', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyini_ganadores_desc', 'Iniciativa: ganadores descripcion', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proyini_plataforma', 'Iniciativa: ingresar a la plataforma', 'Traducción', TRUE, 100);?>

									<? input_lenguaje('text', $lenguajes, $infos, 'proybus_todos', 'Buscador: todos los proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proybus_activos', 'Buscador: proyectos activos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proybus_ejecutados', 'Buscador: proyectos ejecutados', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proybus_encontraron', 'Buscador: Se encontraron', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proybus_iniciativas', 'Buscador: iniciativas y/o proyectos', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proybus_siguiendo', 'Buscador: siguiendo...', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proybus_pagina', 'Buscador: pagina', 'Traducción', TRUE, 100);?>
									<? input_lenguaje('text', $lenguajes, $infos, 'proybus_de', 'Buscador: de', 'Traducción', TRUE, 100);?>
									
									
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


			</div>

		</div><!-- end row -->

	</div><!-- container-fluid -->
</div><!-- content -->
