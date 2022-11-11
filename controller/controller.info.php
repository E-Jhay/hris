<?php
include 'controller.db.php';

class crud extends db_conn_mysql
{


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
    $firstname = $row['firstname'];
    $lastname = utf8_decode($row['lastname']);
    $middlename = $row['middlename'];
    $imagepic = utf8_decode($row['imagepic']);
    $employeeno = $row['employeeno'];
    $dateofbirth = $row['dateofbirth'];
    $marital_status = $row['marital_status'];
    $date_hired = $row['date_hired'];
    $nationality = $row['nationality'];
    $gender = $row['gender'];
    if($imagepic==""){
      $imagepic = "usera.png";
    }
    session_start();
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    echo json_encode(array("firstname"=>$firstname,"lastname"=>$lastname,"middlename"=>$middlename,"imagepic"=>$imagepic,"employeeno"=>$employeeno,"dateofbirth"=>$dateofbirth,"marital_status"=>$marital_status,"gender"=>$gender,"date_hired"=>$date_hired,"nationality"=>$nationality,"username"=>$username,"password"=>$password));
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
        if (($_FILES['profile']['name']!="")){

          // Where the file is going to be stored

          $target_dir = "../personal_picture/";
          $file = $_FILES['profile']['name'];
          $path = pathinfo($file);
          $filename = $path['filename'];
          $ext = $path['extension'];
          $attachfile = $filename.".".$ext;
          $temp_name = $_FILES['profile']['tmp_name'];
          $path_filename_ext = $target_dir.$filename.".".$ext;

          $lto_upload = $target_dir.$attachfile;
          unlink($lto_upload);

          //  Check if file already exists
          if (file_exists($path_filename_ext)) {
          echo "Sorry, file already exists.";
          }else{

            move_uploaded_file($temp_name,$path_filename_ext);

            $conn=$this->connect_mysql();
            $sql = $conn->prepare("UPDATE tbl_employee SET imagepic='$attachfile' WHERE employeeno='$employeeno'");
            $sql->execute();

          }
        }

        if(!empty($_FILES["marriageContract"]["name"])) {
          $target_dir = "../documents/".$employeeno."/";
          $file = $_FILES['marriageContract']['name'];
          $path = pathinfo($file);
          $ext = $path['extension'];
          $temp_name = $_FILES['marriageContract']['tmp_name'];
          $today = date("Ymd");
          $name = explode(".", $file);
          $marriageContract = $name[0]."-".$today.".".$ext;
          $path_filename_ext = $target_dir."marriage_contract/";
          if(!is_dir($path_filename_ext)){
            mkdir($path_filename_ext, 0755);
          }
          $path_filename_ext .= $marriageContract.".".$ext;

          move_uploaded_file($temp_name,$path_filename_ext);

        } else {
          $marriageContract = '';
        }

        if(!empty($_FILES["dependent"]["name"])) {
          $target_dir = "../documents/".$employeeno."/";
          $file = $_FILES['dependent']['name'];
          $path = pathinfo($file);
          $ext = $path['extension'];
          $temp_name = $_FILES['dependent']['tmp_name'];
          $today = date("Ymd");
          $name = explode(".", $file);
          $dependent = $name[0]."-".$today.".".$ext;
          $path_filename_ext = $target_dir;
          if(!is_dir($path_filename_ext)){
            mkdir($path_filename_ext, 0755);
          }
          $path_filename_ext .= $dependent.".".$ext;

          move_uploaded_file($temp_name,$path_filename_ext);

        } else {
          $dependent = '';
        }

        if(!empty($_FILES["additionalId"]["name"])) {
          $target_dir = "../documents/".$employeeno."/";
          $file = $_FILES['additionalId']['name'];
          $path = pathinfo($file);
          $ext = $path['extension'];
          $temp_name = $_FILES['additionalId']['tmp_name'];
          $today = date("Ymd");
          $name = explode(".", $file);
          $additionalId = $name[0]."-".$today.".".$ext;
          $path_filename_ext = $target_dir;
          if(!is_dir($path_filename_ext)){
            mkdir($path_filename_ext, 0755);
          }
          $path_filename_ext .= $additionalId.".".$ext;

          move_uploaded_file($temp_name,$path_filename_ext);

        } else {
          $additionalId = '';
        }

        if(!empty($_FILES["proofOFBilling"]["name"])) {
          $target_dir = "../documents/".$employeeno."/";
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
            mkdir($path_filename_ext, 0755);
          }
          $path_filename_ext .= $proofOFBilling.".".$ext;

          move_uploaded_file($temp_name,$path_filename_ext);

        } else {
          $proofOFBilling = '';
        }

        $conn = $this->connect_mysql();
        $query = $conn->prepare("INSERT INTO employee_documents (employee_number, marriage_contract, dependent, additional_id, proof_of_billing) VALUES ('$employeeno', '$marriageContract', '$dependent', '$additionalId', '$proofOFBilling')");
        $query->execute();
      } catch (Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }
      // print_r($_POST['employeeno']);
      // print_r($_FILES);
      // header("Location: https://google.com");
      header("location:../myinfo.php");
    }
}

$x = new crud();

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
