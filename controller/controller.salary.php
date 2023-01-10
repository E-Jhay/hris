<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function selectotherid(){
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,a.employeeno as emp_no,c.date_hired FROM tbl_employee a
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
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department'],
      'job_title'=>$row['job_title'],
      'date_hired'=>$row['date_hired'],

    ));
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

  function d_jobtitle(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM job_titles ORDER BY job_title ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Job title--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['job_title'].'">'.$row['job_title'].'</option>';}
      echo $option;
  }

  function savesalary(){
    $action = $_POST['action'];

    $idsalary = $_POST['idsalary'];
    // $idemp = $_POST['idemp'];
    $employeeno = $_POST['employeenoModal'];
    $positionemp = $_POST['positionemp'];
    $statusemp = $_POST['statusemp'];
    $datehiredemp = $_POST['datehiredemp'];
    $salarytype = $_POST['salarytype'];
    $salaryemp = $_POST['salaryemp'] != '' ? $_POST['salaryemp'] : '0';
    $salarytype2 = $_POST['salarytype2'];
    $salaryemp2 = $_POST['salaryemp2']  != '' ? $_POST['salaryemp2'] : '0';
    $salarytype3 = $_POST['salarytype3'];
    $salaryemp3 = $_POST['salaryemp3']  != '' ? $_POST['salaryemp3'] : '0';
    $salarytype4 = $_POST['salarytype4'];
    $salaryemp4 = $_POST['salaryemp4']  != '' ? $_POST['salaryemp4'] : '0';
    $effectdateemp = $_POST['effectdateemp'];
    $basic_salary = $_POST['basic_salary'];
    $remarks = $_POST['remarks'];
    $prev_file_name = $_POST['file_name'];
    if($action == 'insert') {
      if (($_FILES['hardcopy']['name']!="")){

        // Where the file is going to be stored
        $target_dir = "../salary_adjustment/".$employeeno."/";
        $file = $_FILES['hardcopy']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $attachfile = $filename.date('Y-m-d-His').".".$ext;
        $temp_name = $_FILES['hardcopy']['tmp_name'];
        $path_filename_ext = $target_dir.$attachfile;


        // Check if file already exists
        if (file_exists($path_filename_ext)) {
          echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employeeno));
          exit;
        }else{
          if(!is_dir("../salary_adjustment/".$employeeno."/")){
            mkdir("../salary_adjustment/".$employeeno."/");
          }

            if(move_uploaded_file($temp_name,$path_filename_ext)){

              $conn = $this->connect_mysql();

              $squery = $conn->prepare("INSERT INTO salary_history SET date_hired='$datehiredemp',salary_type='$salarytype', salary_rate='$salaryemp',salary_type2='$salarytype2', salary_rate2='$salaryemp2',salary_type3='$salarytype3', salary_rate3='$salaryemp3',salary_type4='$salarytype4', salary_rate4='$salaryemp4', effective_date='$effectdateemp', added_by='Administrator', job_title='$positionemp', employment_status='$statusemp',basic_salary='$basic_salary',remarks='$remarks', hardcopy='$attachfile', employeeno='$employeeno'");
              $squery->execute();

              $qry = $conn->prepare("UPDATE tbl_employee SET employment_status='$statusemp',job_title='$positionemp' WHERE employeeno = '$employeeno'");
              $qry->execute();

              // $query = $conn->prepare("SELECT employeeno FROM tbl_employee WHERE employeeno => '$employeeno'");
              // $query->execute();
              // $row = $query->fetch();

              session_start();
              $useraction = $_SESSION['fullname'];
              $dateaction = date('Y-m-d');
              $auditaction = "Added new salary for Employee no ".$employeeno;
              $audittype = "Add";
              $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
              $q->execute();

              echo json_encode(array("message"=>"Salary Adjustment Added Successfully", "type" => "success", "employeeno" => $employeeno));
              exit;
            }
        }
      }
      else {
        echo json_encode(array("message"=>"Hard Copy is required", "type" => "error", "employeeno" => $employeeno));
        exit;
      }
    }
    else {
      $conn = $this->connect_mysql();
      if($_FILES['hardcopy']['size'] > 0) {

        // Where the file is going to be stored
        $target_dir = "../salary_adjustment/".$employeeno."/";
        $file = $_FILES['hardcopy']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $attachfile = $filename.date('Y-m-d-His').".".$ext;
        $temp_name = $_FILES['hardcopy']['tmp_name'];
        $path_filename_ext = $target_dir.$attachfile;


        // Check if file already exists
        if (file_exists($path_filename_ext)) {
          echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employeeno));
          exit;
        }
        else{
          if(!is_dir("../salary_adjustment/".$employeeno."/")){
            mkdir("../salary_adjustment/".$employeeno."/");
          }

          if(move_uploaded_file($temp_name,$path_filename_ext)){
            $link_file = "../salary_adjustment/".$employeeno.'/'.$prev_file_name;
            unlink($link_file);

            $squery = $conn->prepare("UPDATE salary_history SET date_hired='$datehiredemp', salary_type='$salarytype', salary_rate='$salaryemp',salary_type2='$salarytype2', salary_rate2='$salaryemp2',salary_type3='$salarytype3', salary_rate3='$salaryemp3',salary_type4='$salarytype4', salary_rate4='$salaryemp4', effective_date='$effectdateemp', job_title='$positionemp', employment_status='$statusemp',basic_salary='$basic_salary',remarks='$remarks', hardcopy='$attachfile' WHERE id = '$idsalary'");
            $squery->execute();

            $qry = $conn->prepare("UPDATE tbl_employee SET employment_status='$statusemp',job_title='$positionemp' WHERE employeeno='$employeeno'");
            $qry->execute();

            session_start();
            $useraction = $_SESSION['fullname'];
            $dateaction = date('Y-m-d');
            $auditaction = "Update  the salary of Employee no ".$employeeno;
            $audittype = "EDIT";
            $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
            $q->execute();

            echo json_encode(array("message"=>"Salary Adjustment Updated Successfully", "type" => "success", "employeeno" => $employeeno));
            exit;
          }
          else {
            echo json_encode(array("message"=>"Hard Copy is required", "type" => "error", "employeeno" => $employeeno));
            exit;
          }
        }
      }
      else {
        $query = $conn->prepare("UPDATE salary_history SET date_hired='$datehiredemp', salary_type='$salarytype', salary_rate='$salaryemp',salary_type2='$salarytype2', salary_rate2='$salaryemp2',salary_type3='$salarytype3', salary_rate3='$salaryemp3',salary_type4='$salarytype4', salary_rate4='$salaryemp4', effective_date='$effectdateemp', job_title='$positionemp', employment_status='$statusemp',basic_salary='$basic_salary',remarks='$remarks' WHERE id = '$idsalary'");
        $query->execute();
        
        $qry = $conn->prepare("UPDATE tbl_employee SET employment_status='$statusemp',job_title='$positionemp' WHERE employeeno='$employeeno'");

        session_start();
        $useraction = $_SESSION['fullname'];
        $dateaction = date('Y-m-d');
        $auditaction = "Update  the salary of Employee no ".$employeeno;
        $audittype = "EDIT";
        $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
        $q->execute();
        echo json_encode(array("message"=>"Salary Adjustment Updated Successfully", "type" => "success", "employeeno" => $employeeno));
        exit;
      }
    }
      
      // $idemp = $_POST['idemp'];
      // $positionemp = $_POST['positionemp'];
      // $statusemp = $_POST['statusemp'];
      // $datehiredemp = $_POST['datehiredemp'];
      // $salarytype = $_POST['salarytype'];
      // $salaryemp = $_POST['salaryemp'] != '' ? $_POST['salaryemp'] : '0';
      // $salarytype2 = $_POST['salarytype2'];
      // $salaryemp2 = $_POST['salaryemp2']  != '' ? $_POST['salaryemp2'] : '0';
      // $salarytype3 = $_POST['salarytype3'];
      // $salaryemp3 = $_POST['salaryemp3']  != '' ? $_POST['salaryemp3'] : '0';
      // $salarytype4 = $_POST['salarytype4'];
      // $salaryemp4 = $_POST['salaryemp4']  != '' ? $_POST['salaryemp4'] : '0';
      // $effectdateemp = $_POST['effectdateemp'];
      // $basic_salary = $_POST['basic_salary'];
      // $remarks = $_POST['remarks'];

      // $conn = $this->connect_mysql();

      // $squery = $conn->prepare("INSERT INTO salary_history SET emp_id='$idemp', date_hired='$datehiredemp',salary_type='$salarytype', salary_rate='$salaryemp',salary_type2='$salarytype2', salary_rate2='$salaryemp2',salary_type3='$salarytype3', salary_rate3='$salaryemp3',salary_type4='$salarytype4', salary_rate4='$salaryemp4', effective_date='$effectdateemp', added_by='Administrator', job_title='$positionemp', employment_status='$statusemp',basic_salary='$basic_salary',remarks='$remarks'");
      // $squery->execute();

      // $qry = $conn->prepare("UPDATE tbl_employee SET employment_status='$statusemp',job_title='$positionemp' WHERE id='$idemp'");
      // $qry->execute();

      // $query = $conn->prepare("SELECT employeeno FROM tbl_employee WHERE id='$idemp'");
      // $query->execute();
      // $row = $query->fetch();
      // $employeeno = $row['employeeno'];

      // session_start();
      // $useraction = $_SESSION['fullname'];
      // $dateaction = date('Y-m-d');
      // $auditaction = "Added new salary for Employee no ".$employeeno;
      // $audittype = "Add";
      // $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      // $q->execute();

      // echo json_encode(array("employeeno"=>$employeeno));

  }

  // function updatesalaryhisto(){

  //     $id = $_POST['id'];
  //     $idemp = $_POST['idemp'];
  //     $job_title = $_POST['job_title'];
  //     $employment_status = $_POST['employment_status'];
  //     $date_hired = $_POST['date_hired'];
  //     $salarytype = $_POST['salarytype'];
  //     $salaryemp = $_POST['salaryemp'];
  //     $salarytype2 = $_POST['salarytype2'];
  //     $salaryemp2 = $_POST['salaryemp2'];
  //     $salarytype3 = $_POST['salarytype3'];
  //     $salaryemp3 = $_POST['salaryemp3'];
  //     $salarytype4 = $_POST['salarytype4'];
  //     $salaryemp4 = $_POST['salaryemp4'];
  //     $effective_date = $_POST['effective_date'];
  //     $basic_salary = $_POST['basic_salary'];
  //     $remarks = $_POST['remarks'];

  //     $conn = $this->connect_mysql();

  //     $query = $conn->prepare("UPDATE salary_history SET date_hired='$date_hired', salary_type='$salarytype', salary_rate='$salaryemp',salary_type2='$salarytype2', salary_rate2='$salaryemp2',salary_type3='$salarytype3', salary_rate3='$salaryemp3',salary_type4='$salarytype4', salary_rate4='$salaryemp4', effective_date='$effective_date', job_title='$job_title', employment_status='$employment_status',basic_salary='$basic_salary',remarks='$remarks' WHERE id='$id'");
  //     $query->execute();

  //     $query = $conn->prepare("SELECT employeeno FROM tbl_employee WHERE id='$idemp'");
  //     $query->execute();
  //     $row = $query->fetch();
  //     $employeeno = $row['employeeno'];

  //     session_start();
  //     $useraction = $_SESSION['fullname'];
  //     $dateaction = date('Y-m-d');
  //     $auditaction = "Update  the salary of Employee no ".$employeeno;
  //     $audittype = "EDIT";
  //     $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
  //     $q->execute();

  //     echo json_encode(array("employeeno"=>$employeeno));

  // }

  function loadsalary_history(){

    $employeeno = $_GET['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.id,a.employeeno,b.id as idd,b.*
                             FROM tbl_employee a RIGHT JOIN salary_history b ON a.employeeno=b.employeeno WHERE a.employeeno='$employeeno' ORDER BY b.id DESC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $data['action'] = '<center>
          <button title="Edit" onclick="edit_salaryhistory('.$x['idd'].',\''.$x['job_title'].'\',\''.$x['employment_status'].'\',\''.$x['date_hired'].'\',\''.$x['salary_type'].'\',\''.$x['salary_rate'].'\',\''.$x['salary_type2'].'\',\''.$x['salary_rate2'].'\',\''.$x['salary_type3'].'\',\''.$x['salary_rate3'].'\',\''.$x['salary_type4'].'\',\''.$x['salary_rate4'].'\',\''.$x['effective_date'].'\',\''.$x['remarks'].'\',\''.$x['basic_salary'].'\',\''.$x['hardcopy'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-edit"></i></button>
          <button title="View Hardcopy" onclick="viewHardcopy(\''.$x['hardcopy'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-primary"><i class="fas fa-sm fa-eye"></i></button>
          <button title="Delete" onclick="delete_salaryhistory('.$x['idd'].',\''.$x['employeeno'].'\',\''.$x['hardcopy'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button>
          
          </center>
          ';
          
        

          // $data['job_title'] = $x['job_title'];
          // $data['employment_status'] = $x['employment_status'];
          $data['basic_salary'] = $x['basic_salary'];
          // $data['date_hired'] = $x['date_hired'];
          $data['salary_type'] = $x['salary_type'];
          $data['salary_rate'] = $x['salary_rate'];
          $data['salary_type2'] = $x['salary_type2'];
          $data['salary_rate2'] = $x['salary_rate2'];
          $data['salary_type3'] = $x['salary_type3'];
          $data['salary_rate3'] = $x['salary_rate3'];
          $data['salary_type4'] = $x['salary_type4'];
          $data['salary_rate4'] = $x['salary_rate4'];
          $data['effective_date'] = $x['effective_date'];

        $return[] = $data; 
      }
    
    echo json_encode(array('data'=>$return));
  }

  function delete_salaryhistory(){

    $id = $_POST['id'];
    $hardcopy = $_POST['hardcopy'];
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("DELETE FROM salary_history WHERE id='$id'");
    $query->execute();
    if($hardcopy != '' || $hardcopy != NULL) {
      $link_file = "../salary_adjustment/".$employeeno."/".$hardcopy;
      unlink($link_file);
    }

  }

}

$x = new crud();

if(isset($_GET['delete_salaryhistory'])){
  $x->delete_salaryhistory();
}

if(isset($_GET['loadsalary_history'])){
  $x->loadsalary_history();
}

if(isset($_GET['updatesalaryhisto'])){
  $x->updatesalaryhisto();
}

if(isset($_GET['savesalary'])){
  $x->savesalary();
}

if(isset($_GET['selectotherid'])){
  $x->selectotherid();
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
if(isset($_GET['d_jobtitle'])){
  $x->d_jobtitle();
}

 ?>
