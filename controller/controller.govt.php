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

  function selectgovt(){
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,a.employeeno as emp_no,b.* FROM tbl_employee a 
                             LEFT JOIN govtidinfo b 
                             ON a.employeeno = b.employeeno
                             WHERE a.employeeno='$employeeno'");
    $query->execute();
    $row = $query->fetch();
    foreach ($row as $key => $input_arr) {
      $row[$key] = addslashes($input_arr);
      $row[$key] = utf8_encode($input_arr);
    }
    
    if($row['imagepic'] == NULL || $row['imagepic'] == ''){
      $row['imagepic'] = 'personal_picture/usera.png';
    } else {
        if(!file_exists('../personal_picture/'.$row['emp_no'].'/'.$row['imagepic'])){
          $row['imagepic'] = 'personal_picture/'.$row['imagepic'];
        } else {
          $row['imagepic'] = 'personal_picture/'.$row['emp_no'].'/'.$row['imagepic'];
        }
    }
    echo json_encode(array(
      'emp_no'=>$row['emp_no'],
      'f_name'=>$row['firstname'],
      'l_name'=>utf8_decode($row['lastname']),
      'm_name'=>$row['middlename'],
      'rank'=>$row['rank'],
      'statuss'=>$row['statuss'],
      'emp_statuss'=>$row['employment_status'],
      'company'=>$row['company'],
      'tin_no'=>$row['tin_no'],
      'sss_no'=>$row['sss_no'],
      'phic_no'=>$row['phic_no'],
      'hdmf_no'=>$row['hdmf_no'],
      'atm_no'=>$row['atm_no'],
      'bank_name'=>$row['bank_name'],
      'sss_remarks'=>$row['sss_remarks'],
      'phic_remarks'=>$row['phic_remarks'],
      'hdmf_remarks'=>$row['hdmf_remarks'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department']
    ));
  }

  function editgovtid(){

      $emp_no = $_POST['emp_no'];
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $m_name = $_POST['m_name'];
      $rank = $_POST['rank'];
      $statuss = $_POST['statuss'];
      $emp_statuss = $_POST['emp_statuss'];
      $company = $_POST['company'];

      // $empid = $_POST['emp_id'];
      $tin_no = $_POST['tin_no'];
      $sss_no = $_POST['sss_no'];
      $phic_no = $_POST['phic_no'];
      $hdmf_no = $_POST['hdmf_no'];
      $atm_no = $_POST['atm_no'];
      $bank_name = $_POST['bank_name'];
      $sss_remarks = $_POST['sss_remarks'];
      $phic_remarks = $_POST['phic_remarks'];
      $hdmf_remarks = $_POST['hdmf_remarks'];
      $leave_balance = $_POST['leave_balance'];
      $department = $_POST['department'];

      $conn = $this->connect_mysql();
      $sql = $conn->prepare("SELECT employeeno FROM govtidinfo WHERE employeeno = '$emp_no'");
      $sql->execute();

      $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE employeeno = '$emp_no'");
      $qry1->execute();

      if($sql->fetch()) {
        $qry = $conn->prepare("UPDATE govtidinfo SET tin_no='$tin_no', sss_no='$sss_no', phic_no='$phic_no', hdmf_no='$hdmf_no', atm_no='$atm_no', bank_name='$bank_name', sss_remarks='$sss_remarks', phic_remarks='$phic_remarks', hdmf_remarks='$hdmf_remarks' WHERE employeeno = '$emp_no'");
        $qry->execute();
      } else {
        $qry = $conn->prepare("INSERT INTO govtidinfo SET tin_no='$tin_no', sss_no='$sss_no', phic_no='$phic_no', hdmf_no='$hdmf_no', atm_no='$atm_no', bank_name='$bank_name', sss_remarks='$sss_remarks', phic_remarks='$phic_remarks', hdmf_remarks='$hdmf_remarks', employeeno = '$emp_no'");
        $qry->execute();
      }
      // $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE id='$empid'");
      //   $qry1->execute();

      //   $qry = $conn->prepare("UPDATE govtidinfo SET tin_no='$tin_no', sss_no='$sss_no', phic_no='$phic_no', hdmf_no='$hdmf_no', atm_no='$atm_no', bank_name='$bank_name', sss_remarks='$sss_remarks', phic_remarks='$phic_remarks', hdmf_remarks='$hdmf_remarks' WHERE emp_id='$empid'");
      //   $qry->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the Govt ids/atm info of Employee no".$emp_no;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

      echo json_encode(array("employeeno"=>$emp_no));

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
if(isset($_GET['selectgovt'])){
  $x->selectgovt();
}
if(isset($_GET['editgovtid'])){
  $x->editgovtid();
}

?>
