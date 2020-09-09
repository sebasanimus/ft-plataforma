
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">menu</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
            <a class="navbar-brand" href="#">Administrador</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <!--<form class="navbar-form">
              <span class="bmd-form-group"><div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div></span>
            </form>-->
            <ul class="navbar-nav">
              <!--<li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>-->
              <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span id="alertaNum" class="notification" style="display:none">2</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div id="alertas" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" style="max-height: 300px; overflow: auto;">
                  <!--<a class="dropdown-item dropdown-item-rose" href="#">Proyecto incompleto</a>
                  <a class="dropdown-item dropdown-item-rose" href="#">Se debe habilitar la convocatoria</a>-->
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Cuenta
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
				  <?if($this->login->hasAccess('admin','usuarios')):?>
                  <a class="dropdown-item dropdown-item-rose" href="usuarios/ver/<?=$this->session->userdata('idusuario');?>">Perfil</a>
                  <div class="dropdown-divider"></div>
				  <?endif?>
                  <a class="dropdown-item dropdown-item-rose" href="welcome/logout">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>