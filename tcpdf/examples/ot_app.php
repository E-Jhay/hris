<?php

$filter_status = $_GET['filter_status'];
$filter_from = $_GET['filter_from'];
$filter_to = $_GET['filter_to'];
require_once '../../controller/controller.otapp.php';
$otapp = new crud();
$overtime = $otapp->getallovertime($filter_status,$filter_from,$filter_to);




require_once('tcpdf_include.php');
date_default_timezone_set('Asia/Manila');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('OVERTIME APPLICATION');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

$pdf->SetHeaderData('', '', '', '');


$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// define ('PDF_PAGE_FORMAT', 'LETTER');
$pdf->SetFont('dejavusans', '', 9);

		$fby = "Date of Transaction";

		$html = '<table cellpadding="3" width="100%">
					<tr>
						<td><p><b>Date/Time Generated:</b> <span>'.date('F d, Y ', time()).'</span> </p></td>
						
					</tr>
				  </table>
		

				  
		 <table cellpadding="1" width="100%">

		 	<br>
		 	<br>
		 	
			<tr align="center" style="font-size:10px">
				<th style="border-left-width:0px;border-right-width:1px;border-bottom-width:0px;border-top-width:0px;"><b>EMPLOYEE NAME</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>POSITION</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>REASONS</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>DATE FILED</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>FROM</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>TO</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>NO OF HOURS</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>OT DATE FROM</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>OT DATE TO</b></th>
				
			</tr>';
	
	
	
	


						$a = 0;
						$total = 0;			
						set_time_limit(30000);
						foreach ($overtime as $key => $x) {
							$a++;		
							
				

	$html .= '<tr align="center" style="font-size:10px">

							<td style="border-left-width:0px;border-right-width:1px;border-bottom-width:0px;">'.$x['firstname'].' '.$x['lastname'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['job_title'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['reasons'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['date_filed'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['ot_from'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['ot_to'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['no_of_hrs'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['ot_date'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['ot_date_to'].'</td>
																																			
						  </tr>';						  	
						  }
						  					  					  					  					  					  
							  
 $html .= '</table><br><br>
 <p><b>Total records:</b> <span>'.number_format($a).'</span> </p>';



// $pdf->AddPage('L');
// $pdf->writeHTML($html, true, false, true, false, '');
// ob_end_clean();
// $pdf->Output('summary.pdf', 'I');




$backup_name = "overtime_application.xls";
header('Content-Type: application/octet-stream');   
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
echo $html;
exit;




?>