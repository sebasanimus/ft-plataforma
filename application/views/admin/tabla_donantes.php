	

<table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
	<thead>
		<tr>
			<th style="max-width:200px">Logo</th>
			<th>Nombre</th>
			<th>Orden</th>
			<th style="min-width:200px">Acciones</th>
		</tr>
	</thead>
	<tbody id="arrastrables">
		<?foreach($donantes as $elem):	?>
			<tr class="fila">
				<td><?
					if(!empty($elem['logo'])){
						echo '<div class="img-container"><img style="max-width:200px" src="'.base_url().'/uploads/organismos/'.$elem['logo'].'"></div>';
					}						
					?>
				</td>
				<td><?=$elem['nombre']?></td>
				<td><?=$elem['orden']?></td>
				<td>
					<a href="javascript:accionEliminarDonante(<?=$elem['iddonante']?>);" class="btn btn-link btn-danger btn-just-icon" title="Eliminar" ><i class="material-icons">close</i></a> &nbsp;
				</td>
			</tr>
		<?endforeach?>
	</tbody>
</table>