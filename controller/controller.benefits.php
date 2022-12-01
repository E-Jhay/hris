<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function selectbenefit(){
    $emp_id = $_POST['emp_id'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,b.* FROM tbl_employee a 
                             LEFT JOIN benefitsinfo b 
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
      'dependent1'=>$row['dependent1'],
      'age1'=>$row['age1'],
      'sex1'=>$row['sex1'],
      'dependent2'=>$row['dependent2'],
      'age2'=>$row['age2'],
      'sex2'=>$row['sex2'],
      'dependent3'=>$row['dependent3'],
      'age3'=>$row['age3'],
      'sex3'=>$row['sex3'],
      'dependent4'=>$row['dependent4'],
      'age4'=>$row['age4'],
      'sex4'=>$row['sex4'],
      'dependent5'=>$row['dependent5'],
      'age5'=>$row['age5'],
      'sex5'=>$row['sex5'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department'],
      'relation1'=>$row['relation1'],
      'relation2'=>$row['relation2'],
      'relation3'=>$row['relation3'],
      'relation4'=>$row['relation4'],
      'relation5'=>$row['relation5']
    ));
  }

  function editbenefits(){

      $emp_no = $_POST['emp_no'];
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $m_name = $_POST['m_name'];
      $rank = $_POST['rank'];
      $statuss = $_POST['statuss'];
      $emp_statuss = $_POST['emp_statuss'];
      $company = $_POST['company'];

      $empid = $_POST['emp_id'];
      $dependent1 = $_POST['dependent1'];
      $age1 = $_POST['age1'];
      $sex1 = $_POST['sex1'];
      $dependent2 = $_POST['dependent2'];
      $age2 = $_POST['age2'];
      $sex2 = $_POST['sex2'];
      $dependent3 = $_POST['dependent3'];
      $age3 = $_POST['age3'];
      $sex3 = $_POST['sex3'];
      $dependent4 = $_POST['dependent4'];
      $age4 = $_POST['age4'];
      $sex4 = $_POST['sex4'];
      $dependent5 = $_POST['dependent5'];
      $age5 = $_POST['age5'];
      $sex5 = $_POST['sex5'];
      $leave_balance = $_POST['leave_balance'];
      $department = $_POST['department'];
      $relation1 = $_POST['relation1'];
      $relation2 = $_POST['relation2'];
      $relation3 = $_POST['relation3'];
      $relation4 = $_POST['relation4'];
      $relation5 = $_POST['relation5'];
      

      $conn = $this->connect_mysql();
      $sql = $conn->prepare("SELECT id FROM benefitsinfo WHERE emp_id = '$empid'");
      $sql->execute();

      $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE id='$empid'");
      $qry1->execute();

      if($sql->fetch()) {
        $qry = $conn->prepare("UPDATE benefitsinfo SET dependent1='$dependent1', age1='$age1', sex1='$sex1', dependent2='$dependent2', age2='$age2', sex2='$sex2', dependent3='$dependent3', age3='$age3', sex3='$sex3', dependent4='$dependent4', age4='$age4', sex4='$sex4', dependent5='$dependent5', age5='$age5', sex5='$sex5',relation1='$relation1',relation2='$relation2',relation3='$relation3',relation4='$relation4',relation5='$relation5' WHERE emp_id='$empid'");
        $qry->execute();
      } else {
        $qry = $conn->prepare("INSERT INTO benefitsinfo SET dependent1='$dependent1', age1='$age1', sex1='$sex1', dependent2='$dependent2', age2='$age2', sex2='$sex2', dependent3='$dependent3', age3='$age3', sex3='$sex3', dependent4='$dependent4', age4='$age4', sex4='$sex4', dependent5='$dependent5', age5='$age5', sex5='$sex5',relation1='$relation1',relation2='$relation2',relation3='$relation3',relation4='$relation4',relation5='$relation5', emp_id='$empid'");
        $qry->execute();
      }

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the benefits info of Employee no".$emp_no;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();


      echo json_encode(array("id"=>$empid));

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

if(isset($_GET['selectbenefit'])){
  $x->selectbenefit();
}
if(isset($_GET['editbenefits'])){
  $x->editbenefits();
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
