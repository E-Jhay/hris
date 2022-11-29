<?php

$type = $_GET['type'];
$from = $_GET['from'];
$to  = $_GET['to'];

require_once '../../controller/controller.employee.php';
$employees = new crud();
$employee_list = $employees->getemployee($type,$from,$to);

require_once('tcpdf_include.php');
date_default_timezone_set('Asia/Manila');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('EMPLOYEE LIST');
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

	$html = '<table align="center" width="100%">
			
			<tr>
				<td style="width:100%"><h4><b>EMPLOYEE LIST</h4></b></td>
			</tr>
		</table>			
		
			<br><br><br>';

		$fby = "Date of Transaction";

		$html .= '<table cellpadding="3" width="100%">
					<tr>
						<td><p><b>Date/Time Generated:</b> <span>'.date('F d, Y ', time()).'</span> </p></td>
						
					</tr>
				  </table>
		

				  
		 <table cellpadding="1" width="100%">

		 	<br>
		 	<br>
		 	
			<tr align="center" style="font-size:10px">
				<th style="border-left-width:0px;border-right-width:1px;border-bottom-width:0px;border-top-width:0px;"><b>EMPLOYEE NO</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>LAST NAME</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>FIRST NAME</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>MIDDLE NAME</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>DATE OF BIRTH</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>AGE</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>GENDER</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>JOB TITLE</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>JOB CATEGORY</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>EMPLOYMENT STATUS</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>DEPARTMENT</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>COMPANY</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>DATE HIRED</b></th>
				
			
			</tr>';
	
	
	
	
	
						$a = 0;
						$total = 0;			
						set_time_limit(30000);
						foreach ($employee_list as $key => $x) {
							$a++;			  
							

	$html .= '<tr align="center" style="font-size:10px">

							<td style="border-left-width:0px;border-right-width:1px;border-bottom-width:0px;">'.$x['employeeno'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['lastname'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['firstname'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['middlename'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['dateofbirth'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['age'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['gender'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['job_title'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['job_category'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['employment_status'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['department'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['company'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['date_hired'].'</td>
							
							
																																			
				</tr>';						  	
						  }
						  					  					  					  					  					  
							  
 $html .= '</table><br><br>
 <p><b>Total records:</b> <span>'.number_format($a).'</span> </p>';



// $pdf->AddPage('L');
// $pdf->writeHTML($html, true, false, true, false, '');
// ob_end_clean();
// $pdf->Output('summary.pdf', 'I');




$backup_name = "employeelist.xls";
header('Content-Type: application/octet-stream');   
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
echo $html;
exit;




?>