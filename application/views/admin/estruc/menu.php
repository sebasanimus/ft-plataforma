<div class="sidebar" data-color="rose" data-background-color="black" data-image="material/assets/img/sidebar-2.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="https://www.fontagro.org/" class="simple-text logo-mini">
          FO
        </a>
        <a href="https://www.fontagro.org/" class="simple-text logo-normal">
          Fontagro
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="img/avatar/<?=$this->session->userdata('avatar');?>.png">
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
			  	<?=$this->session->userdata('username');?>
                <b class="caret"></b>
              </span>
            </a>
            <div class="collapse" id="collapseExample">
              <ul class="nav">
			 	<?if($this->login->hasAccess('admin','usuarios')):?>
                <li class="nav-item">
                  <a class="nav-link" href="admin/usuarios/ver/<?=$this->session->userdata('idusuario');?>">
                    <span class="sidebar-mini"> MP </span>
                    <span class="sidebar-normal"> Mi Perfil </span>
                  </a>
                </li>
				<?endif?>
                <li class="nav-item">
                  <a class="nav-link" href="admin/welcome/logout">
                    <span class="sidebar-mini"> LO </span>
                    <span class="sidebar-normal"> Log Out </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
		  <?if($this->login->hasAccess('admin','dashboard')):?>
          <li class="nav-item">
            <a class="nav-link" href="admin/dashboard/">
              <i class="material-icons">dashboard</i>
              <p> Dashboard </p>
            </a>
          </li>
		  <?endif?>
		  <?if($this->login->hasAccess('admin','usuarios')):?>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples1">
              <i class="material-icons">settings</i>
              <p> Configuración
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="pagesExamples1">
              <ul class="nav">
			  	<?if($this->login->hasAccess('admin','usuarios','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/usuarios/listar">
						<span class="sidebar-mini"> U </span>
						<span class="sidebar-normal"> Usuarios </span>
					</a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','lenguajes','listar')):?>
                <li class="nav-item ">
                  <a class="nav-link" href="admin/lenguajes/listar">
                    <span class="sidebar-mini"> L </span>
                    <span class="sidebar-normal"> Lenguajes </span>
                  </a>
                </li>
				<?endif?>
              </ul>
            </div>
          </li>
		  <?endif?>  
		  <?if($this->login->hasAccess('admin','parametros', 'listar')):?>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples2">
              <i class="material-icons">list</i>
              <p> Parámetros
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="pagesExamples2">
              <ul class="nav">
				<?if($this->login->hasAccess('admin','componente','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Componente">
						<span class="sidebar-mini"> C </span>
						<span class="sidebar-normal"> Componente </span>
					</a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','estado','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Estado">
						<span class="sidebar-mini"> E </span>
						<span class="sidebar-normal"> Estado </span>
					</a>
                </li>
				<?endif?>        
				<?if($this->login->hasAccess('admin','indicastandares','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/indicastandares/listar">
						<span class="sidebar-mini"> I </span>
						<span class="sidebar-normal"> Indicador </span>
					</a>
                </li>
				<?endif?>  
				<?if($this->login->hasAccess('admin','estrategica','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Estrategica">
						<span class="sidebar-mini"> LE </span>
						<span class="sidebar-normal"> Línea Estratégica </span>
					</a>
                </li>
				<?endif?>     
				<?if($this->login->hasAccess('admin','badges','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/badges/listar">
						<span class="sidebar-mini"> ODS </span>
						<span class="sidebar-normal"> ODS Badges </span>
					</a>
                </li>
				<?endif?>  
				<?if($this->login->hasAccess('admin','organismos','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/organismos/listar">
						<span class="sidebar-mini"> ORG </span>
						<span class="sidebar-normal"> Organismos </span>
					</a>
                </li>
				<?endif?>  
				<?if($this->login->hasAccess('admin','organismosugeridos','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/organismosugeridos/listar">
						<span class="sidebar-mini"> ORS </span>
						<span class="sidebar-normal"> Org. Solicitados</span>
					</a>
                </li>
				<?endif?> 
				<?if($this->login->hasAccess('admin','paises','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/paises/listar">
						<span class="sidebar-mini"> P </span>
						<span class="sidebar-normal"> País </span>
					</a>
                </li>
				<?endif?>  
				<?if($this->login->hasAccess('admin','participacion','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Participacion">
						<span class="sidebar-mini"> P </span>
						<span class="sidebar-normal"> Participacion </span>
					</a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','region','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Region">
						<span class="sidebar-mini"> R </span>
						<span class="sidebar-normal"> Región </span>
					</a>
                </li>
				<?endif?> 
				<?if($this->login->hasAccess('admin','sectores','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/sectores/listar">
						<span class="sidebar-mini"> SP </span>
						<span class="sidebar-normal"> Sector Productivo </span>
					</a>
                </li>
				<?endif?> 
				<?if($this->login->hasAccess('admin','solucion','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Solucion">
						<span class="sidebar-mini"> TEC </span>
						<span class="sidebar-normal"> Solución Tecnológica </span>
					</a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','innovacion','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Innovacion">
						<span class="sidebar-mini"> INN </span>
						<span class="sidebar-normal"> Tipo de Innovación </span>
					</a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','institucion','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Institucion">
						<span class="sidebar-mini"> INS </span>
						<span class="sidebar-normal"> Tipo de Institución </span>
					</a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','investigacion','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Investigacion">
						<span class="sidebar-mini"> INV </span>
						<span class="sidebar-normal"> Tipo de Investigación </span>
					</a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','operacion','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Operacion">
						<span class="sidebar-mini"> OP </span>
						<span class="sidebar-normal"> Tipo de Operacion </span>
					</a>
                </li>
				<?endif?>  
				<?if($this->login->hasAccess('admin','tema','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/parametros/listar/Tema">
						<span class="sidebar-mini"> TE </span>
						<span class="sidebar-normal"> Tema </span>
					</a>
                </li>
				<?endif?>  
				<?if($this->login->hasAccess('admin','unidades','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/unidades/listar">
						<span class="sidebar-mini"> U </span>
						<span class="sidebar-normal"> Unidad </span>
					</a>
                </li>
				<?endif?> 
              </ul>
            </div>
          </li>
		  <?endif?>  
		  <?if($this->login->hasAccess('admin','propuestas')):?>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples3">
              <i class="material-icons">assignment</i>
              <p> Proyectos
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="pagesExamples3">
              <ul class="nav">
			  	<?if($this->login->hasAccess('admin','propuestas','listar')):?>
                <li class="nav-item ">
					<a class="nav-link" href="admin/propuestas/listar">
						<span class="sidebar-mini"> P </span>
						<span class="sidebar-normal"> Propuestas </span>
					</a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','webstories','listar')):?>
                <li class="nav-item ">
                  <a class="nav-link" href="admin/webstories/listar">
                    <span class="sidebar-mini"> WS </span>
                    <span class="sidebar-normal"> webstories </span>
                  </a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','techies','listar')):?>
                <li class="nav-item ">
                  <a class="nav-link" href="admin/techies/listar">
                    <span class="sidebar-mini"> T </span>
                    <span class="sidebar-normal"> Tech </span>
                  </a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','iniciativas','listar')):?>
                <li class="nav-item ">
                  <a class="nav-link" href="admin/iniciativas/listar">
                    <span class="sidebar-mini"> I </span>
                    <span class="sidebar-normal"> Iniciativas </span>
                  </a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','callistas','listar')):?>
                <li class="nav-item ">
                  <a class="nav-link" href="admin/callistas/listar">
                    <span class="sidebar-mini"> CI </span>
                    <span class="sidebar-normal"> Call Istas </span>
                  </a>
                </li>
				<?endif?>
				<?if($this->login->hasAccess('admin','istas','seleccion')):?>
                <li class="nav-item ">
                  <a class="nav-link" href="admin/istas/seleccion">
                    <span class="sidebar-mini"> IS </span>
                    <span class="sidebar-normal"> Istas </span>
                  </a>
                </li>
				<?endif?>
              </ul>
            </div>
          </li>		  
		  <?endif?>  
		  <?if($this->login->hasAccess('admin','fontagros','modificar')):?>
          <li class="nav-item">
            <a class="nav-link" href="admin/fontagros/modificar/">
              <i class="material-icons">insert_drive_file</i>
              <p> Fontagro en Breve </p>
            </a>
          </li>
		  <?endif?>       
        </ul>
      </div>
 <div class="sidebar-background" style="background-image: url(material/assets/img/sidebar-2.jpg) "></div></div>