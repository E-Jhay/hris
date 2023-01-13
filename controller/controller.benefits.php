<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function selectbenefit(){
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,a.employeeno as emp_no,b.* FROM tbl_employee a 
                             LEFT JOIN benefitsinfo b 
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
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department']
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

      // $empid = $_POST['emp_id'];
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
      $sql = $conn->prepare("SELECT employeeno FROM benefitsinfo WHERE employeeno = '$emp_no'");
      $sql->execute();

      $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE employeeno = '$emp_no'");
      $qry1->execute();

      if($sql->fetch()) {
        $qry = $conn->prepare("UPDATE benefitsinfo SET dependent1='$dependent1', age1='$age1', sex1='$sex1', dependent2='$dependent2', age2='$age2', sex2='$sex2', dependent3='$dependent3', age3='$age3', sex3='$sex3', dependent4='$dependent4', age4='$age4', sex4='$sex4', dependent5='$dependent5', age5='$age5', sex5='$sex5',relation1='$relation1',relation2='$relation2',relation3='$relation3',relation4='$relation4',relation5='$relation5' WHERE employeeno = '$emp_no'");
        $qry->execute();
      } else {
        $qry = $conn->prepare("INSERT INTO benefitsinfo SET dependent1='$dependent1', age1='$age1', sex1='$sex1', dependent2='$dependent2', age2='$age2', sex2='$sex2', dependent3='$dependent3', age3='$age3', sex3='$sex3', dependent4='$dependent4', age4='$age4', sex4='$sex4', dependent5='$dependent5', age5='$age5', sex5='$sex5',relation1='$relation1',relation2='$relation2',relation3='$relation3',relation4='$relation4',relation5='$relation5', employeeno = '$emp_no'");
        $qry->execute();
      }

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the benefits info of Employee no".$emp_no;
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

  function addDependent(){

    $employeeno = $_POST['employeeno'];
    $name_of_dependent = $_POST['name_of_dependent'];
    $gender_of_dependent = $_POST['gender_of_dependent'];
    $age_of_dependent = $_POST['age_of_dependent'];
    $relation = $_POST['relation'];
    // $dateNow = date('Y-m-d');

    if (($_FILES['file']['name']!="")){
      // Where the file is going to be stored
      $target_dir = "../dependents/".$employeeno."/";
      $file = $_FILES['file']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $attachfile = $filename.date('Y-m-d-His').".".$ext;
      $temp_name = $_FILES['file']['tmp_name'];
      $path_filename_ext = $target_dir.$attachfile;

      // Check if file already exists
      if (file_exists($path_filename_ext)) {
        echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employeeno));
        exit;
      }else{
        if(!is_dir("../dependents/".$employeeno."/")){
          mkdir("../dependents/".$employeeno."/");
        }

          if(move_uploaded_file($temp_name,$path_filename_ext)){

            $conn = $this->connect_mysql();

            $qry = $conn->prepare("INSERT INTO benefitsinfo (employeeno, name, gender, age, birth_certificate, relation) VALUES ('$employeeno', '$name_of_dependent', '$gender_of_dependent', '$age_of_dependent', '$attachfile', '$relation')");
            $qry->execute();

            session_start();
            $useraction = $_SESSION['fullname'];
            $dateaction = date('Y-m-d');
            $auditaction = "Added new Dependent for Employee no ".$employeeno;
            $audittype = "Add";
            $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
            $q->execute();

            echo json_encode(array('message' => 'Dependent Submitted Successfully', 'type' => 'success'));
            exit;
          }
      }
    }
    else {
        echo json_encode(array('message' => 'Dependent Birth Certificate is Required', 'type' => 'error'));
        exit;
    }

  }

  function load_dependent(){
    
    $employee_number = $_GET['employeeno'];
    $type = $_GET['type'];
    
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM benefitsinfo WHERE employeeno = '$employee_number' ORDER BY name ASC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
    foreach ($row as $x){

      foreach ($x as $key => $input_arr) {
        $x[$key] = addslashes($input_arr);
        $x[$key] = utf8_encode($input_arr);
      }
      $data = array();
      if($type == "hr"){
        $data['action'] = '<div class="text-center">
        <button title="Edit" style="background-color: green; color: white" onclick="editDependent('.$x['id'].',\''.$x['name'].'\',\''.$x['gender'].'\',\''.$x['age'].'\',\''.$x['birth_certificate'].'\',\''.$x['relation'].'\')" class="btn btn-sm"><i class="fas fa-sm fa-eye"></i>  Edit</button> 
        <button title="Delete" onclick="deleteDependent('.$x['id'].',\''.$x['birth_certificate'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button>
        </div>'
        ;
      } else {
        $data['action'] = '<div class="text-center">
        <button disabled title="Edit" style="background-color: green; color: white" onclick="editDependent('.$x['id'].',\''.$x['name'].'\',\''.$x['gender'].'\',\''.$x['age'].'\',\''.$x['birth_certificate'].'\',\''.$x['relation'].'\')" class="btn btn-sm"><i class="fas fa-sm fa-eye"></i>  Edit</button> 
        <button disabled title="Delete" onclick="deleteDependent('.$x['id'].',\''.$x['birth_certificate'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button>
        </div>'
        ;
      }
      $data['employeeno'] = $x['employeeno'];
      $data['name'] = ucfirst($x['name']);
      $data['gender'] = ucfirst($x['gender']);
      $data['age'] = $x['age'];
      $data['relation'] = ucfirst($x['relation']);
      $data['birth_certificate'] = '<div class="text-center">
          <button title="View Birth Certificate" onclick="viewFile(\''.$x['birth_certificate'].'\',\''.$x['employeeno'].'\')" class="btn btn-primary btn-sm"><i class="fas fa-sm fa-eye"></i> Birth Certificate</button>
          </div>';
      $return[] = $data;
    }
    
    echo json_encode(array('data'=>$return));
  }

  function deleteDependent() {
    $id = $_POST['id'];
    $birth_certificate = $_POST['birth_certificate'];
    $employeeno = $_POST['employeeno'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("DELETE FROM benefitsinfo WHERE id='$id'");
    $query->execute();

    $link_file = "../dependents/".$employeeno."/".$birth_certificate;
    unlink($link_file);
  }

  function updateDependent() {
    $id = $_POST['dependent_id'];
    $employee_number = $_POST['dependent_employee_number'];
    $name = $_POST['dependent_name'];
    $gender = $_POST['dependent_gender'];
    $relation = $_POST['dependent_relation'];
    $age = $_POST['dependent_age'];
    $currentFile = $_POST['dependent_birth_certificate'];
    $dateNow = date('Y-m-d');

    $conn = $this->connect_mysql();
    if($_FILES['dependent_file']['size'] > 0) {
      // Where the file is going to be stored
      $target_dir = "../dependents/".$employee_number."/";
      $file = $_FILES['dependent_file']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $attachfile = $filename.date('Y-m-d-His').".".$ext;
      $temp_name = $_FILES['dependent_file']['tmp_name'];
      $path_filename_ext = $target_dir.$attachfile;

      // Check if file already exists
      if (file_exists($path_filename_ext)) {
        echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employee_number));
        exit;
      }else{
        if(!is_dir("../dependents/".$employee_number."/")){
          mkdir("../dependents/".$employee_number."/");
        }

          if(move_uploaded_file($temp_name,$path_filename_ext)){
            if($currentFile != '' || $currentFile != NULL){
              $link_file = $target_dir.$currentFile;
              if(file_exists($link_file))
              unlink($link_file);
            }

            $conn = $this->connect_mysql();

            $qry = $conn->prepare("UPDATE benefitsinfo SET name='$name', gender='$gender', age='$age', relation='$relation', birth_certificate='$attachfile' WHERE id='$id'");
            $qry->execute();

            session_start();
            $useraction = $_SESSION['fullname'];
            $dateaction = date('Y-m-d');
            $auditaction = "Update the Dependents info of Employee no ".$employee_number;
            $audittype = "EDIT";
            $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
            $q->execute();

            echo json_encode(array('message' => 'Dependent Updated Successfully', 'type' => 'success'));
            exit;
          }
      }
    }
    else {
      $query = $conn->prepare("UPDATE benefitsinfo SET name='$name', gender='$gender', age='$age', relation='$relation' WHERE id='$id'");
      $query->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the Dependents ifo of Employee no ".$employee_number;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
      echo json_encode(array("message"=>"Dependent Updated Successfully", "type" => "success", "employeeno" => $employee_number));
      exit;
    }
  }



}

$x = new crud();

if(isset($_GET['selectbenefit'])){
  $x->selectbenefit();
}
if(isset($_GET['editbenefits'])){
  $x->editbenefits();
}
if(isset($_GET['addDependent'])){
  $x->addDependent();
}
if(isset($_GET['load_dependent'])){
  $x->load_dependent();
}
if(isset($_GET['deleteDependent'])){
  $x->deleteDependent();
}
if(isset($_GET['updateDependent'])){
  $x->updateDependent();
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
