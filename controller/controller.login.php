<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function login(){

      $username = $_POST['username'];
      $password = $_POST['password'];
      $empstatus = "active";
      $conn = $this->connect_mysql();
      $qry = $conn->prepare("SELECT * FROM user_account WHERE username=:username AND password=:password AND empstatus=:empstatus");
      $qry->bindParam(":username",$username);
      $qry->bindParam(":password",$password);
      $qry->bindParam(":empstatus",$empstatus);
      $qry->execute();
      $row = $qry->fetch();
      $count = $qry->rowCount();
      if($count >0){
          session_start();
          $_SESSION['fullname'] = $row['fullname'];
          $_SESSION['usertype'] = $row['usertype'];
          $_SESSION['employeeno'] = $row['employeeno'];
          $_SESSION['userrole'] = $row['userrole'];
          $_SESSION['approver'] = $row['approver'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['password'] = $row['password'];

          $employeeno = $row['employeeno'];
          $q = $conn->prepare("SELECT employment_status,id,department FROM tbl_employee WHERE employeeno='$employeeno'");
          $q->execute();
          $rw = $q->fetch();
          $empid = $rw['id'];
          $_SESSION['employment_status'] = $rw['employment_status'];
          $_SESSION['department'] = $rw['department'];

          $q2 = $conn->prepare("SELECT date_hired FROM contractinfo WHERE emp_id='$empid'");
          $q2->execute();
          $qrow = $q2->fetch();

          $years=  date('Y') - date('Y', strtotime($qrow['date_hired']));
          $months = date('m') - date('m', strtotime($qrow['date_hired']));
          $days = date('d') - date('d', strtotime($qrow['date_hired']));

          $diffmonth = $years * 12 + $months;

          if($days < 0){

            $months -= 1;
            $diffmonth -=1;
          }
          $_SESSION['employee_month'] = $diffmonth;

          echo json_encode(array("emp_status"=>"meron"));
      }else{
          echo json_encode(array("emp_status"=>"wala"));
      }

  }

  function logout(){
      session_start();
      session_destroy();
  }


}

$x = new crud();

if(isset($_GET['login'])){
  $x->login();
}

if(isset($_GET['logout'])){
  $x->logout();
}

 ?>
