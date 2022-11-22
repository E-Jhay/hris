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

  function selectmedical(){
    $emp_id = $_POST['emp_id'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,b.* FROM tbl_employee a 
                             LEFT JOIN medicalinfo b 
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
      'type1'=>$row['type1'],
      'classification1'=>$row['classification1'],
      'status1'=>$row['status1'],
      'dateofexam1'=>$row['dateofexam1'],
      'remarks1'=>$row['remarks1'],
      'type2'=>$row['type2'],
      'classification2'=>$row['classification2'],
      'status2'=>$row['status2'],
      'dateofexam2'=>$row['dateofexam2'],
      'remarks2'=>$row['remarks2'],
      'type3'=>$row['type3'],
      'classification3'=>$row['classification3'],
      'status3'=>$row['status3'],
      'dateofexam3'=>$row['dateofexam3'],
      'remarks3'=>$row['remarks3'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department']

    ));
  }

  function editmedical(){

      $emp_no = $_POST['emp_no'];
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $m_name = $_POST['m_name'];
      $rank = $_POST['rank'];
      $statuss = $_POST['statuss'];
      $emp_statuss = $_POST['emp_statuss'];
      $company = $_POST['company'];

      $empid = $_POST['emp_id'];
      $type1 = $_POST['type1'];
      $classification1 = $_POST['classification1'];
      $status1 = $_POST['status1'];
      $dateofexam1 = $_POST['dateofexam1'] != '' ? $_POST['dateofexam1'] : '0000-00-00';
      $remarks1 = $_POST['remarks1'];
      $type2 = $_POST['type2'];
      $classification2 = $_POST['classification2'];
      $status2 = $_POST['status2'];
      $dateofexam2 = $_POST['dateofexam2'] != '' ? $_POST['dateofexam2'] : '0000-00-00';
      $remarks2 = $_POST['remarks2'];
      $type3 = $_POST['type3'];
      $classification3 = $_POST['classification3'];
      $status3 = $_POST['status3'];
      $dateofexam3 = $_POST['dateofexam3'] != '' ? $_POST['dateofexam3'] : '0000-00-00';
      $remarks3 = $_POST['remarks3'];
      $leave_balance = $_POST['leave_balance'];
      $department = $_POST['department'];

      $conn = $this->connect_mysql();

      $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE id='$empid'");
      $qry1->execute();

      $qry = $conn->prepare("UPDATE medicalinfo SET type1='$type1', classification1='$classification1', status1='$status1', dateofexam1='$dateofexam1', remarks1='$remarks1', type2='$type2', classification2='$classification2', status2='$status2', dateofexam2='$dateofexam2', remarks2='$remarks2', type3='$type3', classification3='$classification3', status3='$status3', dateofexam3='$dateofexam3', remarks3='$remarks3' WHERE emp_id='$empid'");
      $qry->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the medical info of Employee no".$emp_no;
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
if(isset($_GET['selectmedical'])){
  $x->selectmedical();
}
if(isset($_GET['editmedical'])){
  $x->editmedical();
}

 ?>
