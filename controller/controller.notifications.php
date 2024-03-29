<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function loadnotifleave(){

      $currentUser = $_GET['currentUser'];
      $conn = $this->connect_mysql();
      $query = $conn->prepare("SELECT * FROM leave_application WHERE status !='Pending' AND employeeno='$currentUser' ORDER BY  last_update DESC,last_update_time DESC");
      $query->execute();
      $row = $query->fetchAll();
      $return = array();
        foreach ($row as $x){

            foreach ($x as $key => $input_arr) {
            $x[$key] = addslashes($input_arr);

            }

            $data = array();
            $pay_leave = $x['pay_leave'];
            $status = $x['status'];
            $data['date_time'] = '<p style="font-size:12px">'.date('M d, Y',strtotime($x['last_update'])).' &nbsp;&nbsp;'. date('h:i:s A',strtotime($x['last_update_time'])).'</p>';
            if($pay_leave=="With Pay"){
              
              if($status=="Disapproved"){
                $data['trail'] = '<p style="font-size:12px">Your request <b>'.$x['leave_type'].'</b> for <b>'.date('M d, Y',strtotime($x['datefrom'])).'</b> to <b>'.date('M d, Y',strtotime($x['dateto'])).'</b> was '.$x['status'].' by '.$x['approved_by'].'<br>Total credits deducted: <b>0</b></p>';
              }else{
                $data['trail'] = '<p style="font-size:12px">Your request <b>'.$x['leave_type'].'</b> for <b>'.date('M d, Y',strtotime($x['datefrom'])).'</b> to <b>'.date('M d, Y',strtotime($x['dateto'])).'</b> was '.$x['status'].' by '.$x['approved_by'].'<br>Total credits deducted: <b>'.$x['no_days'].'</b></p>';
              }

            }else{
              $data['trail'] = '<p style="font-size:12px">Your request <b>'.$x['leave_type'].'</b> for <b>'.date('M d, Y',strtotime($x['datefrom'])).'</b> to <b>'.date('M d, Y',strtotime($x['dateto'])).'</b> was '.$x['status'].' by '.$x['approved_by'].'<br>Total credits deducted: <b>0</b></p>';
            }
            
          $return[] = $data;
        }
      
      echo json_encode(array('data'=>$return));


  }

  function loadNotifOmnibus(){
    $currentUser = $_GET['currentUser'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM tbl_reimbursement WHERE statuss !='Pending' AND employeeno='$currentUser' ORDER BY datee");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);

          }

          $data = array();
          $status = $x['statuss'];
          $data['date_time'] = '<p style="font-size:12px">'.date('M d, Y',strtotime($x['datee'])).'</p>';

          if($status=="Disapproved"){
            $data['trail'] = '<p style="font-size:12px">Your omnibus request with OR/SI number: <b>'.$x['description'].'</b> this day of <b>'.date('M d, Y',strtotime($x['datee'])).' was '.$x['statuss'].' by Administrator <br>Total credits deducted: <b>0</b></p>';
          }else{
            $data['trail'] = '<p style="font-size:12px">Your omnibus request with OR/SI number: <b>'.$x['description'].'</b> this day of <b>'.date('M d, Y',strtotime($x['datee'])).' was '.$x['statuss'].' by Administrator <br>Total credits deducted: <b>' .$x['amount']. '</b></p>';
          }
          
          $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function loadNotifOvertime(){

      $currentUser = $_GET['currentUser'];
      $conn = $this->connect_mysql();
      $query = $conn->prepare("SELECT * FROM tbl_overtime WHERE statuss !='Pending' AND employeeno='$currentUser' ORDER BY date_filed");
      $query->execute();
      $row = $query->fetchAll();
      $return = array();
        foreach ($row as $x){

            foreach ($x as $key => $input_arr) {
            $x[$key] = addslashes($input_arr);

            }

            $data = array();
            
            $data['date_time'] = '<p style="font-size:12px">'.date('M d, Y',strtotime($x['date_filed'])).'</p>';

            $data['trail'] = '<p style="font-size:12px">Your overtime request this day of <b>'.date('M d, Y',strtotime($x['date_filed'])).' was '.$x['statuss'].' by Administrator</p>';
            
            $return[] = $data;
        }
      
      echo json_encode(array('data'=>$return));


  }

  // function readpayslip(){

  //     $employeeno = $_POST['employeeno'];

  //     $conn = $this->connect_mysql();
  //     $query = $conn->prepare("UPDATE payslips SET stat='read' WHERE employeeno='$employeeno'");
  //     $query->execute();

  // }

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

if(isset($_GET['loadnotifleave'])){
  $x->loadnotifleave();
}
if(isset($_GET['loadNotifOmnibus'])){
  $x->loadNotifOmnibus();
}
if(isset($_GET['loadNotifOvertime'])){
  $x->loadNotifOvertime();
}

?>
