<!DOCTYPE html>
<html lang="es">
  <head>
    <?php $this->load->view('istas/estruc/header'); ?>
  </head>

  <body class="">
    <div class="wrapper">
        <?php $this->load->view('istas/estruc/menu'); ?>
		<div class="main-panel">
			<!-- top navigation -->
			<?php $this->load->view('istas/estruc/top_nav'); ?>
			<!-- /top navigation -->

			<!-- page content -->
			<?php $this->load->view('istas/'.$page); ?>
			<!-- /page content -->

			<!-- footer content -->
			<?php $this->load->view('istas/estruc/footer'); ?>
			<!-- /footer content -->
		</div>

    </div>

    <?php $this->load->view('istas/estruc/scripts'); ?>
  </body>
</html>
