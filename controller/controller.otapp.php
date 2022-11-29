<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function approveot(){

      $ot_id = $_POST['ot_id'];
      $ot_remarks = $_POST['ot_remarks'];
      $statuss = $_POST['statuss'];
      $employeeno = $_POST['employeeno'];

      $conn=$this->connect_mysql();
      $sql2 = $conn->prepare("UPDATE tbl_overtime SET statuss='$statuss',approved_by='$employeeno',remarks='$ot_remarks' WHERE id='$ot_id'");
      $sql2->execute();

      $qqy = $conn->prepare("SELECT employeeno FROM tbl_overtime WHERE id='$ot_id'");
      $qqy->execute();
      $rowq = $qqy->fetch();
      $emp_no = $rowq['employeeno'];

      $sqry = $conn->prepare("SELECT id,firstname,lastname,department FROM tbl_employee WHERE employeeno='$emp_no'");
      $sqry->execute();
      $srow = $sqry->fetch();
      $employee_id = $srow['id'];
      $firstname = $srow['firstname'];
      $lastname = utf8_decode($srow['lastname']);
      $department = $srow['department'];

      $sqry2 = $conn->prepare("SELECT corp_email FROM contactinfo WHERE emp_id='$employee_id'");
      $sqry2->execute();
      $srow2 = $sqry2->fetch();
      $corp_email = $srow2['corp_email'];

            // require 'Exception.php';
            // require 'PHPMailer.php';
            // require 'SMTP.php';
            // require 'PHPMailerAutoload.php';

            // $mail = new PHPMailer();
            // $mail->IsSMTP();
            // $mail->SMTPDebug = 0;
            // $mail->SMTPAuth = true;
            // $mail->Host = "mail.panamed.com.ph";
            // $mail->IsHTML(true);
            // $mail->Username = "no-reply@panamed.com.ph";
            // $mail->Password = "Unimex123!";
            // $mail->SetFrom("no-reply@panamed.com.ph", "");
            // $mail->Subject = "Overtime Application Status";
            // $msg = 'Your filed overtime was '.$statuss.' by HR Assistant - Payroll<br><br>Remarks: '.$ot_remarks;
            // $mail->Body = $msg;

            // $mail->isHTML(true);
            // $mail->AddAddress($corp_email);
            // if(!$mail->Send()) {
            //     echo "Mailer Error: " . $mail->ErrorInfo;
            // } else {

            // }

  }

  function loadallot(){
    $filter_status = $_GET['filter_status'];
    $conn = $this->connect_mysql();
    if($filter_status=="All"){
      $query = $conn->prepare("SELECT a.*,b.firstname,b.lastname,b.job_title FROM tbl_overtime a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                             ORDER BY a.id DESC");
    }else{
      $query = $conn->prepare("SELECT a.*,b.firstname,b.lastname,b.job_title FROM tbl_overtime a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                             WHERE a.statuss='$filter_status';
                             ORDER BY a.id DESC");
    }
    
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }
          
          $data = array();
                  
          $data['action'] = '<center>
          <button title="View" onclick="open_ot('.$x['id'].',\''.$x['firstname'].'\',\''.$x['lastname'].'\',\''.$x['job_title'].'\',\''.$x['reasons'].'\',\''.$x['date_filed'].'\',\''.$x['ot_from'].'\',\''.$x['ot_to'].'\',\''.$x['no_of_hrs'].'\',\''.$x['ot_date'].'\',\''.$x['statuss'].'\',\''.$x['remarks'].'\')" class="btn btn-sm btn-success"><i class="fas fa-eye fa-eye"></i></button>
          
          </center>
          ';
          $data['employeeno'] = utf8_decode($x['firstname'].' '.$x['lastname']);
          $data['position'] = $x['job_title'];
          $data['reasons'] = $x['reasons'];
          $data['date_filed'] = $x['date_filed'];
          $data['ot_from'] = $x['ot_from'];
          $data['ot_to'] = $x['ot_to'];
          $data['no_of_hrs'] = $x['no_of_hrs'];
          $data['ot_date'] = $x['ot_date'];
          $data['ot_date_to'] = $x['ot_date_to'];
          $data['status'] = $x['statuss'];


        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function loadallot2(){
    $filter_status = $_GET['filter_status'];
    $filter_from = $_GET['filter_from'];
    $filter_to = $_GET['filter_to'];
    $conn = $this->connect_mysql();
    if($filter_status=="All"){
      $query = $conn->prepare("SELECT a.*,b.firstname,b.lastname,b.job_title FROM tbl_overtime a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                             ORDER BY a.id DESC");
    }else{
      $query = $conn->prepare("SELECT a.*,b.firstname,b.lastname,b.job_title FROM tbl_overtime a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                             WHERE a.statuss='$filter_status' AND a.ot_date BETWEEN '$filter_from' AND '$filter_to';
                             ORDER BY a.id DESC");
    }
    
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }
          
          $data = array();
                  
          $data['action'] = '<center>
          <button onclick="open_ot('.$x['id'].',\''.$x['firstname'].'\',\''.$x['lastname'].'\',\''.$x['job_title'].'\',\''.$x['reasons'].'\',\''.$x['date_filed'].'\',\''.$x['ot_from'].'\',\''.$x['ot_to'].'\',\''.$x['no_of_hrs'].'\',\''.$x['ot_date'].'\',\''.$x['statuss'].'\',\''.$x['remarks'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i> View</button>
          
          </center>
          ';
          $data['employeeno'] = utf8_decode($x['firstname'].' '.$x['lastname']);
          $data['position'] = $x['job_title'];
          $data['reasons'] = $x['reasons'];
          $data['date_filed'] = $x['date_filed'];
          $data['ot_from'] = $x['ot_from'];
          $data['ot_to'] = $x['ot_to'];
          $data['no_of_hrs'] = $x['no_of_hrs'];
          $data['ot_date'] = $x['ot_date'];
          $data['ot_date_to'] = $x['ot_date_to'];
          $data['status'] = $x['statuss'];


        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function readleave(){

      $employeeno = $_POST['employeeno'];

      $conn = $this->connect_mysql();
      $query = $conn->prepare("UPDATE leave_application SET readd='read' WHERE employeeno='$employeeno'");
      $query->execute();

  }

  function readpayslip(){

      $employeeno = $_POST['employeeno'];

      $conn = $this->connect_mysql();
      $query = $conn->prepare("UPDATE payslips SET stat='read' WHERE employeeno='$employeeno'");
      $query->execute();

  }

  function count_leaveapp(){

    $employeenoo = $_POST['employeenoo'];
    $conn = $this->connect_mysql();

    $sq = $conn->prepare("SELECT department FROM tbl_employee WHERE employeeno='$employeenoo'");
    $sq->execute();
    $rw = $sq->fetch();

    $dept = $rw['department'];

    $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.status='Pending' ORDER BY a.id DESC");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function count_otapp(){

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM tbl_overtime WHERE statuss='Pending' ORDER BY id DESC");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function count_payslip(){

    $employeenoo = $_POST['employeenoo'];
    $conn = $this->connect_mysql();

    $query = $conn->prepare("SELECT * FROM payslips WHERE employeeno='$employeenoo' AND stat='posted'");
    $query->execute();
    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function count_reimbursement(){

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM tbl_reimbursement WHERE statuss='Pending'");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  public function getallovertime($filter_status,$filter_from,$filter_to)
  {
      $conn = $this->connect_mysql();
      if($filter_status=="All"){
        $query = $conn->prepare("SELECT a.*,b.firstname,b.lastname,b.job_title FROM tbl_overtime a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                               ORDER BY a.id DESC");
      }else{
        $query = $conn->prepare("SELECT a.*,b.firstname,b.lastname,b.job_title FROM tbl_overtime a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                               WHERE a.statuss='$filter_status' AND a.ot_date BETWEEN '$filter_from' AND '$filter_to';
                               ORDER BY a.id DESC");
      }
      $query->execute();
      $row = $query->fetchAll();
      return $row;
  }



}

$x = new crud();

if(isset($_GET['approveot'])){
  $x->approveot();
}

if(isset($_GET['loadallot'])){
  $x->loadallot();
}

if(isset($_GET['loadallot2'])){
  $x->loadallot2();
}

if(isset($_GET['readleave'])){
  $x->readleave();
}

if(isset($_GET['readpayslip'])){
  $x->readpayslip();
}

if(isset($_GET['count_leaveapp'])){
  $x->count_leaveapp();
}

if(isset($_GET['count_otapp'])){
  $x->count_otapp();
}

if(isset($_GET['count_payslip'])){
  $x->count_payslip();
}

if(isset($_GET['count_reimbursement'])){
  $x->count_reimbursement();
}

 ?>
