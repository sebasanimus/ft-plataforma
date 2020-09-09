<div class="content">
    <div class="container-fluid">
		<h3>Iniciativas</h3>
        <br>
        <div class="row">
			<?/*if(empty($iniciativas)):?>
				No hay convocatorias abiertas
			<?endif*/?>
			<?foreach($iniciativas as $iniciativa):
				$link = empty($iniciativa['idperfil'])? "anotarse(".$iniciativa['idiniciativa'].")" : "window.location.href = '".base_url()."iniciativas/perfiles/pasos/".$iniciativa['idperfil']."'";
				?>
            <div class="col-md-4">
                <div class="card card-product">
					<div class="card-header card-header-image" data-header-animation="true">
						<a href="#javascript:<?=$link?>">
							<img class="img" src="<?=base_url()?>uploads/noticias/<?=$iniciativa['foto']?>">
						</a>
					</div>
					<div class="card-body">
						<div class="card-actions text-center">
							<button type="button" class="btn btn-danger btn-link fix-broken-card">
								<i class="material-icons">build</i> Fix Header!
							</button>
							<button type="button" onclick="<?=$link?>" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Anotarse">
								<i class="material-icons">check_circle_outline</i>
							</button>
						</div>
						<h4 class="card-title">
							<a href="javascript:<?=$link?>"><?=$iniciativa['titulo']?></a>
						</h4>
						<div class="card-description">
							<?=$iniciativa['descripcion']?>
						</div>
					</div>
					<div class="card-footer">
						<div class="price">
							<h4><?=$iniciativa['tipo']?></h4>
						</div>
						<div class="stats">
							<p class="card-category"><i class="material-icons">calendar_today</i> <?=fromYYYYMMDDtoDDMMYYY($iniciativa['fecha_hasta'], false)?></p>
						</div>
					</div>
                </div>
            </div>
			<?endforeach?>
        </div>

		<div class="row">
			<?foreach($cerradas as $iniciativa):
				$link = ($iniciativa['porcentaje']==100)? "window.location.href = '".base_url().'admin/exportarpdf/generarPerfil/'.$iniciativa['idperfil']."'" : "";
				$linkPre = ($iniciativa['idestadoperfil']==2 && $iniciativa['idestadoreal']==2)? "window.location.href = '".base_url()."iniciativas/perfiles/preseleccionado/".$iniciativa['idperfil']."'" : '';
				$linkSel = ($iniciativa['idestadoperfil']==3 && $iniciativa['idestadoreal']==3)? "window.location.href = '".base_url()."iniciativas/perfiles/seleccionado/".$iniciativa['idperfil']."'" : '';
				?>
            <div class="col-md-4">
                <div class="card card-product">
					<div class="card-header card-header-image" data-header-animation="true">
						<a href="#">
							<img class="img" src="<?=base_url()?>uploads/noticias/<?=$iniciativa['foto']?>">
						</a>
					</div>
					<div class="card-body">
						<div class="card-actions text-center">
							<button type="button" class="btn btn-danger btn-link fix-broken-card">
								<i class="material-icons">build</i> Fix Header!
							</button>
							<?if(!empty($link)):?>
							<button type="button" onclick="<?=$link?>" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Descargar PDF">
								<i class="material-icons">get_app</i>
							</button>
							<?endif;?>
							<?if(!empty($linkPre)):?>
							<button type="button" onclick="<?=$linkPre?>" class="btn btn-warning btn-link" rel="tooltip" data-placement="bottom" title="Cargar documentos etapa preselección">
								<i class="material-icons">input</i>
							</button>
							<?endif;?>
							<?if(!empty($linkSel)):?>
							<button type="button" onclick="<?=$linkSel?>" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Cargar documentos Selección">
								<i class="material-icons">input</i>
							</button>
							<?endif;?>
						</div>
						<h4 class="card-title">
							<a href="javascript:<?=$link?>"><?=$iniciativa['titulo']?></a>
						</h4>
						<div class="card-description">
							<?if($iniciativa['porcentaje']==100):?>
								Su perfil: <b><?=$iniciativa['titulo_corto']?></b> fue enviado correctamente. Puede descar el pdf desde <a href="javascript:<?=$link?>">aqui</a>
							<?else:?>
								Su perfil: <b><?=$iniciativa['titulo_corto']?></b> no fue enviado ya que solo se completó en un <?=$iniciativa['porcentaje']?>%
							<?endif;?>
							<br>Estado: <b><?=$iniciativa['estadoperfil']?></b>
						</div>
					</div>
					<div class="card-footer">
						<div class="price">
							<h4><?=$iniciativa['tipo']?></h4>
						</div>
						<div class="stats">
							<p class="card-category"><i class="material-icons">calendar_today</i> <?=fromYYYYMMDDtoDDMMYYY($iniciativa['fecha_hasta'], true)?></p>
						</div>
					</div>
                </div>
            </div>
			<?endforeach?>
        </div>

    	
	</div><!-- container-fluid -->
</div><!-- content -->
