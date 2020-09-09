<div class="content">
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<div class="card ">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">list</i>
						</div>
						<h4 class="card-title"><?=(!empty($sector))?'Modificar':'Crear'?> Sector</h4>
						<p class="card-category" style="color:grey">&nbsp;</p>
						
					</div><!-- card-header -->

                	<div class="card-body ">
						<div class="nav-item dropdown opciones-toolbar" style="">	
							<a class="btn btn-just-icon btn-white btn-fab btn-round"  data-toggle="dropdown" href="#0" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons text_align-center">more_vert</i>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item dropdown-item-rose" href="admin/sectores/listar">Listar Sectores</a>
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
							<?$disabled = (isset($readonly) && $readonly)? 'disabled' : '' ?>
							<fieldset <?=$disabled?> >
								<? input_lenguaje('text', $lenguajes, $datas_lang, 'nombre', 'Título');?> 
								
								<br/>
							</fieldset>
							<div class="ln_solid"></div>
							<? if(empty($readonly)): ?>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button class="btn btn-fill" onclick="window.history.back();" type="button"><i class="material-icons">keyboard_arrow_left</i> Cancelar</button>
									<button class="btn btn-fill btn-rose" type="submit"><i class="material-icons">save</i> Guardar</button>
									</div>
								</div>
							<? endif;?>
						</form>
					</div><!-- card-body -->
				</div><!-- card -->
			</div><!-- col-md-12 -->
		</div><!-- row -->

		<?if(!empty($idsector)):?>
		<div class="row">
        	<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">subdirectory_arrow_right</i>
						</div>
						<h4 class="card-title">Subsectores</h4>
						<p class="card-category" style="color:grey">&nbsp;</p>
					</div>
					<div class="card-body">
						<div class="toolbar" style="text-align:center; clear:both">
							<button onclick="abrirModal()" class="btn btn-primary btn-round btn-fab" rel="tooltip" data-placement="bottom" title="Nuevo Subsector" >
								<i class="material-icons">add</i>
								<div class="ripple-container"></div>
							</button>	
						</div>

						<div class="material-datatables">
							<table id="midatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
								<thead>
									<tr>
										<th>Nombre</th>
										<th class="disabled-sorting text-right">Acciones</th>
									</tr>
								</thead>                     
								<tbody>
								</tbody>
							</table>  
						</div>
						
					</div><!-- end content-->
				</div><!--  end card  -->	
			</div><!-- col-md-12 -->
		</div><!-- row -->
		<?endif?>
	</div><!-- container-fluid -->
</div><!-- content -->



<div class="modal fade" id="subsectorModal" tabindex="-1" role="">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
					<div class="card-header card-header-primary text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="card-title">Nuevo Subsector</h4>                    
					</div>
                </div>
                <div class="modal-body">
                    <form class="form" id="sub_form" method="" action="">
                        <p class="description text-center">Agregue un subsector</p>
                        <div class="card-body">
							<input type="hidden" value="0" name="idsubsector" id="sub_idsubsector"/>
							<input type="hidden" value="<?=$idsector?>" name="idsector"/>
							
							<? modal_input_lenguaje('text', $lenguajes, 'nombre', 'sub', 'Nombre', 'Nombre', 255);?>			

                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="javascript:agregarSubsector()" id="sub_btn" class="btn btn-primary btn-link btn-wd btn-lg">Agregar</a>
                </div>
            </div>
        </div>
    </div>
</div>