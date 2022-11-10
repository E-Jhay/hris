<?php
$filter_type = $_GET['filter_type'];
$filter_from = $_GET['filter_from'];
$filter_to = $_GET['filter_to'];
require_once '../../controller/controller.leave_app.php';
$leave_app = new crud();
$leave_application = $leave_app->getLeaveapplication($filter_type,$filter_from,$filter_to);

require_once('tcpdf_include.php');
date_default_timezone_set('Asia/Manila');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('LEAVE APPLICATION');
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
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>DATE FROM</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>DATE TO</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>LEAVE TYPE</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>LEAVE BALANCE</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>CREDITS TO DEDUCT</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>STATUS</b></th>
				
			</tr>';
	
	
	
	

						$a = 0;
						$total = 0;			
						set_time_limit(30000);
						foreach ($leave_application as $key => $x) {
							$a++;		
							

							$employeeno = $x['employeeno'];
					        $leave_type = $x['leave_type'];
					        $balanse = $leave_app->getbalance($leave_type,$employeeno);
					        
					        

							$dateffrom = $x['date_from'];
							$apptype = $x['application_type'];
					        if($apptype=="Whole Day"){
					          $dateffrom = $x['dateto'];
					        }

					        if($x['pay_leave']=="Without Pay"){
					          $x['no_days'] = 0;
					        }else if($x['status']=="Disapproved"){
					          $x['no_days'] = 0;
					        }else{
					          $x['no_days'] = $x['no_days'];
					        }

	$html .= '<tr align="center" style="font-size:10px">

							<td style="border-left-width:0px;border-right-width:1px;border-bottom-width:0px;">'.$x['firstname'].' '.$x['lastname'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['date_from'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$dateffrom.'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['leave_type'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$balanse.'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['no_days'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['status'].'</td>
																																			
						  </tr>';						  	
						  }
						  					  					  					  					  					  
							  
 $html .= '</table><br><br>
 <p><b>Total records:</b> <span>'.number_format($a).'</span> </p>';



// $pdf->AddPage('L');
// $pdf->writeHTML($html, true, false, true, false, '');
// ob_end_clean();
// $pdf->Output('summary.pdf', 'I');




$backup_name = "leave_application.xls";
header('Content-Type: application/octet-stream');   
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
echo $html;
exit;




?>