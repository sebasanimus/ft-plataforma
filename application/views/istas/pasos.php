<div class="content">
	<form action="admin/istas/testSaving" method="POST" id="formPpal" enctype="multipart/form-data">
		<input type="hidden" name="idista" value="<?=$ista['idista']?>" />
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="stepsLineBox pb-4">
						<div class="stepsLine">
							<div class="stepBox step1">
								<span class="number">01</span>
								<span class="stepTxt"><?=$textos['ista_paso_1']?></span>
							</div>
							<div class="stepBox step2">
								<span class="number">02</span>
								<span class="stepTxt"><?=$textos['ista_paso_2']?></span>
							</div>
							<div class="stepBox step3">
								<span class="number">03</span>
								<span class="stepTxt"><?=$textos['ista_paso_3']?></span>
							</div>
							<div class="stepBox step4">
								<span class="number">04</span>
								<span class="stepTxt"><?=$textos['ista_paso_4']?></span>
							</div>
							<div class="stepBox step5">
								<span class="number">05</span>
								<span class="stepTxt"><?=$textos['ista_paso_5']?></span>
							</div>
							<div class="stepBox step6">
								<span class="number">06</span>
								<span class="stepTxt"><?=$textos['ista_paso_6']?></span>
							</div>
						</div>
					</div>					
				</div>
			</div><!-- row -->
		
			<? $this->load->view('istas/paso0'); ?>
			<? $this->load->view('istas/paso1'); ?>
			<? $this->load->view('istas/paso2'); ?>
			<? $this->load->view('istas/paso3'); ?>
			<? $this->load->view('istas/paso4'); ?>
			<? $this->load->view('istas/paso5'); ?>
			<? $this->load->view('istas/paso6'); ?>
			<? $this->load->view('istas/paso7'); ?>

			<div class="container-fluid text-right">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-6 text-left">
							<button type="button" id="anterior" class="btn btn-light"><?=$textos['ista_anterior']?></button>
						</div>
						<div class="col-sm-6 text-right">
							<button type="button" id="guardar" class="btn btn-primary"><?=$textos['ista_guardar']?></button>
							<button type="button" id="siguiente" class="btn btn-dark"><?=$textos['ista_siguiente']?></button>
						</div>
					</div>					
				</div>
          	</div>

		</div><!-- container-fluid -->
	</form>
</div><!-- content -->
