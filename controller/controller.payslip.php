<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function loadpayslip_ess(){

    $employeeno = $_GET['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM payslips WHERE employeeno='$employeeno'");
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
          <button onclick="dl_payslip(\''.$x['filename'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-download"></i> Download</button>
          </center>
          ';

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

  function count_reimbursement(){

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM tbl_reimbursement WHERE statuss='Pending'");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }


}

$x = new crud();

if(isset($_GET['loadpayslip_ess'])){
  $x->loadpayslip_ess();
}

if(isset($_GET['readleave'])){
  $x->readleave();
}

if(isset($_GET['count_leaveapp'])){
  $x->count_leaveapp();
}

if(isset($_GET['count_otapp'])){
  $x->count_otapp();
}

if(isset($_GET['count_reimbursement'])){
  $x->count_reimbursement();
}

 ?>
