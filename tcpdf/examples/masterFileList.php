<?php

require_once '../../controller/controller.employee.php';
$employees = new crud();
$employee_list = $employees->exportEmployeeMasterFile();

require_once('tcpdf_include.php');
date_default_timezone_set('Asia/Manila');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('EMPLOYEE MASTER LIST');
$pdf->SetSubject('');
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


		$html = '
		

				  
		 <table cellpadding="1" width="100%">

		 	<br>
		 	<br>
		 	
			<tr align="center" style="font-size:10px">
				<th style="border-left-width:0px;border-right-width:1px;border-bottom-width:0px;border-top-width:0px;"><b>Employee No</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Employee ID</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Lastname</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Firstname</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Middlename</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Status</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Employment Status</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Company</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Job Title</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Job Category</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Department</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Street</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Municipality</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Province</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Contact No</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Personal Email</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Nationality</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Date Hired</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Regularization</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>TIN</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>SSS</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Philhealth</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>HDMF</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>ATM</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Bank</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>AUB Card No</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Date of Birth</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Nickname</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Gender</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Marital Status</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Birth Place</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Blood Type</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Height</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Weight</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Contact Person</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Contact Address</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Phone No</b></th>
				<th style="border-right-width:1px;border-bottom-width:0px;border-top-width:0px;" ><b>Relation</b></th>
			</tr>';
	
	
	
	
	
						$a = 0;
						$total = 0;			
						set_time_limit(30000);
						foreach ($employee_list as $key => $x) {
							$a++;			  
							

	$html .= '<tr align="center" style="font-size:10px">

							<td style="border-left-width:0px;border-right-width:1px;border-bottom-width:0px;">'.$x['employeeno'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['id_number'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['lastname'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['firstname'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['middlename'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['statuss'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['employment_status'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['company'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['job_title'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['job_category'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['department'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['street'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['municipality'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['province'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['contactno'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['personal_email'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['nationality'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['date_hired'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['regularized'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['tin_no'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['sss_no'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['phic_no'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['hdmf_no'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['atm_no'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['bank_name'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['aub_no'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['dateofbirth'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['nickname'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['gender'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['marital_status'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['birth_place'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['blood_type'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['height'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['weight'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['contact_name'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['contact_address'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['contact_celno'].'</td>
							<td style="border-right-width:1px;border-bottom-width:0px;">'.$x['contact_relation'].'</td>
							
							
																																			
				</tr>';						  	
						  }
						  					  					  					  					  					  
							  
 $html .= '</table><br><br>
 <p><b>Total records:</b> <span>'.number_format($a).'</span> </p>';



// $pdf->AddPage('L');
// $pdf->writeHTML($html, true, false, true, false, '');
// ob_end_clean();
// $pdf->Output('summary.pdf', 'I');




$backup_name = 'Employee Master List-'.date('Y-m-d').'.xls';
header('Content-Type: application/octet-stream');   
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
echo $html;
exit;




?>