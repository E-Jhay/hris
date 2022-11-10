<?php
require_once '../../controller/controller.leavebalance.php';
$leavebalance = new crud();
$balances = $leavebalance->getleavebal();
require_once('tcpdf_include.php');
date_default_timezone_set('Asia/Manila');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('LEAVE BALANCE');
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
						<td><p><b>Date / Time Generated:</b> <span>'.date('F d, Y ', time()).'</span> </p></td>
						
					</tr>
				  </table>
		

				  
		 <table cellpadding="1" width="100%">

		 	<br>
		 	<br>
		 	
			<tr align="center" style="font-size:10px">
				<th style="border-left-width:0px;border-right-width:1px;border-bottom-width:0px;border-top-width:0px;"><b>EMPLOYEE NO</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>NAME</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>DATE HIRED</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>SL Balance</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>VL Balance</b></th>
				
			</tr>';
	
	
	
	

						$a = 0;
						$total = 0;			
						set_time_limit(30000);
						foreach ($balances as $key => $x) {
							$a++;		

						$employeeno = $x['employeeno'];

						$slbal = $leavebalance->getSLbal($employeeno); 
						$vlbal = $leavebalance->getVLbal($employeeno); 

	$html .= '<tr align="center" style="font-size:10px">

							<td style="border-left-width:0px;border-right-width:1px;border-bottom-width:0px;">'.$x['employeeno'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['lastname'].', '.$x['firstname'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.date('F d, Y', strtotime($x['date_hired'])).'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$slbal.'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$vlbal.'</td>
																																			
						  </tr>';						  	
						  }
						  					  					  					  					  					  
							  
 $html .= '</table><br><br>
 <p><b>Total records:</b> <span>'.number_format($a).'</span> </p>';



// $pdf->AddPage('L');
// $pdf->writeHTML($html, true, false, true, false, '');
// ob_end_clean();
// $pdf->Output('summary.pdf', 'I');




$backup_name = "leave_balance.xls";
header('Content-Type: application/octet-stream');   
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
echo $html;
exit;




?>