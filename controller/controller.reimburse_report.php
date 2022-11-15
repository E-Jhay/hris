<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function employeelistadmin(){

      $employeenoo = $_GET['employeenoo'];
      $conn=$this->connect_mysql();
      $sq = $conn->prepare("SELECT department FROM tbl_employee WHERE employeeno='$employeenoo'");
      $sq->execute();
      $rw = $sq->fetch();
      $dept = $rw['department'];

      $sql = $conn->prepare("SELECT * FROM tbl_employee  WHERE  employeeno !='$employeenoo' ORDER BY lastname ASC");
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

  function check_reim_bal(){

      $employeeno = $_POST['employeeno'];
      $conn = $this->connect_mysql();
      $sql = $conn->prepare("SELECT reimbursement_bal FROM tbl_employee wHERE employeeno='$employeeno'");
      $sql->execute();
      $row = $sql->fetch();

      $balance = $row['reimbursement_bal'];
      echo json_encode(array("balance"=>$balance));

  }

  function reset_credit(){

      $conn = $this->connect_mysql();

      $squery = $conn->prepare("UPDATE tbl_employee SET reimbursement_bal='3500'");
      $squery->execute();

  }

  function approve_reimbursement(){

      $rem_id = $_POST['rem_id'];
      $amount_modal = $_POST['amount_modal'];
      $remarks = $_POST['remarks'];
      $statuss = $_POST['statuss'];
      $employeeno = $_POST['employeeno'];
      $avail_credits = $_POST['credits_modal'];

      $conn = $this->connect_mysql();

      $q = $conn->prepare("SELECT statuss FROM tbl_reimbursement WHERE id='$rem_id'");
      $q->execute();
      $row = $q->fetch();
      $statuss_before = $row['statuss'];

      $squery = $conn->prepare("UPDATE tbl_reimbursement SET amount='$amount_modal',statuss='$statuss',remarks='$remarks' WHERE id='$rem_id'");
      $squery->execute();



        if($statuss=="Approved"){

          $new_balance = $avail_credits - $amount_modal;
          $squery = $conn->prepare("UPDATE tbl_employee SET reimbursement_bal='$new_balance' WHERE employeeno='$employeeno'");
          $squery->execute();


        }else if($statuss=="Pending" && $statuss_before =="Approved"){

          $new_balance = $avail_credits + $amount_modal;
          $squery = $conn->prepare("UPDATE tbl_employee SET reimbursement_bal='$new_balance' WHERE employeeno='$employeeno'");
          $squery->execute();

        }


      $sqry = $conn->prepare("SELECT id,firstname,lastname,department FROM tbl_employee WHERE employeeno='$employeeno'");
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
            // $mail->Subject = "Omnibus Application Status";
            // $msg = 'Your request Omnibus reimbursement was '.$statuss.' by HR Assistant - Payroll<br><br>Amount: '.$amount_modal;
            // $mail->Body = $msg;

            // $mail->isHTML(true);
            // $mail->AddAddress($corp_email);
            // if(!$mail->Send()) {
            //     echo "Mailer Error: " . $mail->ErrorInfo;
            // } else {

            // }
      

  }

 function load_myreimburse(){

    $type = $_GET['type'];
    $employeeno = $_GET['employeeno'];
    $conn = $this->connect_mysql();
    if($type=="all"){
      $statuss = $_GET['statuss'];
      if($statuss==""){
        $query = $conn->prepare("SELECT a.*,b.lastname,b.firstname,b.reimbursement_bal FROM tbl_reimbursement a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno ORDER BY a.datee DESC");
      }else {
        $query = $conn->prepare("SELECT a.*,b.lastname,b.firstname,b.reimbursement_bal FROM tbl_reimbursement a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.statuss='$statuss' ORDER BY a.datee DESC");
      }
      
    }else if($type="personal"){
      $query = $conn->prepare("SELECT a.*,b.lastname,b.firstname,b.reimbursement_bal FROM tbl_reimbursement a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.employeeno='$employeeno' ORDER BY a.datee DESC");
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
          
          
          // <button onclick="delete_file('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="inv-button-sm btn btn-xs btn-danger" style="font-size:10px"><i class="fa fa-trash"></i> Delete</button>
          $data['employee_name'] = utf8_decode($x['lastname'].', '.$x['firstname']);
          $data['description'] = $x['description'];
          $data['nature'] = $x['nature'];
          $data['amount'] = $x['amount'];
          $data['datee'] = $x['datee'];
          $data['statuss'] = $x['statuss'];

          if($type=="all"){

            $data['action'] = '<center>
            <button onclick="view_file('.$x['id'].',\''.$x['employeeno'].'\',\''.$x['description'].'\',\''.$x['nature'].'\',\''.$x['datee'].'\',\''.$x['amount'].'\',\''.$x['file_name'].'\',\''.$x['remarks'].'\',\''.$x['orig_amount'].'\',\''.$x['statuss'].'\',\''.$x['lastname'].'\',\''.$x['firstname'].'\',\''.$x['reimbursement_bal'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i> View</button>
            <button onclick="dl_file(\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-info"><i class="fas fa-sm fa-download"></i> Download File</button>
            </center>';

          }else{

            if($x['statuss']=="Pending"){
              
            $data['action'] = '<center>
            <button onclick="view_file_personal('.$x['id'].',\''.$x['employeeno'].'\',\''.$x['description'].'\',\''.$x['nature'].'\',\''.$x['datee'].'\',\''.$x['amount'].'\',\''.$x['file_name'].'\',\''.$x['remarks'].'\',\''.$x['orig_amount'].'\',\''.$x['statuss'].'\',\''.$x['lastname'].'\',\''.$x['firstname'].'\',\''.$x['reimbursement_bal'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i> View</button>
            <button onclick="dl_file(\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-info"><i class="fas fa-sm fa-download"></i> Download File</button>
            <button onclick="delete_file('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>
            </center>';

            }else{

              $data['action'] = '<center>
              <button onclick="view_file_personal('.$x['id'].',\''.$x['employeeno'].'\',\''.$x['description'].'\',\''.$x['nature'].'\',\''.$x['datee'].'\',\''.$x['amount'].'\',\''.$x['file_name'].'\',\''.$x['remarks'].'\',\''.$x['orig_amount'].'\',\''.$x['statuss'].'\',\''.$x['lastname'].'\',\''.$x['firstname'].'\',\''.$x['reimbursement_bal'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i> View</button>
              <button onclick="dl_file(\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-info"><i class="fas fa-sm fa-download"></i> Download File</button>
              <button disabled="" onclick="delete_file('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>
              </center>';

            }

            

          }

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

  function uploadreimbursement(){
    $reimbursement_bal = $_POST['reimbursement_bal'];
    if($reimbursement_bal <=0){
      header("location:reimbursement_report.php?balance=0");
    }else{

        if (($_FILES['empfile']['name']!="")){
        $description = $_POST['description'];
        $nature = $_POST['nature'];
        $amount = $_POST['amount'];
        $empfile = $_POST['empfile'];
        $emp_no = $_POST['emp_no'];
        $datenow = date('Y-m-d');
        // Where the file is going to be stored
         $target_dir = "../reimbursement/".$emp_no."/";
         $file = $_FILES['empfile']['name'];
         $path = pathinfo($file);
         $filename = $path['filename'];
         $ext = $path['extension'];
         $attachfile = $filename.".".$ext;
         $temp_name = $_FILES['empfile']['tmp_name'];
         $path_filename_ext = $target_dir.$filename.".".$ext;
        // Check if file already exists
         if (file_exists($path_filename_ext)) {
          echo "Sorry, file already exists.";
         }else{
          mkdir("../reimbursement/".$emp_no);
          // $lto_upload = $target_dir.$attachfile;
          // unlink($lto_upload);
            move_uploaded_file($temp_name,$path_filename_ext);

            $conn=$this->connect_mysql();
            $sql = $conn->prepare("INSERT INTO tbl_reimbursement SET employeeno='$emp_no', description='$description', nature='$nature', datee='$datenow', amount='$amount', file_name='$attachfile', statuss='Pending', remarks='',orig_amount='$amount'");
            $sql->execute();

            header("location:../reimbursement_report.php?balance=yes");
         }    
      }
    }


  }  


}

$x = new crud();

if(isset($_GET['employeelistadmin'])){
  $x->employeelistadmin();
}
if(isset($_GET['check_reim_bal'])){
  $x->check_reim_bal();
}
if(isset($_GET['reset_credit'])){
  $x->reset_credit();
}
if(isset($_GET['approve_reimbursement'])){
  $x->approve_reimbursement();
}
if(isset($_GET['load_myreimburse'])){
  $x->load_myreimburse();
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
if(isset($_GET['uploadreimbursement'])){
  $x->uploadreimbursement();
}

 ?>
