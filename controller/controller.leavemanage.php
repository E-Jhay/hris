<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function leave_typelist(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM leave_type WHERE leave_stat='active'");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Leave type--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['leave_type'].'">'.$row['leave_type']." - ".$row['leave_name'].'</option>';}

      echo $option;
  }

  function check_leave(){

    $leavetype = $_POST['leavetype'];
    $empno = $_POST['empno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM leave_balance WHERE employee_no='$empno' AND leave_type='$leavetype'");
    $query->execute();

    $row = $query->rowCount();
    if($row >=1){
      echo json_encode(array("counts"=>"many"));
    }else{
      echo json_encode(array("counts"=>"zero"));
    }

  }

  function convert_sl(){

      $conn=$this->connect_mysql();

      $sql = $conn->prepare("SELECT employee_no,balance FROM leave_balance WHERE leave_type='SL'");
      $sql->execute();
      $row = $sql->fetchAll();

      foreach ($row as $x) {
          $employeeno = $x['employee_no'];
          $balance = $x['balance'];

          $sql4 = $conn->prepare("SELECT leave_balance FROM tbl_employee WHERE employeeno='$employeeno'");
          $sql4->execute();
          $row4 = $sql4->fetch();
          $leave_balance = $row4['leave_balance'];

          $new_balance = $leave_balance - $balance;

          $sqll = $conn->prepare("UPDATE tbl_employee SET leave_balance='$new_balance' WHERE employeeno='$employeeno'");
          $sqll->execute();
      }

      $sql2 = $conn->prepare("UPDATE leave_balance SET balance='0' WHERE leave_type='SL'");
      $sql2->execute();

  }

  function addemployee_leave(){

      $addempno = $_POST['addempno'];
      $addleave_type = $_POST['addleave_type'];
      $addleave_balance = $_POST['addleave_balance'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("INSERT INTO leave_balance SET employee_no='$addempno', leave_type='$addleave_type', balance='$addleave_balance', stat='off'");
      $sql->execute();

      $sql2 = $conn->prepare("SELECT leave_balance FROM tbl_employee WHERE employeeno='$addempno'");
      $sql2->execute();
      $row = $sql2->fetch();
      $leave_balance = $row['leave_balance'];

      $new_balance = $leave_balance + $addleave_balance;

      $sql3 = $conn->prepare("UPDATE tbl_employee SET leave_balance='$new_balance' WHERE employeeno='$addempno'");
      $sql3->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Added leave balance to Employee no. ".$addempno;
      $audittype = "Add";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

  }

  function reset_balance(){

      $conn = $this->connect_mysql();

      $squery = $conn->prepare("UPDATE leave_balance SET balance='0'");
      $squery->execute();
  }

  function addleavetype(){

      $leave_type = $_POST['leave_type'];
      $leave_name = $_POST['leave_name'];
      $leave_stat = $_POST['leave_stat'];
      $points = $_POST['points'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("INSERT INTO leave_type SET leave_type='$leave_type', leave_name='$leave_name', leave_stat='$leave_stat', points='$points'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Added new leave type".$leave_type;
      $audittype = "ADD";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function updateleavetype(){

      $id_leave = $_POST['id_leave'];
      $leave_type = $_POST['leave_type'];
      $leave_name = $_POST['leave_name'];
      $leave_stat = $_POST['leave_stat'];
      $points = $_POST['points'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("UPDATE leave_type SET leave_type='$leave_type', leave_name='$leave_name', leave_stat='$leave_stat', points='$points' WHERE id='$id_leave'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the leave type".$leave_type;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function deleteleavetype(){

      $id = $_POST['id'];
      $conn=$this->connect_mysql();
      $sql = $conn->prepare("DELETE FROM leave_type WHERE id='$id'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Deleted a leave type";
      $audittype = "Delete";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function load_leaveemployee(){

    $employeeno = $_GET['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM leave_balance WHERE employee_no='$employeeno'");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);

          }
          if ($x['balance'] < 0){
            $x['balance'] = 0;
          }
          $data = array();
          $id = "emp_leavebal".$x['id'];
          $data['leave_type'] = $x['leave_type'];
          $data['balance'] = '<input type="number" value="'.$x['balance'].'" class="w-100" id="'.$id.'">';
          $data['action'] = '<button onclick="update_emp_leavebal('.$x['id'].',\''.$x['employee_no'].'\')" style="display:none"><i class="fa fa-pencil"></i> Update</button>

           <button onclick="delete_emp_leavebal('.$x['id'].',\''.$x['employee_no'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function checkleave_byemployee(){
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM leave_balance WHERE employee_no='$employeeno'");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);

          }
          $data = array();
          $id = $x['id'];
          $data['id'] = $id;

        $return[] = $data;
      }
    echo json_encode($return);
  }

  function update_leavebal(){

      $id = $_POST['id'];
      $emp_leavebal = $_POST['emp_leavebal'];
      $employee_no = $_POST['employee_no'];

      $conn=$this->connect_mysql();

      $sql = $conn->prepare("SELECT balance FROM leave_balance WHERE id='$id'");
      $sql->execute();
      $roww = $sql->fetch();
      $balance = $roww['balance'];

      $sqll = $conn->prepare("UPDATE leave_balance SET balance='$emp_leavebal' WHERE id='$id'");
      $sqll->execute();

      $sql2 = $conn->prepare("SELECT leave_balance FROM tbl_employee WHERE employeeno='$employee_no'");
      $sql2->execute();
      $row = $sql2->fetch();
      $leave_balance = $row['leave_balance'];
      $new_balance = $leave_balance - $balance;
      $n_balance = $new_balance + $emp_leavebal;

      $sql3 = $conn->prepare("UPDATE tbl_employee SET leave_balance='$n_balance' WHERE employeeno='$employee_no'");
      $sql3->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update leave balance to Employee no. ".$employee_no;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

    }

    function delete_leavebal(){

      $id = $_POST['id'];
      $emp_leavebal = $_POST['emp_leavebal'];
      $employee_no = $_POST['employee_no'];

      $conn=$this->connect_mysql();

      $qry = $conn->prepare("DELETE FROM leave_balance WHERE id='$id'");
      $qry->execute();

      $sql2 = $conn->prepare("SELECT leave_balance FROM tbl_employee WHERE employeeno='$employee_no'");
      $sql2->execute();
      $row = $sql2->fetch();
      $leave_balance = $row['leave_balance'];
      $new_balance = $leave_balance - $emp_leavebal;

      $sql3 = $conn->prepare("UPDATE tbl_employee SET leave_balance='$new_balance' WHERE employeeno='$employee_no'");
      $sql3->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Deleted leave balance to Employee no. ".$employee_no;
      $audittype = "Delete";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();


    }

    function load_leavebalance(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,b.* FROM tbl_employee a
                            LEFT JOIN contractinfo b
                            ON a.id=b.emp_id WHERE b.emp_id = 1 ORDER BY a.lastname ASC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);

          }
          $data = array();

          $fullname = $x['lastname'].",".$x['firstname'];
          $employeeno = $x['employeeno'];

          $query2 = $conn->prepare("SELECT balance FROM leave_balance WHERE employee_no='$employeeno' AND leave_type='SL'");
          $query2->execute();
          $row2 = $query2->fetch();
          if($row2['balance']=="" || $row2['balance'] < 0){
            $row2['balance'] = 0;
          }

          $query3 = $conn->prepare("SELECT balance FROM leave_balance WHERE employee_no='$employeeno' AND leave_type='VL'");
          $query3->execute();
          $row3 = $query3->fetch();
          if($row3['balance']=="" || $row3['balance'] < 0){
            $row3['balance'] = 0;
          }

          $data['employeeno'] = $x['employeeno'];
          $full_name = $x['lastname'].", ".$x['firstname'];
          $data['fullname'] = utf8_decode($full_name);

          // date today = 10-06-2022
          // date hired = 04-10-2018
          $date_today = date('Y-m-d');
          $em = date('m',strtotime($date_today));
          $ed = date('d',strtotime($date_today));

          $years=  date('Y',strtotime($date_today)) - date('Y', strtotime($x['date_hired'])); // 2018 - 2022 = 4
          // $months = date('m',strtotime($date_today)) - date('m', strtotime($x['date_hired'])); // 06 - 10 = 4
          $months = date('m',strtotime($date_today)); // 06 - 10 = 4
          $days = date('d',strtotime($date_today)) - date('d', strtotime($x['date_hired'])); // 01 - 10 = 9

          $diffmonth = $years * 12 + $months; // 5 x 12 + 7 = 67

          // if($days < 0){ // if days less than to 0

          //   $months -= 1; // 7 - 1 = 6
          //   $diffmonth -=1; // 67 - 1 = 66
          // }
          // if($months < 0){
          //   $months = 0; // 7
          //   $years -=1; // 5 - 1 = 4
          // }
          // 20222125
          
          // echo $months."<br>";

          // echo $x['date_hired']."<br>";
            

            $data['noofyears'] = $years;
            $data['s_leave'] = $row2['balance'];
            $data['v_leave'] =  $row3['balance'];
            $data['date_hired'] =  date('F d, Y', strtotime($x['date_hired']));
  
           $data['action'] = '
           <button onclick="addempleave('.$x['id'].',\''.$x['employeeno'].'\',\''.$fullname.'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-plus-circle"></i> Add</button>

           <button onclick="viewleave('.$x['id'].',\''.$x['employeeno'].'\',\''.$fullname.'\',\''.$x['job_category'].'\',\''.$x['employment_status'].'\',\''.$x['company'].'\',\''.$x['leave_balance'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-chevron-circle-up"></i> Open</button>';

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function load_leavemonitoring(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM leave_monitor");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $data['tenure'] = $x['tenure'];
          $data['earned_points'] = $x['earned_points'];
          $data['vacation'] = $x['vacation'];
          $data['sick'] = $x['sick'];
          $data['total'] = $x['total'];
          $data['action'] = '<button onclick="addempleavemonitor('.$x['id'].')" style="font-size:10px;color: white;background: #4c91cd;border-color: #4c91cd;"><i class="fa fa-pencil"></i> Edit</button>';

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function load_leavetype(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM leave_type");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $data['leave_type'] = $x['leave_type'];
          $data['leave_name'] = $x['leave_name'];
          $data['leave_stat'] = $x['leave_stat'];
          // $data['points'] = $x['points'];
           $data['action'] = '
           <button onclick="editleave_type('.$x['id'].',\''.$x['leave_type'].'\',\''.$x['leave_name'].'\',\''.$x['leave_stat'].'\',\''.$x['points'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-edit"></i> Edit</button>
           <button onclick="deleteleave_type('.$x['id'].')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }


}

$x = new crud();

if(isset($_GET['leave_typelist'])){
  $x->leave_typelist();
}
if(isset($_GET['check_leave'])){
  $x->check_leave();
}
if(isset($_GET['convert_sl'])){
  $x->convert_sl();
}
if(isset($_GET['addemployee_leave'])){
  $x->addemployee_leave();
}
if(isset($_GET['reset_balance'])){
  $x->reset_balance();
}
if(isset($_GET['addleavetype'])){
  $x->addleavetype();
}
if(isset($_GET['updateleavetype'])){
  $x->updateleavetype();
}
if(isset($_GET['deleteleavetype'])){
  $x->deleteleavetype();
}
if(isset($_GET['load_leaveemployee'])){
  $x->load_leaveemployee();
}
if(isset($_GET['checkleave_byemployee'])){
  $x->checkleave_byemployee();
}
if(isset($_GET['update_leavebal'])){
  $x->update_leavebal();
}
if(isset($_GET['delete_leavebal'])){
  $x->delete_leavebal();
}
if(isset($_GET['load_leavebalance'])){
  $x->load_leavebalance();
}
if(isset($_GET['load_leavemonitoring'])){
  $x->load_leavemonitoring();
}
if(isset($_GET['load_leavetype'])){
  $x->load_leavetype();
}
 ?>
