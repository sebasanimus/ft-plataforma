
<div class="sidebar" data-color="azure" data-background-color="black">
    
	  <div class="logo">
          <a class="align-middle pl-4" href="#" style="height: auto;"><img src="material/assets/img/fontagro.png" alt="Fontagro - Perfiles y proyectos"></a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="material/assets/img/faces/avatar.jpg">
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
			  	<?=$this->session->userdata('nombre');?>
                <b class="caret"></b>
              </span>
            </a>           
          </div>
        </div>
        <ul class="nav">		 
		  <?if($page=='pasos'):?>
			<div class="statusBox rounded m-3 p-2 pt-3 shadow-sm level1">
				<span class="statusTitle">
					<?=$textos['ista_datos_requeridos']?>
				</span>
				<span class="statusNumber">
					0%
				</span>
				<div class="barBox">
					<div class="progress">
						<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
				<!-- este cartel solo aparece cuando falten x dias para cerrar la convocatoria -->
				<div id="notificacion_incompleto" class="alert alert-warning" data-notify="container" style="display:none">
                    <span data-notify="message"><?=$textos['ista_notificacion_incompleto']?> <br><a style="font-weight: bold;" href="javascript:cambiarPaso(7)"><?=$textos['ista_menu_mas_info']?></a></span>
				</div>
				<div id="notificacion_completo" class="alert alert-success" data-notify="container" style="display:none">
                    <span data-notify="message"><?=$textos['ista_notificacion_completo']?> <br><a style="font-weight: bold;" href="javascript:cambiarPaso(7)"><?=$textos['ista_menu_mas_info']?></a></span>
				</div>
				<!-- este cartel solo aparece cuando falten x dias para cerrar la convocatoria -->
			</div>
			
			<li class="nav-item ">
				<a class="nav-link" href="javascript:seleccionar()">
					<i class="material-icons">content_paste</i>
					<p> <?=$callista['titulo']?> </p>
				</a>
			</li>
			<ul class="nav subnav bottomLine level1">
				<li class="nav-item menu1">
					<a class="nav-link" href="javascript:cambiarPaso(1)">
						<span class="sidebar-mini"> 01 </span>
						<span class="sidebar-normal"> <?=$textos['ista_paso_1']?> </span>
						<span class="pasoCompletitud"></span>
					</a>
				</li>
				<li class="nav-item menu2">
					<a class="nav-link" href="javascript:cambiarPaso(2)">
						<span class="sidebar-mini"> 02 </span>
						<span class="sidebar-normal"> <?=$textos['ista_paso_2']?> </span>
						<span class="pasoCompletitud"></span>
					</a>
				</li>
				<li class="nav-item menu3">
					<a class="nav-link" href="javascript:cambiarPaso(3)">
						<span class="sidebar-mini"> 03 </span>
						<span class="sidebar-normal"> <?=$textos['ista_paso_3']?> </span>
						<span class="pasoCompletitud"></span>
					</a>
				</li>
				<li class="nav-item menu4">
					<a class="nav-link" href="javascript:cambiarPaso(4)">
						<span class="sidebar-mini"> 04 </span>
						<span class="sidebar-normal"> <?=$textos['ista_paso_4']?> </span>
						<span class="pasoCompletitud"></span>
					</a>
				</li>
				<li class="nav-item menu5">
					<a class="nav-link" href="javascript:cambiarPaso(5)">
						<span class="sidebar-mini"> 05 </span>
						<span class="sidebar-normal"> <?=$textos['ista_paso_5']?> </span>
						<span class="pasoCompletitud"></span>
					</a>
				</li>
				<li class="nav-item menu6">
					<a class="nav-link" href="javascript:cambiarPaso(6)">
						<span class="sidebar-mini"> 06 </span>
						<span class="sidebar-normal"> <?=$textos['ista_paso_6']?> </span>
						<span class="pasoCompletitud"></span>
					</a>
				</li>
			</ul>
			<li class="nav-item level1">
				<a class="nav-link back text-info" href="<?=base_url()?>admin/dashboard/">
					<i class="material-icons bg-info rounded-circle ">keyboard_backspace</i>
					<p> <?=$textos['ista_volver']?> </p>
				</a>
			</li>
		  <?endif?>	       
        </ul>
      </div>
 </div>