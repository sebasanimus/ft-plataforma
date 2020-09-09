<base href="<?=base_url()?>" >
<meta charset="utf-8" />
<link rel="apple-touch-icon" sizes="76x76" href="material/assets/img/apple-icon.ico">
<link rel="icon" type="image/png" href="material/assets/img/favicon.ico">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>
Fontagro Iniciativas
</title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
<meta name="description" content="<?=strip_tags($textos['convocatorias_descripcion'])?>">
<meta name="author" content="ANIMUS">

<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

<link href="local/styles-iniciativas.css?4" rel="stylesheet">


	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@FONTAGROdigital">
	<meta name="twitter:title" content="Fontagro Iniciativas">
	<meta name="twitter:description" content="<?=strip_tags($textos['convocatorias_descripcion'])?>">
	<meta name="twitter:creator" content="@FONTAGROdigital">
	<meta name="twitter:image" content="<?=base_url()?>material/assets/img/register.jpg">

	<!-- Open Graph data -->
	<meta property="og:title" content="Fontagro Iniciativas" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?=base_url()?>iniciativas" />
	<meta property="og:image" content="<?=base_url()?>material/assets/img/register.jpg" />
	<meta property="og:description" content="<?=strip_tags($textos['convocatorias_descripcion'])?>" />

<?php
if(isset($libs)){
	foreach($libs as $lib){
		if (file_exists(APPPATH."views/iniciativas/headscripts/lib_{$lib}_header.php")){
			//echo APPPATH."views/iniciativas/headscripts/lib_{$lib}_header.php"; exit;
			$this->load->view("iniciativas/headscripts/lib_{$lib}_header.php");
		}
	}
}
if (isset($page) && file_exists(APPPATH."views/iniciativas/headscripts/{$page}_header.php")){
	$this->load->view('iniciativas/headscripts/'.$page.'_header');
}
?>


<?php $this->load->view('googletag'); ?>