<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      <div class="navbar-wrapper">
        <a class="navbar-brand align-middle" href="<?=base_url()?>iniciativas/" style="height: auto;"><img src="material/assets/img/fontagro.png" alt="Fontagro - Perfiles y proyectos"></a> <strong class="align-middle d-none d-sm-none d-md-block"><?=$textos['perfiles_y_proyectos']?></strong>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          
          <li class="nav-item <?=($page=='registro')? 'active' : ''?>">
            <a href="<?=base_url()?>iniciativas/registro" class="nav-link">
              <i class="material-icons">person_add</i> <?=$textos['registro']?>
            </a>
          </li>
          <li class="nav-item <?=($page=='login')? 'active' : ''?> ">
            <a href="<?=base_url()?>iniciativas/" class="nav-link">
              <i class="material-icons">fingerprint</i> <?=$textos['login']?>
            </a>
          </li>
		  
          <li class="nav-item lang">
            <a href="<?=base_url()?>iniciativas/?codlang=es" class="nav-link <?=$codlang=='es'?'active':''?>">ES</a>
            <a href="<?=base_url()?>iniciativas/?codlang=en" class="nav-link <?=$codlang=='en'?'active':''?>">EN</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->