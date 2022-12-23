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

  function d_jobtitle(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM job_titles ORDER BY job_title ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Job title--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['job_title'].'">'.$row['job_title'].'</option>';}
      echo $option;
  }

  function d_jobcategory(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM job_categories ORDER BY job_category ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Job category--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['job_category'].'">'.$row['job_category'].'</option>';}
      echo $option;
  }


  function selectcontract(){
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,a.employeeno as emp_no,b.* FROM tbl_employee a 
                             LEFT JOIN contractinfo b 
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
      'date_hired'=>$row['date_hired'],
      'eoc'=>$row['eoc'],
      'regularized'=>$row['regularized'],
      'preterm'=>$row['preterm'],
      'resigned'=>$row['resigned'],
      'retired'=>$row['retired'],
      'terminated'=>$row['terminatedd'],
      'lastpay'=>$row['lastpay'],
      'remarks'=>$row['remarks'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'job_title'=>$row['job_title'],
      'job_category'=>$row['job_category'],
      'department'=>$row['department']
    ));
  }

  function editcontractemp(){

    $emp_no = $_POST['emp_no'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $m_name = $_POST['m_name'];
    $rank = $_POST['rank'];
    $statuss = $_POST['statuss'];
    $emp_statuss = $_POST['emp_statuss'];
    $company = $_POST['company'];

    // $empid = $_POST['emp_id'];
    $date_hired = $_POST['date_hired'] != '' ? $_POST['date_hired'] : '0000-00-00';
    $eoc = $_POST['eoc'] != '' ? $_POST['eoc'] : '0000-00-00';
    $regularized = $_POST['regularized'] != '' ? $_POST['regularized'] : '0000-00-00';
    $preterm = $_POST['preterm'] != '' ? $_POST['preterm'] : '0000-00-00';
    $resigned = $_POST['resigned'] != '' ? $_POST['resigned'] : '0000-00-00';
    $retired = $_POST['retired'] != '' ? $_POST['retired'] : '0000-00-00';
    $terminated = $_POST['terminated'] != '' ? $_POST['terminated'] : '0000-00-00';
    $lastpay = $_POST['lastpay'] != '' ? $_POST['lastpay'] : '0000-00-00';
    $remarks = $_POST['remarks'];
    $leave_balance = $_POST['leave_balance'];
    $job_title = $_POST['job_title'];
    $job_category = $_POST['job_category'];
    $department = $_POST['department'];

    $conn = $this->connect_mysql();
    $sql = $conn->prepare("SELECT id FROM contractinfo WHERE employeeno='$emp_no'");
    $sql->execute();

    $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',job_title='$job_title', job_category='$job_category',department='$department' WHERE employeeno='$emp_no'");
    $qry1->execute();

    if($sql->fetch()) {
      $qry = $conn->prepare("UPDATE contractinfo SET date_hired='$date_hired', eoc='$eoc', regularized='$regularized', preterm='$preterm', resigned='$resigned', retired='$retired', terminatedd='$terminated', lastpay='$lastpay', remarks='$remarks' WHERE employeeno='$emp_no'");
      $qry->execute();
    } else {
      $qry = $conn->prepare("INSERT INTO contractinfo SET date_hired='$date_hired', eoc='$eoc', regularized='$regularized', preterm='$preterm', resigned='$resigned', retired='$retired', terminatedd='$terminated', lastpay='$lastpay', remarks='$remarks', employeeno='$emp_no'");
      $qry->execute();
    }


    session_start();
    $useraction = $_SESSION['fullname'];
    $dateaction = date('Y-m-d');
    $auditaction = "Update the contract info of Employee no".$emp_no;
    $audittype = "EDIT";
    $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
    $q->execute();

    echo json_encode(array('employeeno' => $emp_no));

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
if(isset($_GET['d_jobtitle'])){
  $x->d_jobtitle();
}
if(isset($_GET['d_jobcategory'])){
  $x->d_jobcategory();
}

if(isset($_GET['selectcontract'])){
  $x->selectcontract();
}
if(isset($_GET['editcontractemp'])){
  $x->editcontractemp();
}

?>
