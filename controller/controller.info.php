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

 ?>
