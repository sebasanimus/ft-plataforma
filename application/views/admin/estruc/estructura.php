<!DOCTYPE html>
<html lang="es">
  <head>
    <?php $this->load->view('admin/estruc/header'); ?>
  </head>

  <body class="">
    <div class="wrapper">
        <?php $this->load->view('admin/estruc/menu'); ?>
		<div class="main-panel">
			<!-- top navigation -->
			<?php $this->load->view('admin/estruc/top_nav'); ?>
			<!-- /top navigation -->

			<!-- page content -->
			<?php $this->load->view('admin/'.$page); ?>
			<!-- /page content -->

			<!-- footer content -->
			<?php $this->load->view('admin/estruc/footer'); ?>
			<!-- /footer content -->
		</div>

    </div>

    <?php $this->load->view('admin/estruc/scripts'); ?>
  </body>
</html>
