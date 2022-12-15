<?php
include 'controller.db.php';

class crud extends db_conn_mysql
{


  function count_incident_reports(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM incident a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.status='active' ORDER BY a.id DESC");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
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

  function getmyinfo(){
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.employeeno,a.lastname,a.firstname,a.middlename,a.imagepic,b.date_hired,c.dateofbirth,c.gender,c.marital_status,d.nationality FROM tbl_employee a LEFT JOIN contractinfo b ON a.id=b.emp_id LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id LEFT JOIN contactinfo d ON a.id=d.emp_id WHERE a.employeeno='$employeeno'");

    $query->execute();
    $row = $query->fetch();

    $query1 = $conn->prepare("SELECT marriage_contract FROM marriage_contract WHERE employee_number='$employeeno'");
    $query1->execute();
    $marriage_temp = $query1->fetch();
    $marriage_contract = $marriage_temp ? $marriage_temp : array('marriage_contract' => '');

    $query2 = $conn->prepare("SELECT dependent FROM dependents WHERE employee_number='$employeeno'");
    $query2->execute();
    $dependent_temp = $query2->fetch();
    $dependent = $dependent_temp ? $dependent_temp : array('dependent' => '');

    $query3 = $conn->prepare("SELECT additional_id FROM additional_id WHERE employee_number='$employeeno'");
    $query3->execute();
    $additional_id_temp = $query3->fetch();
    $additional_id = $additional_id_temp ? $additional_id_temp : array('additional_id' => '');

    $query4 = $conn->prepare("SELECT proof_of_billing FROM proof_of_billing WHERE employee_number='$employeeno'");
    $query4->execute();
    $proof_of_billing_temp = $query4->fetch();
    $proof_of_billing = $proof_of_billing_temp ? $proof_of_billing_temp : array('proof_of_billing' => '');
    
    $firstname = $row['firstname'] ?  $row['firstname'] : '';
    $lastname = $row['lastname'] ? utf8_decode($row['lastname']) : '';
    $middlename = $row['middlename'] ? $row['middlename'] : '';
    $imagepic = $row['imagepic'] ? utf8_decode($row['imagepic']) : '';
    $employeeno = $row['employeeno'] ? $row['employeeno'] : '';
    $dateofbirth = $row['dateofbirth'] ? $row['dateofbirth'] : '';
    $marital_status = $row['marital_status'] ? $row['marital_status'] : '';
    $date_hired = $row['date_hired'] ? $row['date_hired'] : '';
    $nationality = $row['nationality'] ? $row['nationality'] : '';
    $gender = $row['gender'] ? $row['gender'] : '';
    if($imagepic==""){
      $imagepic = "usera.png";
    }
    session_start();
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    echo json_encode(array("firstname"=>$firstname,"lastname"=>$lastname,"middlename"=>$middlename,"imagepic"=>$imagepic,"employeeno"=>$employeeno,"dateofbirth"=>$dateofbirth,"marital_status"=>$marital_status,"gender"=>$gender,"date_hired"=>$date_hired,"nationality"=>$nationality,"username"=>$username,"password"=>$password, "marriage_contract" => $marriage_contract['marriage_contract'], "dependent" => $dependent['dependent'], "additional_id" => $additional_id['additional_id'], "proof_of_billing" => $proof_of_billing['proof_of_billing']));
  }

  function changepassword(){
      $pass_modal = $_POST['pass_modal'];
      $empno = $_POST['empno'];

      $conn = $this->connect_mysql();

      $squery = $conn->prepare("UPDATE user_account SET password='$pass_modal' WHERE employeeno='$empno'");
      $squery->execute();


      session_start();
      $useraction = $_SESSION['fullname'];
      $_SESSION['password'] = $pass_modal;
      $dateaction = date('Y-m-d');
      $auditaction = "Employee no ".$empno." changed a password.";
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
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

  function addDocuments() {
    try {
      $employeeno = $_POST['employeeno'];
      $file_name = $_POST['file_name'];
      $prevMarriageContract = $_POST['prevMarriageContract'];
      $prevDependent = $_POST['prevDependent'];
      $prevAdditionalId = $_POST['prevAdditionalId'];
      $prevProofOfBilling = $_POST['prevProofOfBilling'];
      $conn=$this->connect_mysql();
      if (($_FILES['profile']['name']!="")){

        $target_dir = "../personal_picture/".$employeeno."/";
        $file = $_FILES['profile']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $profile = $filename.date('Y-m-d-His').".".$ext;
        $temp_name = $_FILES['profile']['tmp_name'];
        $path_filename_ext = $target_dir.$profile;

        if (file_exists($path_filename_ext)) {
          echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employeeno));
          exit;
        }else{
          if(!is_dir("../personal_picture/".$employeeno."/")){
            mkdir("../personal_picture/".$employeeno."/");
          }
          if(move_uploaded_file($temp_name,$path_filename_ext)){
            if($file_name != '' || $file_name != NULL){
              $link_file = $target_dir.$file_name;
              if(file_exists($link_file))
              unlink($link_file);
            }
            $sql = $conn->prepare("UPDATE tbl_employee SET imagepic='$profile' WHERE employeeno='$employeeno'");
            $sql->execute();
          }
        }

      }

      if(!empty($_FILES["marriageContract"]["name"])) {
        $target_dir = "../documents/".$employeeno."/marriage_contract/";
        $file = $_FILES['marriageContract']['name'];
        $path = pathinfo($file);
        $ext = $path['extension'];
        $temp_name = $_FILES['marriageContract']['tmp_name'];
        $today = date("Ymd");
        $name = explode(".", $file);
        $marriageContract = $name[0]."-".$today.".".$ext;
        $path_filename_ext = $target_dir;
        if(!is_dir($path_filename_ext)){
          mkdir("../documents/".$employeeno."/marriage_contract/", 0777, true);
        }
        $path_filename_ext .= $marriageContract;

        if(move_uploaded_file($temp_name,$path_filename_ext)) {
          if($prevMarriageContract != '' || $prevMarriageContract != NULL){
            $link_file = $target_dir.$prevMarriageContract;
            if(file_exists($link_file))
            unlink($link_file);
          }
          $query = $conn->prepare("UPDATE marriage_contract SET marriage_contract = '$marriageContract' WHERE employee_number = '$employeeno'");
          $query->execute();
        }
      } else {
        $marriageContract = '';
      }

      if(!empty($_FILES["dependent"]["name"])) {
        $target_dir = "../documents/".$employeeno."/dependent/";
        $file = $_FILES['dependent']['name'];
        $path = pathinfo($file);
        $ext = $path['extension'];
        $temp_name = $_FILES['dependent']['tmp_name'];
        $today = date("Ymd");
        $name = explode(".", $file);
        $dependent = $name[0]."-".$today.".".$ext;
        $path_filename_ext = $target_dir;
        if(!is_dir($path_filename_ext)){
          mkdir("../documents/".$employeeno."/dependent/", 0777, true);
        }
        $path_filename_ext .= $dependent;

        if(move_uploaded_file($temp_name,$path_filename_ext)) {
          if($prevDependent != '' || $prevDependent != NULL){
            $link_file = $target_dir.$prevDependent;
            if(file_exists($link_file))
            unlink($link_file);
          }
          $query2 = $conn->prepare("UPDATE dependents SET dependent = '$dependent' WHERE employee_number = '$employeeno'");
          $query2->execute();
        }

      } else {
        $dependent = '';
      }

      if(!empty($_FILES["additionalId"]["name"])) {
        $target_dir = "../documents/".$employeeno."/additional_id/";
        $file = $_FILES['additionalId']['name'];
        $path = pathinfo($file);
        $ext = $path['extension'];
        $temp_name = $_FILES['additionalId']['tmp_name'];
        $today = date("Ymd");
        $name = explode(".", $file);
        $additionalId = $name[0]."-".$today.".".$ext;
        $path_filename_ext = $target_dir;
        if(!is_dir($path_filename_ext)){
          mkdir("../documents/".$employeeno."/additional_id/", 0777, true);
        }
        $path_filename_ext .= $additionalId;

        if(move_uploaded_file($temp_name,$path_filename_ext)) {
          if($prevAdditionalId != '' || $prevAdditionalId != NULL){
            $link_file = $target_dir.$prevAdditionalId;
            if(file_exists($link_file))
            unlink($link_file);
          }
          $query3 = $conn->prepare("UPDATE additional_id SET additional_id = '$additionalId' WHERE employee_number = '$employeeno'");
          $query3->execute();
        }

      } else {
        $additionalId = '';
      }

      if(!empty($_FILES["proofOFBilling"]["name"])) {
        $target_dir = "../documents/".$employeeno."/proof_of_billing/";
        $file = $_FILES['proofOFBilling']['name'];
        $path = pathinfo($file);
        // $proofOFBilling = $path['filename'];
        $ext = $path['extension'];
        // $attachfile = $filename.".".$ext;
        $temp_name = $_FILES['proofOFBilling']['tmp_name'];
        $today = date("Ymd");
        $name = explode(".", $file);
        $proofOFBilling = $name[0]."-".$today.".".$ext;
        $path_filename_ext = $target_dir;
        if(!is_dir($path_filename_ext)){
          mkdir("../documents/".$employeeno."/proof_of_billing/", 0777, true);
        }
        $path_filename_ext .= $proofOFBilling;

        if(move_uploaded_file($temp_name,$path_filename_ext)) {
          if($prevProofOfBilling != '' || $prevProofOfBilling != NULL){
            $link_file = $target_dir.$prevProofOfBilling;
            if(file_exists($link_file))
            unlink($link_file);
          }
          $query4 = $conn->prepare("UPDATE proof_of_billing SET proof_of_billing = '$proofOFBilling' WHERE employee_number = '$employeeno'");
          $query4->execute();
        }

      } else {
        $proofOFBilling = '';
      }

      echo json_encode(array('message' => 'Successfully Saved', 'type' => 'success'));

    } catch (Exception $e) {
      echo 'Message: ' .$e->getMessage();
    }
    // print_r($_POST['employeeno']);
    // print_r($_FILES);
    // header("Location: https://google.com");
    // header("location:../myinfo.php");
  }
}

$x = new crud();

if(isset($_GET['count_incident_reports'])){
  $x->count_incident_reports();
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
if(isset($_GET['getmyinfo'])){
  $x->getmyinfo();
}
if(isset($_GET['changepassword'])){
  $x->changepassword();
}
if(isset($_GET['readleave'])){
  $x->readleave();
}
if(isset($_GET['readpayslip'])){
  $x->readpayslip();
}
if(isset($_GET['addDocuments'])){
  $x->addDocuments();
}

 ?>
