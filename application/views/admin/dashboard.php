


    <div class="content">
        <div class="container-fluid">

			<div class="row">
              	<div class="col-md-12">
                	<div class="card ">
                  		<div class="card-header card-header-success card-header-icon">
							<div class="card-icon">
								<i class="material-icons"></i>
							</div>
                    		<h4 class="card-title">Aportes de Fontagro</h4>
                		</div>
                  		<div class="card-body ">
							<div class="row">
								<div class="col-md-6">
									<div class="table-responsive table-sales">
										<table class="table">
											<tbody>
											<?$i=0;
											foreach($aportes['paises'] as $pais):
												$i++;
												if($i>6) break;
											?>
												<tr>
													<td>
													<div class="flag">
														<img src="img/flags/<?=strtolower($pais['code'])?>.png" />
													</td>
													<td><?=$pais['nombre']?></td>
													<td class="text-right"><?=number_format($pais['total'], 0, ',', '.')?> $</td>
													<td class="text-right"><?=round(100*$pais['total']/$aportes['total'],1)?>%</td>
												</tr>
											<?endforeach?>												
                            				</tbody>
                          				</table>
                          			</div>
                          		</div>
                          		<div class="col-md-6 ml-auto mr-auto">
                            		<div id="worldMap" style="height: 300px;"></div>
                          		</div>
                          	</div>
                        </div>
                    </div>
                </div>
            </div>

			<?if($this->session->userdata('role')==0):?>				 
			<div class="row">
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-rose" data-header-animation="true">
                            <div class="ct-chart" id="websiteViewsChart"></div>
                        </div>
                        <div class="card-body">
                            <div class="card-actions">
								<button type="button" class="btn btn-danger btn-link fix-broken-card">
									<i class="material-icons">build</i> Fix Header!
								</button>
								<button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
									<i class="material-icons">refresh</i>
								</button>
								<button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
									<i class="material-icons">edit</i>
								</button>
							</div>
                            <h4 class="card-title">Visitas mensuales</h4>
                            <p class="card-category">de personas únicas</p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!--<i class="material-icons">access_time</i> último año-->
								<i class="material-icons text-danger">warning</i> Datos DEMO
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-success" data-header-animation="true">
                            <div class="ct-chart" id="dailySalesChart"></div>
                        </div>
                        <div class="card-body">
                            <div class="card-actions">
								<button type="button" class="btn btn-danger btn-link fix-broken-card">
									<i class="material-icons">build</i> Fix Header!
								</button>
								<button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
									<i class="material-icons">refresh</i>
								</button>
								<button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
									<i class="material-icons">edit</i>
								</button>
                            </div>
                            <h4 class="card-title">Propuestas recibidas</h4>
                            <p class="card-category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> incremento de hoy.</p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!--<i class="material-icons">access_time</i> última semana-->
								<i class="material-icons text-danger">warning</i> Datos DEMO
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-info" data-header-animation="true">
                        	<div class="ct-chart" id="completedTasksChart"></div>
                        </div>
                        <div class="card-body">
                        	<div class="card-actions">
								<button type="button" class="btn btn-danger btn-link fix-broken-card">
									<i class="material-icons">build</i> Fix Header!
								</button>
								<button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Refresh">
									<i class="material-icons">refresh</i>
								</button>
								<button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Change Date">
									<i class="material-icons">edit</i>
								</button>
                            </div>
                            <h4 class="card-title">ISTA's cargados</h4>
                            <p class="card-category">de los proyectos activos</p>
                        </div>
                        <div class="card-footer">
							<div class="stats">
								<!--<i class="material-icons">access_time</i> Los últimos 3 meses-->
								<i class="material-icons text-danger">warning</i> Datos DEMO
							</div>
                        </div>
                    </div>
                </div>
			</div>
			<?endif?>
			<?if($this->session->userdata('role')==1 || $this->session->userdata('role')==5):?>
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-warning card-header-icon">
						<div class="card-icon">
							<i class="material-icons">person</i>
						</div>
						<p class="card-category">Usuarios</p>
						<h3 class="card-title"><?=$cantidadusuarios?></h3>
						</div>
						<div class="card-footer">
						<div class="stats">
							<i class="material-icons">update</i> Accedieron en la última semana
						</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">date_range</i>
						</div>
						<p class="card-category">Iniciativas abiertas</p>
						<h3 class="card-title"><?=$cantiniciativas?></h3>
						</div>
						<div class="card-footer">
						<div class="stats">
							<i class="material-icons">local_offer</i> Actualmente
						</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-success card-header-icon">
						<div class="card-icon">
							<i class="material-icons">done_all</i>
						</div>
						<p class="card-category">Proyectos Aprobados</p>
						<h3 class="card-title"><?=$cantpropuestas?></h3>
						</div>
						<div class="card-footer">
						<div class="stats">
							<i class="material-icons">date_range</i> Desde 1998
						</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header card-header-info card-header-icon">
						<div class="card-icon">
							<i class="material-icons">image</i>
						</div>
						<p class="card-category">Fotos y videos</p>
						<h3 class="card-title">+<?=$cantadjuntos?></h3>
						</div>
						<div class="card-footer">
						<div class="stats">
							<i class="material-icons">update</i> Recién actualizado
						</div>
						</div>
					</div>
				</div>
			</div>
			<?endif?>
			<h3>Últimas noticias de los proyectos</h3>
            <br>
			<div class="row">
				<?foreach($noticias as $noticia):?>
				<div class="col-md-4">
					<div class="card card-product">
						<div class="card-header card-header-image" data-header-animation="true">
							<a href="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/es/<?=$noticia['url']?>" target="_blank">
								<img class="img" src="<?=base_url()?>uploads/noticias/400_<?=$noticia['foto']?>">
							</a>
						</div>
						<div class="card-body">
							<div class="card-actions text-center">
								<button type="button" class="btn btn-danger btn-link fix-broken-card">
									<i class="material-icons">build</i> Fix Header!
								</button>
								<a href="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/es/<?=$noticia['url']?>" target="_blank" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="Ver">
									<i class="material-icons">art_track</i>
								</a>
								<a href="<?=base_url()?>admin/noticias/modificar/<?=$noticia['idpropuesta']?>/<?=$noticia['idnoticia']?>" type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Editar">
									<i class="material-icons">edit</i>
								</a>
							</div>
							<h4 class="card-title">
								<a href="<?=base_url()?>noticias/<?=$noticia['idnoticia']?>/es/<?=$noticia['url']?>" target="_blank"><?=$noticia['titulo']?></a>
							</h4>
							<div class="card-description">
								<?=$noticia['bajada']?>
							</div>
						</div>
						<div class="card-footer">
							<div class="price">
								<h4><?=$noticia['titulo_simple']?></h4>
							</div>
						</div>
					</div>
				</div>
				<?endforeach?>
				
			</div>
                        
            <br>
                        
		</div>
	</div>