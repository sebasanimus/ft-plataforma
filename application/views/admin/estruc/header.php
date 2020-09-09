<base href="<?=base_url()?>" >
<meta charset="utf-8" />
<link rel="apple-touch-icon" sizes="76x76" href="material/assets/img/apple-icon.ico">
<link rel="icon" type="image/png" href="material/assets/img/favicon.ico">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>
Fontagro Admin
</title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />


<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<!-- CSS Files -->
<link href="material/assets/css/material-dashboard.minf066.css?v=2.1.0" rel="stylesheet" />

<?php
if(isset($libs)){
	foreach($libs as $lib){
		if (file_exists(APPPATH."views/admin/headscripts/lib_{$lib}_header.php")){
			//echo APPPATH."views/admin/headscripts/lib_{$lib}_header.php"; exit;
			$this->load->view("admin/headscripts/lib_{$lib}_header.php");
		}
	}
}
if (isset($page) && file_exists(APPPATH."views/admin/headscripts/{$page}_header.php")){
	$this->load->view('admin/headscripts/'.$page.'_header');
}
?>

<!-- CSS Just for demo purpose, don't include it in your project -->
<link href="material/assets/demo/demo.css" rel="stylesheet" />

<link href="local/estilos.css?8" rel="stylesheet">