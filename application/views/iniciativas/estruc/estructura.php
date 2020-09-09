<!DOCTYPE html>
<html lang="es">
  <head>
    <?php $this->load->view('iniciativas/estruc/header'); ?>
  </head>

  <body class="">
    <div class="wrapper">
        <?php $this->load->view('iniciativas/estruc/menu'); ?>
		<div class="main-panel">
			<!-- top navigation -->
			<?php $this->load->view('iniciativas/estruc/top_nav'); ?>
			<!-- /top navigation -->

			<!-- page content -->
			<?php $this->load->view('iniciativas/'.$page); ?>
			<!-- /page content -->

			<!-- footer content -->
			<?php $this->load->view('iniciativas/estruc/footer'); ?>
			<!-- /footer content -->
		</div>

    </div>

    <?php $this->load->view('iniciativas/estruc/scripts'); ?>
  </body>
</html>
