<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function apply_overtime(){
    $employeeno = $_POST['employeeno'];
    $reasons = $_POST['reasons'];
    $date_filed = $_POST['date_filed'];
    $ot_from = $_POST['ot_from'];
    $ot_to = $_POST['ot_to'];
    $no_of_hrs = $_POST['no_of_hrs'];
    $ot_date = $_POST['ot_date'];

    if(!empty($_FILES["overtimeForm"]["name"])) {

      $target_dir = "../static/overtime_form/".$employeeno.'/';
      $file = $_FILES['overtimeForm']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['overtimeForm']['tmp_name'];
      $today = date("Y-m-d-His");
      $name = explode(".", $file);
      $overtimeForm = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir;
      if(!is_dir($path_filename_ext)){
        mkdir($path_filename_ext, 0755);
      }

      $path_filename_ext .= $overtimeForm;
    
      if(move_uploaded_file($temp_name,$path_filename_ext)) {
    
        $conn = $this->connect_mysql();
        $query = $conn->prepare("INSERT INTO tbl_overtime SET employeeno='$employeeno', reasons='$reasons', date_filed='$date_filed', ot_from='$ot_from', ot_to='$ot_to', no_of_hrs='$no_of_hrs', ot_date='$ot_date', statuss='Pending', approved_by='', file_name = '$overtimeForm', remarks=''");
        $query->execute();
    
    
        $qry2 = $conn->prepare("SELECT id,department,firstname,lastname FROM tbl_employee WHERE employeeno='$employeeno'");
        $qry2->execute();
        $row = $qry2->fetch();
    
        $department = $row['department'];
        $firstname = $row['firstname'];
        $lastname = utf8_decode($row['lastname']);
        // $id = $row['id'];
    
        $qry3 = $conn->prepare("SELECT dept_head_email FROM contactinfo WHERE employeeno='$employeeno'");
        $qry3->execute();
        $row2 = $qry3->fetch();
    
    
          require 'Exception.php';
          require 'PHPMailer.php';
          require 'SMTP.php';
          require 'PHPMailerAutoload.php';
    
          // $mail = new PHPMailer();
          // $mail->IsSMTP();
          // $mail->SMTPDebug = 0;
          // $mail->SMTPAuth = true;
          // $mail->Host = "mail.panamed.com.ph";
          // $mail->IsHTML(true);
          // $mail->Username = "no-reply@panamed.com.ph";
          // $mail->Password = "Unimex123!";
          // $mail->SetFrom("no-reply@panamed.com.ph", "");
          // $mail->Subject = "Overtime Application";
          // $msg = $firstname." ".$lastname." applied Overtime From: ".$ot_date." (".$ot_from.") To: ".$ot_date_to." (".$ot_to.")\n\nReason: ".$reasons;
          // $mail->Body = $msg;
          // $dept_head_email = $row2['dept_head_email'];
          // $mail->AddAddress($dept_head_email);
          // if(!$mail->Send()) {
          //     echo "Mailer Error: " . $mail->ErrorInfo;
          // } else {
          //     echo "success";
          // }
    
          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->SMTPDebug = 0;
          $mail->SMTPAuth = true;
          $mail->Host = "smtp.ipower.com";
          $mail->IsHTML(true);
          $mail->Username = "no-reply@panamed.com.ph";
          $mail->Password = "Unimex123!!";
          $mail->SetFrom("no-reply@panamed.com.ph", "");
          $dept_head_email = $row2['dept_head_email'];
          
          $message = $firstname." ".$lastname." applied Overtime From: ".$ot_from." To: ".$ot_to." on  " .$ot_date. "<br />Reason: ".$reasons;
          $mail->Subject = "Overtime Application";
          $mail->Body = $message;
          $mail->isHTML(true);
          $mail->AddAddress('bumacodejhay@gmail.com');
          $mail->AddCC('ejhaybumacod26@gmail.com');
          if(!$mail->Send()) {
            echo json_encode(array('type' => 'success', 'message' => 'Overtime applied successfully <br /> Email not sent'));
            exit;
          } else {
            echo json_encode(array('type' => 'success', 'message' => 'Overtime applied successfully <br /> Email sent'));
            exit;
          }
      } else {
        echo json_encode(array('type' => 'error', 'message' => 'An error has occured upon uploading the form. Try again later.'));
        exit;
      }

    } else {
      echo json_encode(array('type' => 'error', 'message' => 'Approved overtime application is required'));
      exit;
    }

    

  }

  // function readleave(){

  //     $employeeno = $_POST['employeeno'];

  //     $conn = $this->connect_mysql();
  //     $query = $conn->prepare("UPDATE leave_application SET readd='read' WHERE employeeno='$employeeno'");
  //     $query->execute();

  // }

  // function readpayslip(){

  //     $employeeno = $_POST['employeeno'];

  //     $conn = $this->connect_mysql();
  //     $query = $conn->prepare("UPDATE payslips SET stat='read' WHERE employeeno='$employeeno'");
  //     $query->execute();

  // }

  function delete_otapply(){
      $id = $_POST['id'];
      $conn=$this->connect_mysql();
      $sql = $conn->prepare("DELETE FROM tbl_overtime WHERE id='$id' AND statuss='Pending'");
      $sql->execute();
  }

  function loadmyot(){

    $employeeno = $_GET['employeeno'];
    $status = $_GET['status'];
    $conn = $this->connect_mysql();
    if($status == ''){
      $query = $conn->prepare("SELECT a.*,a.id as idd,b.firstname,b.lastname,b.job_title FROM tbl_overtime a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                             WHERE a.employeeno='$employeeno' ORDER BY a.id DESC");
    }else {
      $query = $conn->prepare("SELECT a.*,a.id as idd,b.firstname,b.lastname,b.job_title FROM tbl_overtime a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                             WHERE a.employeeno='$employeeno' AND a.statuss='$status' ORDER BY a.id DESC");
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
                  
          $data['remarks'] = $x['remarks'];
          $data['employeeno'] = utf8_decode($x['firstname'].' '.$x['lastname']);
          $data['position'] = $x['job_title'];
          $data['reasons'] = $x['reasons'];
          $data['date_filed'] = $x['date_filed'];
          $data['ot_from'] = $x['ot_from'];
          $data['ot_to'] = $x['ot_to'];
          $data['no_of_hrs'] = $x['no_of_hrs'];
          $data['ot_date'] = $x['ot_date'];
          $data['status'] = $x['statuss'];
          if($x['statuss']=="Pending"){
            $data['action'] = '<center class="d-flex justify-content-around">
              <button title="View details" onclick="open_ot('.$x['id'].',\''.$x['firstname'].'\',\''.$x['lastname'].'\',\''.$x['job_title'].'\',\''.$x['reasons'].'\',\''.$x['date_filed'].'\',\''.$x['ot_from'].'\',\''.$x['ot_to'].'\',\''.$x['no_of_hrs'].'\',\''.$x['ot_date'].'\',\''.$x['statuss'].'\',\''.$x['remarks'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-success"><i class="fas fa-eye fa-eye"></i></button>
              <button type="button" onclick="delete_myot('.$x['idd'].')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
            </center>';
          }else{
            $data['action'] = '<center class="d-flex justify-content-around">
            <button title="View details" onclick="open_ot('.$x['id'].',\''.$x['firstname'].'\',\''.$x['lastname'].'\',\''.$x['job_title'].'\',\''.$x['reasons'].'\',\''.$x['date_filed'].'\',\''.$x['ot_from'].'\',\''.$x['ot_to'].'\',\''.$x['no_of_hrs'].'\',\''.$x['ot_date'].'\',\''.$x['statuss'].'\',\''.$x['remarks'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-success"><i class="fas fa-eye fa-eye"></i></button>
            <button disabled class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button></center>';
          }
          

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  // function count_leaveapp(){

  //   $employeenoo = $_POST['employeenoo'];
  //   $conn = $this->connect_mysql();

  //   $sq = $conn->prepare("SELECT department FROM tbl_employee WHERE employeeno='$employeenoo'");
  //   $sq->execute();
  //   $rw = $sq->fetch();

  //   $dept = $rw['department'];

  //   $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
  //                            LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.status='Pending' ORDER BY a.id DESC");
  //   $query->execute();

  //   $count = $query->rowCount();

  //   echo json_encode(array("count"=>$count));
  // }

  // function count_otapp(){

  //   $conn = $this->connect_mysql();
  //   $query = $conn->prepare("SELECT * FROM tbl_overtime WHERE statuss='Pending' ORDER BY id DESC");
  //   $query->execute();

  //   $count = $query->rowCount();

  //   echo json_encode(array("count"=>$count));
  // }

  // function count_payslip(){

  //   $employeenoo = $_POST['employeenoo'];
  //   $conn = $this->connect_mysql();

  //   $query = $conn->prepare("SELECT * FROM payslips WHERE employeeno='$employeenoo' AND stat='posted'");
  //   $query->execute();
  //   $count = $query->rowCount();

  //   echo json_encode(array("count"=>$count));
  // }

  // function count_reimbursement(){

  //   $conn = $this->connect_mysql();
  //   $query = $conn->prepare("SELECT * FROM tbl_reimbursement WHERE statuss='Pending'");
  //   $query->execute();

  //   $count = $query->rowCount();

  //   echo json_encode(array("count"=>$count));
  // }

}

$x = new crud();

if(isset($_GET['apply_overtime'])){
  $x->apply_overtime();
}

if(isset($_GET['readleave'])){
  $x->readleave();
}

if(isset($_GET['readpayslip'])){
  $x->readpayslip();
}

if(isset($_GET['delete_otapply'])){
  $x->delete_otapply();
}

if(isset($_GET['loadmyot'])){
  $x->loadmyot();
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
