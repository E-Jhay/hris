<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function demp_stat(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM employment_status ORDER BY employment_status ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Employment Status--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['employment_status'].'">'.$row['employment_status'].'</option>';}
      echo $option;
  }
  function dcompany(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM locations ORDER BY name ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Company--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['name'].'">'.$row['name'].'</option>';}
      echo $option;
  }
  function ddepartment(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM department ORDER BY department ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Department--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['department'].'">'.$row['department'].'</option>';}
      echo $option;
  }

  function selectprevious(){
    $emp_id = $_POST['emp_id'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,b.* FROM tbl_employee a 
                             LEFT JOIN previous_empinfo b 
                             ON a.id = b.emp_id
                             WHERE a.id='$emp_id'");
    $query->execute();
    $row = $query->fetch();

    foreach ($row as $key => $input_arr) {
      $row[$key] = addslashes($input_arr);
      $row[$key] = utf8_encode($input_arr);
    }
    echo json_encode(array(
      'emp_no'=>$row['employeeno'],
      'f_name'=>$row['firstname'],
      'l_name'=>utf8_decode($row['lastname']),
      'm_name'=>$row['middlename'],
      'rank'=>$row['rank'],
      'statuss'=>$row['statuss'],
      'emp_statuss'=>$row['employment_status'],
      'company'=>$row['company'],
      'company1'=>$row['company1'],
      'naturebusiness1'=>$row['naturebusiness1'],
      'year1'=>$row['year1'],
      'position1'=>$row['position1'],
      'rate1'=>$row['rate1'],
      'company2'=>$row['company2'],
      'naturebusiness2'=>$row['naturebusiness2'],
      'year2'=>$row['year2'],
      'position2'=>$row['position2'],
      'rate2'=>$row['rate2'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department'],
      'yearend1'=>$row['yearend1'],
      'yearend2'=>$row['yearend2']

    ));
  }

  function editpreviousemployer(){

      $emp_no = $_POST['emp_no'];
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $m_name = $_POST['m_name'];
      $rank = $_POST['rank'];
      $statuss = $_POST['statuss'];
      $emp_statuss = $_POST['emp_statuss'];
      $company = $_POST['company'];

      $empid = $_POST['emp_id'];
      $company1 = $_POST['company1'];
      $naturebusiness1 = $_POST['naturebusiness1'];
      $year1 = $_POST['year1'];
      $position1 = $_POST['position1'];
      $rate1 = $_POST['rate1'];
      $company2 = $_POST['company2'];
      $naturebusiness2 = $_POST['naturebusiness2'];
      $year2 = $_POST['year2'];
      $position2 = $_POST['position2'];
      $rate2 = $_POST['rate2'];
      $leave_balance = $_POST['leave_balance'];
      $department = $_POST['department'];
      $yearend1 = $_POST['yearend1'];
      $yearend2 = $_POST['yearend2'];

      $conn = $this->connect_mysql();
      $sql = $conn->prepare("SELECT id FROM previous_empinfo WHERE emp_id = '$empid'");
      $sql->execute();

      $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE id='$empid'");
      $qry1->execute();

      if($sql->fetch()) {
        $qry = $conn->prepare("UPDATE previous_empinfo SET company1='$company1', naturebusiness1='$naturebusiness1', year1='$year1', position1='$position1', rate1='$rate1', company2='$company2', naturebusiness2='$naturebusiness2', year2='$year2', position2='$position2', rate2='$rate2',yearend1='$yearend1',yearend2='$yearend2' WHERE emp_id='$empid'");
        $qry->execute();
      } else {
        $qry = $conn->prepare("INSERT INTO previous_empinfo SET company1='$company1', naturebusiness1='$naturebusiness1', year1='$year1', position1='$position1', rate1='$rate1', company2='$company2', naturebusiness2='$naturebusiness2', year2='$year2', position2='$position2', rate2='$rate2',yearend1='$yearend1',yearend2='$yearend2', emp_id='$empid'");
        $qry->execute();
      }

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the previous employer info of Employee no".$emp_no;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

      echo json_encode(array("id"=>$empid));

  }

}

$x = new crud();

if(isset($_GET['demp_stat'])){
  $x->demp_stat();
}
if(isset($_GET['dcompany'])){
  $x->dcompany();
}
if(isset($_GET['ddepartment'])){
  $x->ddepartment();
}

if(isset($_GET['selectprevious'])){
  $x->selectprevious();
}
if(isset($_GET['editpreviousemployer'])){
  $x->editpreviousemployer();
}

 ?>
