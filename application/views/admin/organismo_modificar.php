<div class="content">
    <div class="container-fluid">
    	<div class="row">

        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">list</i>
						</div>
						<h4 class="card-title"><?=(!empty($pais))?'Modificar':'Crear'?> Organismos</h4>
						<p class="card-category" style="color:grey">&nbsp;</p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						<div class="nav-item dropdown opciones-toolbar" style="">	
							<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons text_align-center">more_vert</i>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item dropdown-item-rose" href="admin/organismos/listar">Listar Organismos</a>
								<a class="dropdown-item dropdown-item-rose" href="admin/organismos/modificar/0">Crear Organismo Nuevo</a>
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
								<? input_text('text', $organismo, 'nombre', 'Sigla', 'Sigla del organismo', true, 100)?>	
								<? input_text('text', $organismo, 'nombre_largo', 'Nombre', 'Nombre del organismo', false, 100)?>	
								<? input_text('url', $organismo, 'link', 'Link', 'Web oficial del organismo', false, 100)?>	
								<? input_select($organismo, $tipo_institucion, 'tipo_institucion', 'Tipo de Institución', TRUE);?>
								<? input_select($organismo, $paises, 'idpais', 'Pais', FALSE);?>
								<? input_imagen($organismo, 'logo', 'Logo', 'organismos', false, '')?>
								<? input_check($organismo, 'habilitado', 'Habilitado', true)?>						
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

			<?if(!empty($propuestas['financieros'])):?>
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">attach_money</i>
						</div>
						<h4 class="card-title">En Propuestas como ítem financiero (<?=sizeof($propuestas['financieros'])?>)</h4>
						<p class="card-category" style="color:grey">&nbsp;</p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						
						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Identificador</th>
										<th>Año</th>
										<th>Título Simple</th>
										<th>Sector Productivo</th>
										<th>Estado</th>
										<th>Total</th>
										<th>Participación</th>
										<th class="disabled-sorting text-right">Acciones</th>
									</tr>
								</thead>                     
								<tbody>
								<?foreach($propuestas['financieros'] as $pf):?>
									<tr>
										<td><?=$pf['identificador']?></td>
										<td><?=$pf['anio']?></td>
										<td><?=$pf['titulo_simple']?></td>
										<td><?=$pf['sector_productivo']?></td>
										<td><?=$pf['elestado']?></td>
										<td><?='$ '.number_format($pf['total_item'],0)?></td>
										<td><?=$pf['nombre_participacion']?></td>
										<td class="text-right"><a href="admin/propuestas/ver/<?=$pf['idpropuesta']?>" class="btn btn-link btn-info btn-just-icon" title="Ver"><i class="material-icons">remove_red_eye</i><div class="ripple-container"></div></a></td>
									</tr>
								<?endforeach?>
								</tbody>
							</table>  
						</div>
					</div><!-- card-body -->
				</div><!-- card -->
			</div><!-- col-md-12 -->
			<?endif?>

			<?if(!empty($propuestas['donantes'])):?>
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">assignment_turned_in</i>
						</div>
						<h4 class="card-title">En Propuestas como donante (<?=sizeof($propuestas['donantes'])?>)</h4>
						<p class="card-category" style="color:grey">&nbsp;</p>
						
					</div><!-- card-header -->
					
                	<div class="card-body ">						
						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Identificador</th>
										<th>Año</th>
										<th>Título Simple</th>
										<th>Sector Productivo</th>
										<th>Estado</th>
										<th class="disabled-sorting text-right">Acciones</th>
									</tr>
								</thead>                     
								<tbody>
								<?foreach($propuestas['financieros'] as $pd):?>
									<tr>
										<td><?=$pd['identificador']?></td>
										<td><?=$pd['anio']?></td>
										<td><?=$pd['titulo_simple']?></td>
										<td><?=$pd['sector_productivo']?></td>
										<td><?=$pd['elestado']?></td>
										<td class="text-right"><a href="admin/propuestas/ver/<?=$pd['idpropuesta']?>" class="btn btn-link btn-info btn-just-icon" title="Ver"><i class="material-icons">remove_red_eye</i><div class="ripple-container"></div></a></td>
									</tr>
								<?endforeach?>
								</tbody>
							</table>  
						</div>
						</div><!-- card-body -->
				</div><!-- card -->
			</div><!-- col-md-12 -->
			<?endif?>

			<?if(!empty($propuestas['webstories'])):?>
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">web</i>
						</div>
						<h4 class="card-title">En Webstories (<?=sizeof($propuestas['webstories'])?>)</h4>
						<p class="card-category" style="color:grey">&nbsp;</p>
						
					</div><!-- card-header -->
					
                	<div class="card-body ">						
						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Identificador</th>
										<th>Título Simple</th>
										<th class="disabled-sorting text-right">Acciones</th>
									</tr>
								</thead>                     
								<tbody>
								<?foreach($propuestas['webstories'] as $pd):?>
									<tr>
										<td><?=$pd['identificador']?></td>
										<td><?=$pd['titulo_simple']?></td>
										<td class="text-right"><a href="admin/webstories/ver/<?=$pd['idwebstory']?>" class="btn btn-link btn-info btn-just-icon" title="Ver"><i class="material-icons">remove_red_eye</i><div class="ripple-container"></div></a></td>
									</tr>
								<?endforeach?>
								</tbody>
							</table>  
						</div>
					</div><!-- card-body -->
				</div><!-- card -->
			</div><!-- col-md-12 -->
			<?endif?>

		</div><!-- row -->
	</div><!-- container-fluid -->
</div><!-- content -->