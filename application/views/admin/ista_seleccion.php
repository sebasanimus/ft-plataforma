<div class="content">
    <div class="container-fluid">
		<h3>ISTAs</h3>
        <br>
        <div class="row">
			<?if (empty($callistas)):?>
				No tiene Istas para cargar
			<?endif?>
			<?foreach($callistas as $call):
				$link = "window.location.href = '".base_url()."admin/istas/pasos/".$call['idcallista']."/".$call['idpropuesta']."'";
				$foto = empty($call['web_foto'])?  base_url().'img/proyecto/bgPerfil.jpg' : base_url().'uploads/propuestas/'.$call['web_foto'];
				?>
            <div class="col-md-4">
                <div class="card card-product">
					<div class="card-header card-header-image" data-header-animation="true">
						<a href="#pablo">
							<img class="img" src="<?=$foto?>">
						</a>
					</div>
					<div class="card-body">
						<div class="card-actions text-center">
							<button type="button" class="btn btn-danger btn-link fix-broken-card">
								<i class="material-icons">build</i> Fix Header!
							</button>
							<button type="button" onclick="<?=$link?>" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Ingresar">
								<i class="material-icons">check_circle_outline</i>
							</button>
						</div>
						<h4 class="card-title">
							<a href="javascript:<?=$link?>"><?=$call['titulo_simple']?></a>
						</h4>
						<div class="card-description">
							<?=$call['descripcion']?>
						</div>
					</div>
					<div class="card-footer">
						<div class="price">
							<h4><?=$call['titulo']?></h4>
						</div>
						<div class="stats">
							<p class="card-category"><i class="material-icons">calendar_today</i> <?=fromYYYYMMDDtoDDMMYYY($call['fecha_hasta'], false)?></p>
						</div>
					</div>
                </div>
            </div>
			<?endforeach?>
        </div>

    	
	</div><!-- container-fluid -->
</div><!-- content -->
