<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function uploadpayslip(){

    if (($_FILES['empfile']['name']!="")){

      $employeeddown = $_POST['employeeddown'];
      $datefrom = $_POST['datefrom'];
      $dateto = $_POST['dateto'];
      $processdate = $_POST['processdate'];
      $datenow = date('Y-m-d');
      // Where the file is going to be stored
       $target_dir = "../payslips/".$employeeddown."/";
       $file = $_FILES['empfile']['name'];
       $path = pathinfo($file);
       $filename = $datenow.' - '.$employeeddown;
       $ext = $path['extension'];
       $attachfile = $filename.".".$ext;
       $temp_name = $_FILES['empfile']['tmp_name'];
       $path_filename_ext = $target_dir.$filename.".".$ext;


      // Check if file already exists
       if (file_exists($path_filename_ext)) {
        echo "Sorry, file already exists.";
       }else{
  
        mkdir("../payslips/".$employeeddown);

        // $lto_upload = $target_dir.$attachfile;
        // unlink($lto_upload);

          move_uploaded_file($temp_name,$path_filename_ext);

          $conn=$this->connect_mysql();
          $sql = $conn->prepare("INSERT INTO payslips SET employeeno='$employeeddown', filename='$attachfile', pay_periodfrom='$datefrom', pay_periodto='$dateto', process_date='$processdate', stat='posted'");
          $sql->execute();


          $sqry = $conn->prepare("SELECT id FROM tbl_employee WHERE employeeno='$employeeddown'");
          $sqry->execute();
          $srow = $sqry->fetch();
          $employee_id = $srow['id'];

          $sqry2 = $conn->prepare("SELECT corp_email FROM contactinfo WHERE emp_id='$employee_id'");
          $sqry2->execute();
          $srow2 = $sqry2->fetch();
          $corp_email = $srow2['corp_email'];


            // require 'PHPMailer\src\Exception.php';
            // require 'PHPMailer\src\PHPMailer.php';
            // require 'PHPMailer\src\SMTP.php';
            // require 'PHPMailer\src\PHPMailerAutoload.php';

            // $mail = new PHPMailer();
            // $mail->IsSMTP();
            // $mail->SMTPDebug = 1;
            // $mail->SMTPAuth = true;
            // $mail->SMTPSecure = 'ssl';
            // $mail->Host = "smtp.gmail.com";
            // $mail->Port = 465;
            // $mail->IsHTML(true);
            // $mail->Username = "pmcmailchimp@gmail.com";
            // $mail->Password = "1_pmcmailchimp@gmail.com";
            // $mail->SetFrom("inquiry@inmed.com.ph", "");
            // $mail->Subject = "Re: Payslip";
            // $msg = 'Your payslip was already uploaded to your HRIS account.';
            // $mail->Body = $msg;

            // $mail->isHTML(true);
            // $mail->AddAddress($corp_email);
            
            // if(!$mail->Send()) {
            //     echo "Mailer Error: " . $mail->ErrorInfo;
            // } else {
            // }


          header("location:../uplo.php");

          
       }

       
    }

  }

  function deletepayslip(){


    $id = $_POST['id'];
    $filename = $_POST['filename'];
    $employeeno = $_POST['employeeno'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("DELETE FROM payslips WHERE id='$id'");
    $query->execute();

    $link_file = "../payslips/".$employeeno."/".$filename;
    unlink($link_file);

  }

  function loadpayslip(){

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT b.lastname,b.firstname,a.* FROM payslips a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno ORDER BY a.process_date DESC");
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
          <button onclick="dl_payslip(\''.$x['filename'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i> View</button>
          <button onclick="delete_payslip('.$x['id'].',\''.$x['filename'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>
          
          </center>
          ';

          $data['employeeno'] = utf8_decode($x['lastname'].', '.$x['firstname']);
          $data['file_name'] = $x['filename'];
          $data['pay_period'] = $x['pay_periodfrom']." - ".$x['pay_periodto'];
          $data['process_date'] = $x['process_date'];

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

  function employeelist_surname(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM tbl_employee ORDER BY lastname ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Employee--</option>';
      while($row=$sql->fetch()){
        foreach ($row as $key => $input_arr) {
          $row[$key] = addslashes($input_arr);
          $row[$key] = utf8_encode($input_arr);
          }
       $option.='<option value="'.$row['employeeno'].'">'.utf8_decode($row['lastname'].', '.$row['firstname']).'</option>';
     }
      echo $option;
  }

}

$x = new crud();

if(isset($_GET['uploadpayslip'])){
  $x->uploadpayslip();
}
if(isset($_GET['deletepayslip'])){
  $x->deletepayslip();
}
if(isset($_GET['loadpayslip'])){
  $x->loadpayslip();
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
if(isset($_GET['employeelist_surname'])){
  $x->employeelist_surname();
}

 ?>
