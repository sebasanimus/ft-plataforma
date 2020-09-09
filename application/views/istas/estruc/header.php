<base href="<?=base_url()?>" >
<meta charset="utf-8" />
<link rel="apple-touch-icon" sizes="76x76" href="material/assets/img/apple-icon.ico">
<link rel="icon" type="image/png" href="material/assets/img/favicon.ico">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>
Fontagro Istas
</title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
<meta name="description" content="">
<meta name="author" content="ANIMUS">

<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

<link href="local/styles-iniciativas.css?4" rel="stylesheet">


	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@FONTAGROdigital">
	<meta name="twitter:title" content="Fontagro Istas">
	<meta name="twitter:description" content="">
	<meta name="twitter:creator" content="@FONTAGROdigital">
	<meta name="twitter:image" content="<?=base_url()?>material/assets/img/register.jpg">

	<!-- Open Graph data -->
	<meta property="og:title" content="Fontagro Istas" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?=base_url()?>istas" />
	<meta property="og:image" content="<?=base_url()?>material/assets/img/register.jpg" />
	<meta property="og:description" content="" />

<?php
if(isset($libs)){
	foreach($libs as $lib){
		if (file_exists(APPPATH."views/istas/headscripts/lib_{$lib}_header.php")){
			$this->load->view("istas/headscripts/lib_{$lib}_header.php");
		}
	}
}
if (isset($page) && file_exists(APPPATH."views/istas/headscripts/{$page}_header.php")){
	$this->load->view('istas/headscripts/'.$page.'_header');
}
?>


<?php $this->load->view('googletag'); ?>