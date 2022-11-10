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

  function selectcontact(){
    $emp_id = $_POST['emp_id'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,b.* FROM tbl_employee a 
                             LEFT JOIN contactinfo b 
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
      'street'=>$row['street'],
      'municipality'=>$row['municipality'],
      'province'=>$row['province'],
      'contactno'=>$row['contactno'],
      'telephoneno'=>$row['telephoneno'],
      'corp_email'=>$row['corp_email'],
      'personal_email'=>$row['personal_email'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'nationality'=>$row['nationality'],
      'driver_license'=>$row['driver_license'],
      'driver_expdate'=>$row['driver_expdate'],
      'department'=>$row['department'],
      'dept_head_email'=>$row['dept_head_email']
    ));
  }

  function editcontactemp(){

    $emp_no = $_POST['emp_no'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $m_name = $_POST['m_name'];
    $rank = $_POST['rank'];
    $statuss = $_POST['statuss'];
    $emp_statuss = $_POST['emp_statuss'];
    $company = $_POST['company'];

    $empid = $_POST['emp_id'];
    $street = $_POST['street'];
    $municipality = $_POST['municipality'];
    $province = $_POST['province'];
    $contactno = $_POST['contactno'];
    $telephoneno = $_POST['telephoneno'];
    $corp_email = $_POST['corp_email'];
    $personal_email = $_POST['personal_email'];
    $leave_balance = $_POST['leave_balance'];
    $nationality = $_POST['nationality'];
    $driver_license = $_POST['driver_license'];
    $driver_expdate = $_POST['driver_expdate'];
    $department = $_POST['department'];
    $dept_head_email = $_POST['dept_head_email'];

    $conn = $this->connect_mysql();

    $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE id='$empid'");
    $qry1->execute();

    $qry = $conn->prepare("UPDATE contactinfo SET street='$street', municipality='$municipality', province='$province', contactno='$contactno', telephoneno='$telephoneno', corp_email='$corp_email', personal_email='$personal_email',nationality='$nationality',driver_license='$driver_license',driver_expdate='$driver_expdate',dept_head_email='$dept_head_email' WHERE emp_id='$empid'");
    $qry->execute();


    session_start();
    $useraction = $_SESSION['fullname'];
    $dateaction = date('Y-m-d');
    $auditaction = "Update the contact info of Employee no".$emp_no;
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
if(isset($_GET['selectcontact'])){
  $x->selectcontact();
}
if(isset($_GET['editcontactemp'])){
  $x->editcontactemp();
}

?>
