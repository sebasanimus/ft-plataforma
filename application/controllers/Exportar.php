<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportar extends CI_Controller {

    public function __construct() {
		parent::__construct();

		$this->load->model('Propuesta');

		$this->load->model('Item');
       
		$this->load->model('Tecnica');
		$this->load->model('Fontagro');
		$this->load->model('Breve');
		$this->load->model('Pais');
	}

	public function index()	{		
		header("Location: ".base_url().'exportar/listar');
	}
	

	public function enBreve($codepais, $codlang){		
		$fontagro = $this->Fontagro->getByIdLang($codlang, 1);
		$pais = $this->Pais->getByCode($codepais, $codlang);
		$breve = $this->Breve->getByIdPais($pais['id'], $codlang);
		$ejemplos = $this->Propuesta->ejemplos($pais['id'], $codlang);
		/*echo '<pre>';
		print_r($fontagro);
		print_r($pais);
		print_r($breve);*/
		$db = $this->Propuesta->graficoTortaTotales();
		
		$valores = $this->Propuesta->totalTabla();
		/*echo '<pre>';	print_r($valores); exit;*/
		$paisesMiembro = $this->Pais->getPaisesMiembro($codlang);
		$paisesMiembroCode = '';
		foreach($paisesMiembro as $pa){
			$paisesMiembroCode .= '
					<div class="countryBox">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
							<tr>
								<td width="30px"><img src="'.base_url().'/application/controllers/assets/images/flag-'.$pa['code'].'.png" width="30px" /></td>
								<td align="left" class="countryTd">'.$pa['nombre'].'</td>
							</tr>
							</tbody>
						</table>
					</div>';
		}
		$yeardiff = date("Y") - $pais['anio_desde'];
		$valPais = $this->Propuesta->getDatosPais($pais['id']);
		$breve['contenido'] = str_replace("#consorciosLider", $valPais['consorciosLider'], $breve['contenido']);
		$breve['contenido'] = str_replace("#totalConsorciosLider", $valPais['totalConsorciosLider'], $breve['contenido']);
		$breve['contenido'] = str_replace("#miembroDesde", $pais['anio_desde'], $breve['contenido']);
		$breve['contenido'] = str_replace("#yaAportado", $valPais['yaAportado'], $breve['contenido']);
		$breve['contenido'] = str_replace("#aniosMiembro", $yeardiff, $breve['contenido']);
		$breve['contenido'] = str_replace("#consorcios", $valPais['consorcios'], $breve['contenido']);
		$breve['contenido'] = str_replace("#totalConsorcios", $valPais['totalConsorcios'], $breve['contenido']);
		$breve['contenido'] = str_replace("#aporteFontagro", $valPais['aporteFontagro'], $breve['contenido']);

		$en = ($codlang == 'es') ? 'en' : 'in';
		$filasTablaEjemplo = '';
		foreach($ejemplos as $ej){
			$filasTablaEjemplo .= '<tr>';
			$filasTablaEjemplo .= '<td class="tableAnio">'.$ej['anio'].'</td>';
			$filasTablaEjemplo .= '<td class="tableLider">'.$ej['lider'].'</td>';
			$filasTablaEjemplo .= '<td class="tableMiembros">'.$ej['miembros'].'</td>';
			$filasTablaEjemplo .= '<td class="tableTitleSimple">'.$ej['titulo_simple'].'</td>';
			$filasTablaEjemplo .= '<td class="tableTotal"> $'.number_format($ej['total'], 0).'</td>';
			$filasTablaEjemplo .= '</tr>';
		}

		$header = '
		<div class="leftHeader">
			<img src="'.base_url().'/application/controllers/assets/images/header-'.$codlang.'.png" height="60px" />
		</div>
		<div class="rightHeader">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>
					<td style="color:#AAA; font-size:20px; padding-left:-20px; font-family:gothamxlight">'.date("Y").'</td>
					<td valign="middle" style="height: 60px; vertical-align: middle; text-align: right; color: #fff; font-size: 10px;">FONTAGRO<br />'.$en.' <strong>'.$pais['nombre'].'</strong></td>					
				</tr>
				</tbody>
			</table>
			
		</div>
		';

		

		$footer = '<div align="center"><img src="'.base_url().'/application/controllers/assets/images/footer2.png" width="100%" /></div>';

		
		
		$html = '
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;">
				<tbody>
				<tr>
					<td width="50%" class="colbg">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
							<tr>
								<td style="padding-bottom: 5px;"><h2>'.$fontagro['sobreTitulo'].'</h2></td>
							</tr>
							<tr>
								<td class="coltxt" style="padding-bottom: 10px;"><p>'.$fontagro['sobre'].'</p></td>
							</tr>
							</tbody>
						</table>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
								<td style="padding-bottom: 5px;"><h2>'.$fontagro['gobernanzaTitulo'].'</h2></td>
								</tr>
								<tr>
								<td class="coltxt"><p>'.$fontagro['gobernanza'].'</p></td>
								</tr>
							</tbody>
						</table>
					</td>
					<td width="15"></td>
					<td width="50%" class="colbg">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
							<tr>
								<td style="padding-bottom: 5px;"><h2>'.$fontagro['misionTitulo'].'</h2></td>
							</tr>
							<tr>
								<td class="coltxt" style="padding-bottom: 10px;"><p>'.$fontagro['mision'].'</p></td>
							</tr>
							</tbody>
						</table>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
							<tr>
								<td style="padding-bottom: 5px;"><h2>'.$fontagro['planTitulo'].'</h2></td>
							</tr>
							<tr>
								<td class="coltxt" style="padding-bottom: 10px;"><p>'.$fontagro['plan'].'</p></td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
				</tbody>
			</table>
			<div class="colsBox">
				<div class="floatLeft col03">
					<div class="title">
						<div class="tleft">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
									<td class="titleSpace"><h3>'.$fontagro['origenTitulo'].'</h3></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<img src="'.base_url().'exportar/torta/es" style="width: 100%; margin: 0 auto; border: none;">
					<div class="labelsBox">
						<div class="labelFull">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
								<tr>
									<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/pieColor01.png" width="10px" /></td>
									<td><span class="labeltxt"><strong>'.$fontagro['aporteContrapartida'].'</strong><br/>'.number_format($db['aporte_contrapartida'],0,",",".").'</span></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="labelFull">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
								<tr>
									<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/pieColor04.png" width="10px" /></td>
									<td><span class="labeltxt"><strong>Fontagro</strong><br/>'.number_format($db['aporte_fontagro'],0,",",".").'</span></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="labelFull">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
								<tr>
									<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/pieColor03.png" width="10px" /></td>
									<td><span class="labeltxt"><strong>'.$fontagro['BID'].'</strong><br/>'.number_format($db['aporte_bid'],0,",",".").'</span></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="labelFull">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
								<tr>
									<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/pieColor02.png" width="10px" /></td>
									<td><span class="labeltxt"><strong>'.$fontagro['otrasAgencias'].'</strong><br/>'.number_format($db['otras'],0,",",".").'</span></td>
								</tr>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
				<div class="floatLeft col03">
					<div class="title tcenter">
						<div class="tleft">
							<div class="tright">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tbody>
										<tr>
										<td class="titleSpace"><h3>'.$fontagro['participacionTitulo'].'</h3></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>	
					
					<div class="labelsBox">
						<div class="label">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
								<tr>
									<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/dotColor01.png" width="10px" /></td>
									<td><span class="labeltxt">'.$fontagro['miembro'].'</span></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="label">

							<table width="100%" border="0" cellspacing="0" cellpadding="5">
							<tbody>
							<tr>
								<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/dotColor02.png" width="10px" /></td>
								<td><span class="labeltxt">'.$fontagro['lider'].'</span></td>
							</tr>
							</tbody>
						</table>
							
						</div>
					</div>
					<img src="'.base_url().'exportar/barras/'.$codlang.'" style="float:right;">
				</div>
				<div class="floatRight col03">
					<div class="title">
						<div class="tright">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
									<td class="titleSpace"><h3>'.$fontagro['enCifrasTitulo'].'</h3></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="valueBox color01">
						<table width="100%" border="0" cellspacing="0" cellpadding="10">
							<tbody>
								<tr>
									<td class="firstCol"><span style="font-family: gothamxlight">'.$valores['proyectosAprobados'].'</span></td>
									<td class="secondCol"><span>'.$fontagro['proyectosAprobados'].'</span></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="valueBox color02">
						<table width="100%" border="0" cellspacing="0" cellpadding="10">
							<tbody>
								<tr>
									<td class="firstCol"><span style="font-family: gothamxlight">'.$valores['montoTotal'].'</span><br /><span class="smallTxt">'.(($codlang == 'es') ? 'MILLONES' : 'MILLION').'</span></td>
									<td class="secondCol"><span>'.$fontagro['montoTotal'].'</span></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="valueBox color03">
						<table width="100%" border="0" cellspacing="0" cellpadding="10">
							<tbody>
								<tr>
									<td class="firstCol"><span style="font-family: gothamxlight">'.$valores['otrosTotal'].'</span><br /><span class="smallTxt">'.(($codlang == 'es') ? 'MILLONES' : 'MILLION').'</span></td>
									<td class="secondCol"><span>'.$fontagro['otrosInvercionistas'].'</span></td>
								</tr>
							</tbody>
						</table>

					</div>
					<div class="valueBox color04">
						<table width="100%" border="0" cellspacing="0" cellpadding="10">
							<tbody>
								<tr>
									<td class="firstCol"><span style="font-family: gothamxlight">'.$valores['paises'].'</span></td>
									<td class="secondCol"><span>'.$fontagro['paisesBeneficiados'].'</span></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="valueBox color05">
						<table width="100%" border="0" cellspacing="0" cellpadding="10">
							<tbody>
								<tr>
									<td class="firstCol"><span style="font-family: gothamxlight">'.$valores['tecnologias_generadas'].'</span></td>
									<td class="secondCol"><span>'.$fontagro['tecnologiasGeneradas'].'</span></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="smallBox">
						<div class="valueBoxSmall color06">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
									<tr>
										<td class="firstCol"><span style="font-family: gothamxlight">'.$valores['tecnologias_nuevas'].'</span></td>
										<td class="secondCol"><span>'.$fontagro['tecnologiasNuevas'].'</span></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="valueBoxSmall color05">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
									<tr>
										<td class="firstCol"><span style="font-family: gothamxlight">'.$valores['tecnologias_relevantes'].'</span></td>
										<td class="secondCol"><span>'.$fontagro['tecnologiasRelevantes'].'</span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
			</div>
			<div style="clear:both; width:100%"></div>
			<div class="paisesBox">
				<div class="titleBox floatLeft">
					<div class="title">
						<div class="tleft">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
									<td class="titleSpace"><h3>'.$fontagro['paisesMiembro'].'</h3></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="flagsBox floatRight">
					'.$paisesMiembroCode.'
					<div style="clear:both; width:100%"></div>
					
				</div>
			</div>
			
			<pagebreak />
			<div class="txtBoxDiv">
				<h2>FONTAGRO '.$en.' '.$pais['nombre'].'</h2>
				'.$breve['contenido'].'
				
				<h2>'.$fontagro['fortalecimiento'].'</h2>
				'.$breve['fortalecimiento'].'
			</div>
			
			<table class="examplesTable" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<th class="tableTitle" colspan="5">'.$fontagro['ejemplos'].' '.$pais['nombre'].'</th>
				</tr>
				<tr>
					<td class="tableHeader">'.$fontagro['anio'].'</th>
					<td class="tableHeader">'.$fontagro['institucionLider'].'</th>
					<td class="tableHeader" style="width:40%">'.$fontagro['miembros'].'</th>
					<td class="tableHeader">'.$fontagro['tema'].'</th>
					<td class="tableHeader">'.$fontagro['monto'].'</th>
				</tr>
				'.$filasTablaEjemplo.'
			</table>
			';

		
		require_once "application/libraries/pdf/autoload.php";

		$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];


		$mpdf = new \Mpdf\Mpdf([
			'debugfonts' => false,
			'mode' => 's',
			'margin_left' => 10,
			'margin_right' => 10,
			'margin_top' => 30,
			'margin_bottom' => 15,
			'margin_header' => 10,
			'margin_footer' => 5,
			'fontDir' => array_merge($fontDirs, [
			__DIR__ . '/assets/fonts/', 
			]),
			'fontdata' => $fontData + [
			'gotham' => [
			'R' => 'gotham-book-webfont.ttf',
			'B' => 'gotham-bold-webfont.ttf',
			],
			'gothamlight' => [
			'R' => 'gotham-light-webfont.ttf',
			],
			'gothamblack' => [
			'R' => 'gotham-black-webfont.ttf',
			],
			'gothamxlight' => [
			'R' => 'gotham-xlight-webfont.ttf',
			],
			],
			'default_font' => 'gotham'
			]);

		$stylesheet = file_get_contents(base_url().'/application/controllers/assets/style.css');
		
		$mpdf->WriteHTML($stylesheet,1);

		$mpdf->SetHTMLHeader($header);

		$mpdf->SetHTMLFooter($footer);
		$mpdf->SetHTMLFooter($footer, 'E');
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}


	public function torta($codlang){
		require_once ('application/libraries/jpgraph/jpgraph.php');
		require_once ('application/libraries/jpgraph/jpgraph_pie.php');
		
		$db = $this->Propuesta->graficoTortaTotales();

		$total = $db['aporte_fontagro']+$db['aporte_bid']+$db['aporte_contrapartida']+$db['otras'];
		$aporte_fontagro = round(100*$db['aporte_fontagro']/$total);
		$aporte_bid = round(100*$db['aporte_bid']/$total);
		$aporte_contrapartida = round(100*$db['aporte_contrapartida']/$total);
		$otras = round(100*$db['otras']/$total);

		$data = array($aporte_contrapartida, $otras, $aporte_bid, $aporte_fontagro);
		$labels = array(
			"CONTRA-\nPARTIDA\n(%.0f%%)",
			"OTRAS\nAGENCIAS\n(%.0f%%)",
            "BID\n(%.0f%%)",
			"FONTAGRO\n(%.0f%%)");
		// A new pie graph
		$graph = new PieGraph(350,300);
		$graph->clearTheme();
		$graph->SetFrame(false);
		$graph->SetImgFormat('jpeg',100);
		//$graph->SetShadow();
		$theme_class= new UniversalTheme;
		//$graph->SetTheme($theme_class);

		// Setup the pie plot
		$p1 = new PiePlot($data);

		// Setup the labels to be displayed
		$p1->SetLabels($labels);
		// This method adjust the position of the labels. This is given as fractions
		// of the radius of the Pie. A value < 1 will put the center of the label
		// inside the Pie and a value >= 1 will pout the center of the label outside the
		// Pie. By default the label is positioned at 0.5, in the middle of each slice.
		$p1->SetLabelPos(1);

		// Adjust size and position of plot
		$p1->SetSize(0.35);
		$p1->SetCenter(0.5,0.5);

		// Setup slice labels and move them into the plot
		$p1->value->SetFont(FF_ARIAL,FS_NORMAL,8);
		$p1->value->SetColor("#84888d");

		$p1->SetLabelType(PIE_VALUE_ADJPERCENTAGE);
		// Explode all slices
		$p1->ExplodeAll(2);
		$p1->SetStartAngle(90);
		$p1->ShowBorder(false, false);
		$p1->SetSliceColors(array('#84abd1','#00a7c7','#35b39b','#b9d78b','#cfd0d0'));

		// Add drop shadow
		//$p1->SetShadow();

		// Finally add the plot
		$graph->Add($p1);

		// ... and stroke it
		$graph->Stroke();
	}


	function barras($codlang, $split=0){
		require_once ('application/libraries/jpgraph/jpgraph.php');
		require_once ('application/libraries/jpgraph/jpgraph_bar.php');

		$dat = $this->Propuesta->totalPais($codlang);	
		$data=$dat['proyectosParticipante'];
		$data2=$dat['proyectosEjecutor'];
		$datax=$dat['labels'];
		if(!empty($split)){
			$data = array_chunk($dat['proyectosParticipante'], ceil(count($dat['proyectosParticipante']) / 2))[$split-1];
			$data2= array_chunk($dat['proyectosEjecutor'], ceil(count($dat['proyectosEjecutor']) / 2))[$split-1];
			$datax= array_chunk($dat['labels'], ceil(count($dat['labels']) / 2))[$split-1];
		}

		// Create the graph. 
		$largo = (empty($split))? 600 : 300;
		$graph = new Graph(400,$largo);
		
		$graph->clearTheme();	
		$graph->SetScale("textlin");
		$graph->Set90AndMargin(150,20,20,30);

		// Setup X-axis
		$graph->xaxis->SetTickLabels($datax);
		$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,10);

		// Some extra margin looks nicer
		$graph->xaxis->SetLabelMargin(10);

		// Label align for X-axis
		$graph->xaxis->SetLabelAlign('right','center');

		// Add some grace to y-axis so the bars doesn't go
		// all the way to the end of the plot area
		$graph->yaxis->scale->SetGrace(15);

		// We don't want to display Y-axis
		$graph->yaxis->Hide();
		// Turn off tickmarks
		$graph->xaxis->SetTickSize(0,0);

		$graph->SetFrame(false);

		$graph->img->SetTransparent('white');
		$graph->SetImgFormat('jpeg',100);
	

		$bar1 = new BarPlot($data);
		$bar1->SetWidth(12);
		$bar1->value->Show();
		$bar1->value->SetFont(FF_ARIAL,FS_NORMAL, 10);
		$bar1->value->SetAlign('left','center');
		$bar1->value->SetColor('#84888d','darkred');
		$bar1->value->SetFormat('%.0f');
		$bar1->SetFillColor('#50b377');
		$bar1->SetColor('#FFFFFF');
		$bar2 = new BarPlot($data2);

		$bar2->SetFillColor('#84abd1');
		$bar2->SetColor('#FFFFFF');
		$bar2->SetWidth(12);
		$bar2->value->Show();		
		$bar2->value->SetFont(FF_ARIAL,FS_NORMAL, 10);
		$bar2->value->SetAlign('left','center');
		$bar2->value->SetColor('#84888d','darkred');
		$bar2->value->SetFormat('%.0f');

		$ybplot = new GroupBarPlot(array($bar1,$bar2));
		$ybplot->SetWidth(0.8);

		// Add the plot to the graph
		$graph->Add($ybplot);
		//$graph->Add($bar2);

		// .. and send the graph back to the browser
		$graph->Stroke();

	}
	

	public function enBreveGeneral($codlang){		
		$fontagro = $this->Fontagro->getByIdLang($codlang, 1);
				
		/*echo '<pre>';
		print_r($fontagro);
		print_r($pais);
		print_r($breve);*/
		$db = $this->Propuesta->graficoTortaTotales();
		
		$valores = $this->Propuesta->totalTabla();
		/*echo '<pre>';	print_r($valores); exit;*/
		$paisesMiembro = $this->Pais->getPaisesMiembro($codlang);
		$paisesMiembroCode = '';
		$contenidoResumenes = '';
		$contenidoStats = '';
		foreach($paisesMiembro as $pa){
			$paisesMiembroCode .= '
					<div class="countryBox">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
							<tr>
								<td width="30px"><img src="'.base_url().'/application/controllers/assets/images/flag-'.$pa['code'].'.png" width="30px" /></td>
								<td align="left" class="countryTd">'.$pa['nombre'].'</td>
							</tr>
							</tbody>
						</table>
					</div>';
			
			$yeardiff = date("Y") - $pa['anio_desde'];
			$valPais = $this->Propuesta->getDatosPais($pa['id']);
			$breve = $this->Breve->getByIdPais($pa['id'], $codlang);
			$breve['contenido'] = str_replace("#consorciosLider", $valPais['consorciosLider'], $breve['contenido']);
			$breve['contenido'] = str_replace("#totalConsorciosLider", $valPais['totalConsorciosLider'], $breve['contenido']);
			$breve['contenido'] = str_replace("#miembroDesde", $pa['anio_desde'], $breve['contenido']);
			$breve['contenido'] = str_replace("#yaAportado", $valPais['yaAportado'], $breve['contenido']);
			$breve['contenido'] = str_replace("#aniosMiembro", $yeardiff, $breve['contenido']);
			$breve['contenido'] = str_replace("#consorcios", $valPais['consorcios'], $breve['contenido']);
			$breve['contenido'] = str_replace("#totalConsorcios", $valPais['totalConsorcios'], $breve['contenido']);
			$breve['contenido'] = str_replace("#aporteFontagro", $valPais['aporteFontagro'], $breve['contenido']);
			$start = strpos($breve['contenido'], '<p>');
			$end = strpos($breve['contenido'], '</p>', $start);
			$paragraph = substr($breve['contenido'], $start, $end-$start+4);
			$paragraph = html_entity_decode(strip_tags($paragraph));
			$paragraph = substr($paragraph, 0, strrpos( $paragraph, '.')+1);
			$contenidoResumenes .= '
				<tr class="resumenTr">
					<td width="60px"><img src="'.base_url().'/application/controllers/assets/images/flag-'.$pa['code'].'.png" width="60px" class="imgResumen" /></td>
					<td class="resumenTd">'.$paragraph.'</td>
				</tr>
			';

			$stats = $this->Pais->getPaisStat($pa['id']);
			$contenidoStats .= '
				<tr>
					<td class="nameTd">'.$pa['nombre'].'</td>
					<td class="contrTd">'.number_format($pa['contribucion_fija']/1000000, 2 , "." , "," ) .'</td>
					<td class="partTd">'.number_format($stats['participacion']/1000000, 2 , "." , "," ).'</td>
				</tr>
			';
		}
	

		$en = ($codlang == 'es') ? 'en' : 'in';
		

		$header = '
		<div class="leftHeader">
			<img src="'.base_url().'/application/controllers/assets/images/header-'.$codlang.'.png" height="60px" />
		</div>
		<div class="rightHeader">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>
					<td style="color:#AAA; font-size:20px; padding-left:-20px; font-family:gothamxlight">'.date("Y").'</td>
					<td valign="middle" style="height: 60px; vertical-align: middle; text-align: right; color: #fff; font-size: 10px;">FONTAGRO</td>					
				</tr>
				</tbody>
			</table>
			
		</div>
		';

		

		$footer = '<div align="center"><img src="'.base_url().'/application/controllers/assets/images/footer2.png" width="100%" /></div>';

		
		
		$html = '			
			<div class="colsBox">				
				<div class="floatLeft col02">
					<div class="title tcenter">
						<div class="tleft">
							<div class="tright">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tbody>
										<tr>
										<td class="titleSpace"><h3>'.$fontagro['participacionTitulo'].'</h3></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>	
					
					<div class="labelsBox">
						<div class="label">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
								<tr>
									<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/dotColor01.png" width="10px" /></td>
									<td><span class="labeltxt">'.$fontagro['miembro'].'</span></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="label">

							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
								<tr>
									<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/dotColor02.png" width="10px" /></td>
									<td><span class="labeltxt">'.$fontagro['lider'].'</span></td>
								</tr>
								</tbody>
							</table>
							
						</div>
					</div>
					<img src="'.base_url().'exportar/barras/'.$codlang.'/1" style="float:right;">
				</div>
				<div class="floatLeft col02">
					<div class="title empty tcenter">
						
					</div>	
					
					<div class="labelsBox">
						<div class="label">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<tbody>
								<tr>
									<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/dotColor01.png" width="10px" /></td>
									<td><span class="labeltxt">'.$fontagro['miembro'].'</span></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="label">

							<table width="100%" border="0" cellspacing="0" cellpadding="5">
							<tbody>
							<tr>
								<td width="10px"><img src="'.base_url().'/application/controllers/assets/images/dotColor02.png" width="10px" /></td>
								<td><span class="labeltxt">'.$fontagro['lider'].'</span></td>
							</tr>
							</tbody>
						</table>
							
						</div>
					</div>
					<img src="'.base_url().'exportar/barras/'.$codlang.'/2" style="float:right;">
				</div>
			</div>
			<div style="clear:both; width:100%"></div>
			<div class="paisesBox">
				<div class="titleBox floatLeft">
					<div class="title">
						<div class="tleft">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
									<td class="titleSpace"><h3>'.$fontagro['paisesMiembro'].'</h3></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="flagsBox floatRight">
					'.$paisesMiembroCode.'
					<div style="clear:both; width:100%"></div>
					
				</div>
			</div>

			<table width="100%" border="0" cellspacing="5" cellpadding="0" class="tableResumen">
				<tbody>
				'.$contenidoResumenes.'
				</tbody>
			</table>

			<pagebreak />
			<table class="examplesTable" width="100%" border="0" cellspacing="0" cellpadding="0">				
				<thead>
					<tr>
						<th class="tableHeader">'.$fontagro['paises'].'</td>
						<th class="tableHeader">'.$fontagro['contribucion'].'</td>
						<th class="tableHeader">'.$fontagro['participacion'].'</td>
					</tr>
				</thead>
				<tbody>
				'.$contenidoStats.'
				</tbody>
			</table>
			
			';

		
		require_once "application/libraries/pdf/autoload.php";

		$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];


		$mpdf = new \Mpdf\Mpdf([
			'debugfonts' => false,
			'mode' => 's',
			'margin_left' => 10,
			'margin_right' => 10,
			'margin_top' => 30,
			'margin_bottom' => 20,
			'margin_header' => 10,
			'margin_footer' => 5,
			'fontDir' => array_merge($fontDirs, [
			__DIR__ . '/assets/fonts/', 
			]),
			'fontdata' => $fontData + [
			'gotham' => [
			'R' => 'gotham-book-webfont.ttf',
			'B' => 'gotham-bold-webfont.ttf',
			],
			'gothamlight' => [
			'R' => 'gotham-light-webfont.ttf',
			],
			'gothamblack' => [
			'R' => 'gotham-black-webfont.ttf',
			],
			'gothamxlight' => [
			'R' => 'gotham-xlight-webfont.ttf',
			],
			],
			'default_font' => 'gotham'
			]);

		$stylesheet = file_get_contents(base_url().'/application/controllers/assets/style.css');
		
		$mpdf->WriteHTML($stylesheet,1);

		$mpdf->SetHTMLHeader($header);

		$mpdf->SetHTMLFooter($footer);
		$mpdf->SetHTMLFooter($footer, 'E');
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}
}
?>
