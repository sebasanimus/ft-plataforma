<div class="row contpaso paso1">
	<div class="col-md-12">
		<div class="card ">
		<div class="card-header card-header-rose card-header-text">
			<div class="card-text">
			<h4 class="card-title"><?=$textos['paso_1']?></h4>
			</div>
		</div>
		<div class="card-body ">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="title" class="bmd-label-floating"> <?=$textos['titulo']?></label>
						<label type="text" class="form-control" ><?=$perfil['titulo']?></label>
						<small><?=$textos['titulo_descripcion']?></small>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label for="stitle" class="bmd-label-floating"> <?=$textos['titulo_corto']?></label>
						<label type="text" class="form-control" ><?=$perfil['titulo_corto']?></label>
						<small><?=$textos['titulo_corto_descripcion']?></small>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div><!-- col-md-12 -->
	<div class="col-md-12">
		<div class="card ">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-text">
					<h4 class="card-title"><?=$textos['ods']?></h4>
				</div>
			</div>
			<div class="card-body ">
				<div class="row justify-content-center ods">
					<div class="col-lg-12 text-center"> 
						<?foreach($badges as $badge):?>
							<?if(!empty($perfil['badgesObtenidas'][$badge['idbadgeods']])):?>		
								<img src="uploads/badges/<?=$badge['foto']?>" alt="<?=$badge['nombre']?>">
							<?endif?>
						<?endforeach?>
					</div>
					<small><?=$textos['ods_descripcion']?></small>
				</div>
			</div>					
		</div>
	</div><!-- col-md-12 -->

	<div class="col-md-6">
		<div class="card ">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-text">
					<h4 class="card-title"><?=$textos['linea_estrategica']?></h4>
				</div>
			</div>
			<div class="card-body ">
				<label type="text" class="form-control" ><?=empty($estrategica)? '' : $estrategica['nombre']?></label>
			</div>						
		</div>	
	</div><!-- col-md-6 -->

	<div class="col-md-6">
		<div class="card ">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-text">
					<h4 class="card-title"><?=$textos['tipo_de_innovacion']?></h4>
				</div>
			</div>
			<div class="card-body ">
				<label type="text" class="form-control" ><?=empty($tipoInnovacion)? '' : $tipoInnovacion['nombre']?></label>
			</div>						
		</div>	
	</div><!-- col-md-6 -->

	<div class="col-md-6">
		<div class="card ">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-text">
					<h4 class="card-title"><?=$textos['tipo_de_investigacion']?></h4>
				</div>
			</div>
			<div class="card-body ">
				<label type="text" class="form-control" ><?=empty($tipoInvestigacion)? '' : $tipoInvestigacion['nombre']?></label>
			</div>						
		</div>	
	</div><!-- col-md-6 -->

	<div class="col-md-6">
		<div class="card ">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-text">
					<h4 class="card-title"><?=$textos['solucion_tecnologica']?></h4>
				</div>
			</div>
			<div class="card-body ">
				<label type="text" class="form-control" ><?=empty($solucion)? '' : $solucion['nombre']?></label>
			</div>						
		</div>	
	</div><!-- col-md-6 -->

	<div class="col-md-12">
		<div class="card ">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-text">
					<h4 class="card-title"><?=$textos['temas']?></h4>
				</div>
			</div>
			<div class="card-body temas">
				<?foreach($temas as $tema):?>
					<label type="text" class="form-control"><?=$tema['nombre']?></label>
				<?endforeach?>
			</div>						
		</div>	
	</div><!-- col-md-12 -->

	<div class="col-md-12">
		<div class="card ">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-text">
					<h4 class="card-title"><?=$textos['sector_productivo']?></h4>
				</div>
			</div>
			<div class="card-body ">
				<?foreach($perfil['sector'] as $sector):?>
					<label type="text" class="form-control"><b><?=$sector['nombre']?></b>: 
						<?foreach($sector['subsectores'] as $subsector):?>
							<?=$subsector['nombre']?> - 
						<?endforeach?>
					</label>
				<?endforeach?>
			</div>						
		</div>	
	</div><!-- col-md-12 -->

</div><!-- row paso1 -->