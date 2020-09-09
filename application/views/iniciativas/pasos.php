<div class="content">
	<form action="iniciativas/perfiles/testSaving" method="POST" id="formPpal" enctype="multipart/form-data">
		<input type="hidden" name="idperfil" value="<?=$perfil['idperfil']?>" />
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="stepsLineBox pb-4">
						<div class="stepsLine">
							<div class="stepBox step1">
								<span class="number">01</span>
								<span class="stepTxt"><?=$textos['paso_1']?></span>
							</div>
							<div class="stepBox step2">
								<span class="number">02</span>
								<span class="stepTxt"><?=$textos['paso_2']?></span>
							</div>
							<div class="stepBox step3">
								<span class="number">03</span>
								<span class="stepTxt"><?=$textos['paso_3']?></span>
							</div>
							<div class="stepBox step4">
								<span class="number">04</span>
								<span class="stepTxt"><?=$textos['paso_4']?></span>
							</div>
							<div class="stepBox step5">
								<span class="number">05</span>
								<span class="stepTxt"><?=$textos['paso_5']?></span>
							</div>
							<div class="stepBox step6">
								<span class="number">06</span>
								<span class="stepTxt"><?=$textos['paso_6']?></span>
							</div>
							<div class="stepBox step7">
								<span class="number">07</span>
								<span class="stepTxt"><?=$textos['paso_7']?></span>
							</div>
							<div class="stepBox step8">
								<span class="number">08</span>
								<span class="stepTxt"><?=$textos['paso_8']?></span>
							</div>
							<div class="stepBox step9">
								<span class="number">09</span>
								<span class="stepTxt"><?=$textos['paso_9']?></span>
							</div>
						</div>
					</div>
					
				</div>
			</div><!-- row -->
		
			<? $this->load->view('iniciativas/paso0'); ?>
			<? $this->load->view('iniciativas/paso1'); ?>
			<? $this->load->view('iniciativas/paso2'); ?>
			<? $this->load->view('iniciativas/paso3'); ?>
			<? $this->load->view('iniciativas/paso4'); ?>
			<? $this->load->view('iniciativas/paso5'); ?>
			<? $this->load->view('iniciativas/paso6'); ?>
			<? $this->load->view('iniciativas/paso7'); ?>
			<? $this->load->view('iniciativas/paso8'); ?>
			<? $this->load->view('iniciativas/paso9'); ?>
			<? $this->load->view('iniciativas/paso10'); ?>

			<div class="container-fluid text-right">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-6 text-left">
							<button type="button" id="anterior" class="btn btn-light"><?=$textos['anterior']?></button>
						</div>
						<div class="col-sm-6 text-right">
							<button type="button" id="guardar" class="btn btn-primary"><?=$textos['guardar']?></button>
							<button type="button" id="siguiente" class="btn btn-dark"><?=$textos['siguiente']?></button>
						</div>
					</div>					
				</div>
          	</div>

		</div><!-- container-fluid -->
	</form>
</div><!-- content -->
