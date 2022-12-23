<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

// jerico
  function selectotherid(){
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,a.employeeno as emp_no,b.*,c.date_hired FROM tbl_employee a 
                             LEFT JOIN otheridinfo b 
                             ON a.employeeno = b.employeeno
                             LEFT JOIN contractinfo c
                             ON a.employeeno = c.employeeno
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
      'comp_id_dateissue'=>$row['comp_id_dateissue'],
      'comp_id_vdate'=>$row['comp_id_vdate'],
      'fac_ap_dateissue'=>$row['fac_ap_dateissue'],
      'fac_ap_vdate'=>$row['fac_ap_vdate'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department'],
      'job_title'=>$row['job_title'],
      'date_hired'=>$row['date_hired'],
      'card_number'=>$row['card_number'],
      'driver_id'=>$row['driver_id'],
      'driver_exp'=>$row['driver_exp'],
      'prc_number'=>$row['prc_number'],
      'prc_exp'=>$row['prc_exp'],
      'civil_service'=>$row['civil_service']

    ));
  }
// jerico
  function editotherid(){

      $emp_no = $_POST['emp_no'];
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $m_name = $_POST['m_name'];
      $rank = $_POST['rank'];
      $statuss = $_POST['statuss'];
      $emp_statuss = $_POST['emp_statuss'];
      $company = $_POST['company'];

      // $empid = $_POST['emp_id'];
      $comp_id_dateissue = $_POST['comp_id_dateissue'] != '' ? $_POST['comp_id_dateissue'] : '0000-00-00';
      $comp_id_vdate = $_POST['comp_id_vdate'] != '' ? $_POST['comp_id_vdate'] : '0000-00-00';
      $fac_ap_dateissue = $_POST['fac_ap_dateissue']  != '' ? $_POST['fac_ap_dateissue'] : '0000-00-00';
      $fac_ap_vdate = $_POST['fac_ap_vdate'] != '' ? $_POST['fac_ap_vdate'] : '0000-00-00';
      $leave_balance = $_POST['leave_balance'];
      $department = $_POST['department'];
      $fac_card_number = $_POST['fac_card_number'];
      $driver_id = $_POST['driver_id'];
      $driver_exp = $_POST['driver_exp'] != '' ? $_POST['driver_exp'] : '0000-00-00';
      $prc_number = $_POST['prc_number'];
      $prc_exp = $_POST['prc_exp'] != '' ? $_POST['prc_exp'] : '0000-00-00';
      $civil_service = $_POST['civil_service'];

      $conn = $this->connect_mysql();
      $sql = $conn->prepare("SELECT employeeno FROM otheridinfo WHERE employeeno = '$emp_no'");
      $sql->execute();

      $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE employeeno = '$emp_no'");
      $qry1->execute();

      if($sql->fetch()) {
        $qry = $conn->prepare("UPDATE otheridinfo SET comp_id_dateissue='$comp_id_dateissue', comp_id_vdate='$comp_id_vdate', fac_ap_dateissue='$fac_ap_dateissue', fac_ap_vdate='$fac_ap_vdate', card_number='$fac_card_number',driver_id='$driver_id',driver_exp='$driver_exp',prc_number='$prc_number',prc_exp='$prc_exp',civil_service='$civil_service' WHERE employeeno = '$emp_no'");
        $qry->execute();
      } else {
        $qry = $conn->prepare("INSERT INTO otheridinfo SET comp_id_dateissue='$comp_id_dateissue', comp_id_vdate='$comp_id_vdate', fac_ap_dateissue='$fac_ap_dateissue', fac_ap_vdate='$fac_ap_vdate', card_number='$fac_card_number',driver_id='$driver_id',driver_exp='$driver_exp',prc_number='$prc_number',prc_exp='$prc_exp',civil_service='$civil_service', employeeno = '$emp_no'");
        $qry->execute();
      }

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the other id info of Employee no".$emp_no;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

      echo json_encode(array("employeeno"=>$emp_no));

  }

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
  
}

$x = new crud();

if(isset($_GET['selectotherid'])){
  $x->selectotherid();
}
if(isset($_GET['editotherid'])){
  $x->editotherid();
}
if(isset($_GET['demp_stat'])){
  $x->demp_stat();
}
if(isset($_GET['dcompany'])){
  $x->dcompany();
}
if(isset($_GET['ddepartment'])){
  $x->ddepartment();
}

 ?>
