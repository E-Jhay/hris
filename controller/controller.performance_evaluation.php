<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{
  function load_performance_evaluation(){
    
    $employee_number = $_GET['employeeno'];
    
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM performance_evaluation WHERE employee_no = '$employee_number' ORDER BY created_at DESC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
    foreach ($row as $x){

    foreach ($x as $key => $input_arr) {
    $x[$key] = addslashes($input_arr);
    $x[$key] = utf8_encode($input_arr);
    }
    $data = array();
    $data['action'] = '<div class="text-center">
    <button title="Edit" style="background-color: green; color: white" onclick="editEvaluation('.$x['id'].',\''.$x['title'].'\',\''.$x['description'].'\',\''.$x['file_name'].'\')" class="btn btn-sm"><i class="fas fa-sm fa-eye"></i>  Edit</button> 
    <button title="Delete" onclick="deleteEvaluation('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employee_no'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button>
    </div>'
    ;
    $data['employee_no'] = ucfirst($x['employee_no']);
    $data['title'] = ucfirst($x['title']);
    $data['description'] = strlen($x['description']) > 20 ? ucfirst(substr($x['description'], 0, 20))."..." : ucfirst($x['description']);
    $data['date_created'] = date('F d, Y',strtotime($x['created_at']));
    $data['file'] = '<div class="text-center">
        <button title="View File" onclick="viewFile(\''.$x['file_name'].'\',\''.$x['employee_no'].'\')" class="btn btn-primary btn-sm"><i class="fas fa-sm fa-eye"></i> Hardcopy</button>
        </div>';
    $return[] = $data;
    }
    
    echo json_encode(array('data'=>$return));
  }
  function addPerformanceEvaluation(){

    $employee_number = $_POST['employee_number'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dateNow = date('Y-m-d');

    if (($_FILES['file']['name']!="")){
      // Where the file is going to be stored
      $target_dir = "../performance_evaluation/".$employee_number."/";
      $file = $_FILES['file']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $attachfile = $filename.date('Y-m-d-His').".".$ext;
      $temp_name = $_FILES['file']['tmp_name'];
      $path_filename_ext = $target_dir.$attachfile;

      // Check if file already exists
      if (file_exists($path_filename_ext)) {
        echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employee_number));
        exit;
      }else{
        if(!is_dir("../performance_evaluation/".$employee_number."/")){
          mkdir("../performance_evaluation/".$employee_number."/");
        }

          if(move_uploaded_file($temp_name,$path_filename_ext)){

            $conn = $this->connect_mysql();

            $qry = $conn->prepare("INSERT INTO performance_evaluation (employee_no, title, description, created_at, file_name) VALUES ('$employee_number', '$title', '$description', '$dateNow', '$attachfile')");
            $qry->execute();

            session_start();
            $useraction = $_SESSION['fullname'];
            $dateaction = date('Y-m-d');
            $auditaction = "Added new Evaluation for Employee no ".$employee_number;
            $audittype = "Add";
            $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
            $q->execute();

            echo json_encode(array('message' => 'Performance Evaluation Submitted Successfully', 'type' => 'success'));
            exit;
          }
      }
    }
    else {
        echo json_encode(array('message' => 'Performance Evaluation File is Required', 'type' => 'error'));
        exit;
    }

    // if($action == 'insert') {
    //   if (($_FILES['file']['name']!="")){
    //       // Where the file is going to be stored
    //       $target_dir = "../performance_evaluation/".$employee_number."/";
    //       $file = $_FILES['file']['name'];
    //       $path = pathinfo($file);
    //       $filename = $path['filename'];
    //       $ext = $path['extension'];
    //       $attachfile = $filename.date('Y-m-d-His').".".$ext;
    //       $temp_name = $_FILES['file']['tmp_name'];
    //       $path_filename_ext = $target_dir.$attachfile;
  
    //       // Check if file already exists
    //       if (file_exists($path_filename_ext)) {
    //         echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employee_number));
    //         exit;
    //       }else{
    //         if(!is_dir("../performance_evaluation/".$employee_number."/")){
    //           mkdir("../performance_evaluation/".$employee_number."/");
    //         }
  
    //           if(move_uploaded_file($temp_name,$path_filename_ext)){
  
    //             $conn = $this->connect_mysql();
  
    //             $qry = $conn->prepare("INSERT INTO performance_evaluation (employee_no, title, description, created_at, file_name) VALUES ('$employee_number', '$title', '$description', '$dateNow', '$attachfile')");
    //             $qry->execute();
  
    //             session_start();
    //             $useraction = $_SESSION['fullname'];
    //             $dateaction = date('Y-m-d');
    //             $auditaction = "Added new Evaluation for Employee no ".$employee_number;
    //             $audittype = "Add";
    //             $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
    //             $q->execute();
  
    //             echo json_encode(array('message' => 'Performance Evaluation Submitted Successfully', 'type' => 'success'));
    //             exit;
    //           }
    //       }
    //   }
    //   else {
    //       echo json_encode(array('message' => 'Performance Evaluation File is Required', 'type' => 'error'));
    //       exit;
    //   }
    // }else {
      // $conn = $this->connect_mysql();
      // if($_FILES['file']['size'] > 0) {

      //   // Where the file is going to be stored
      //   $target_dir = "../performance_evaluation/".$employee_number."/";
      //   $file = $_FILES['file']['name'];
      //   $path = pathinfo($file);
      //   $filename = $path['filename'];
      //   $ext = $path['extension'];
      //   $attachfile = $filename.date('Y-m-d-His').".".$ext;
      //   $temp_name = $_FILES['file']['tmp_name'];
      //   $path_filename_ext = $target_dir.$attachfile;


      //   // Check if file already exists
      //   if (file_exists($path_filename_ext)) {
      //     echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employee_number));
      //     exit;
      //   }
      //   else{
      //     if(!is_dir("../performance_evaluation/".$employee_number."/")){
      //       mkdir("../performance_evaluation/".$employee_number."/");
      //     }

      //     if(move_uploaded_file($temp_name,$path_filename_ext)){

      //       $squery = $conn->prepare("UPDATE salary_history SET date_hired='$datehiredemp', salary_type='$salarytype', salary_rate='$salaryemp',salary_type2='$salarytype2', salary_rate2='$salaryemp2',salary_type3='$salarytype3', salary_rate3='$salaryemp3',salary_type4='$salarytype4', salary_rate4='$salaryemp4', effective_date='$effectdateemp', job_title='$positionemp', employment_status='$statusemp',basic_salary='$basic_salary',remarks='$remarks', hardcopy='$attachfile' WHERE id='$id'");
      //       $squery->execute();

      //       $qry = $conn->prepare("UPDATE tbl_employee SET employment_status='$statusemp',job_title='$positionemp' WHERE id='$idemp'");
      //       $qry->execute();

      //       $query = $conn->prepare("SELECT employeeno FROM tbl_employee WHERE id='$idemp'");
      //       $query->execute();
      //       $row = $query->fetch();
      //       $employeeno = $row['employeeno'];

      //       session_start();
      //       $useraction = $_SESSION['fullname'];
      //       $dateaction = date('Y-m-d');
      //       $auditaction = "Update  the salary of Employee no ".$employeeno;
      //       $audittype = "EDIT";
      //       $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      //       $q->execute();

      //       echo json_encode(array("message"=>"Salary Adjustment Updated Successfully", "type" => "success", "employeeno" => $employeeno));
      //       exit;
      //     }
      //     else {
      //       echo json_encode(array("message"=>"Hard Copy is required", "type" => "error", "employeeno" => $employeeno));
      //       exit;
      //     }
      //   }
      // }
      // else {
      //   $query = $conn->prepare("UPDATE salary_history SET date_hired='$datehiredemp', salary_type='$salarytype', salary_rate='$salaryemp',salary_type2='$salarytype2', salary_rate2='$salaryemp2',salary_type3='$salarytype3', salary_rate3='$salaryemp3',salary_type4='$salarytype4', salary_rate4='$salaryemp4', effective_date='$effectdateemp', job_title='$positionemp', employment_status='$statusemp',basic_salary='$basic_salary',remarks='$remarks' WHERE id='$id'");
      //   $query->execute();

      //   $query = $conn->prepare("SELECT employeeno FROM tbl_employee WHERE id='$idemp'");
      //   $query->execute();
      //   $row = $query->fetch();
      //   $employeeno = $row['employeeno'];

      //   session_start();
      //   $useraction = $_SESSION['fullname'];
      //   $dateaction = date('Y-m-d');
      //   $auditaction = "Update  the salary of Employee no ".$employeeno;
      //   $audittype = "EDIT";
      //   $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      //   $q->execute();
      //   echo json_encode(array("message"=>"Salary Adjustment Updated Successfully", "type" => "success", "employeeno" => $employeeno));
      //   exit;
      // }
    // }

  }

  function deleteEvaluation() {
    $id = $_POST['id'];
    $file_name = $_POST['file_name'];
    $employee_number = $_POST['employee_number'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("DELETE FROM performance_evaluation WHERE id='$id'");
    $query->execute();

    $link_file = "../performance_evaluation/".$employee_number."/".$file_name;
    unlink($link_file);
  }
  function updatePerformanceEvaluation() {
    $id = $_POST['performance_evaluation_id'];
    $employee_number = $_POST['performance_evaluation_employee_number'];
    $title = $_POST['performance_evaluation_title'];
    $description = $_POST['performance_evaluation_description'];
    $currentFile = $_POST['performance_evaluation_file_name'];
    $dateNow = date('Y-m-d');

    $conn = $this->connect_mysql();
    if($_FILES['performance_evaluation_file']['size'] > 0) {
      // Where the file is going to be stored
      $target_dir = "../performance_evaluation/".$employee_number."/";
      $file = $_FILES['performance_evaluation_file']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $attachfile = $filename.date('Y-m-d-His').".".$ext;
      $temp_name = $_FILES['performance_evaluation_file']['tmp_name'];
      $path_filename_ext = $target_dir.$attachfile;

      // Check if file already exists
      if (file_exists($path_filename_ext)) {
        echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employee_number));
        exit;
      }else{
        if(!is_dir("../performance_evaluation/".$employee_number."/")){
          mkdir("../performance_evaluation/".$employee_number."/");
        }

          if(move_uploaded_file($temp_name,$path_filename_ext)){
            if($currentFile != '' || $currentFile != NULL){
              $link_file = $target_dir.$currentFile;
              if(file_exists($link_file))
              unlink($link_file);
            }

            $conn = $this->connect_mysql();

            $qry = $conn->prepare("UPDATE performance_evaluation SET title='$title', description='$description', created_at='$dateNow',file_name='$attachfile' WHERE id='$id'");
            $qry->execute();

            session_start();
            $useraction = $_SESSION['fullname'];
            $dateaction = date('Y-m-d');
            $auditaction = "Update the performance evaluation of Employee no ".$employee_number;
            $audittype = "EDIT";
            $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
            $q->execute();

            echo json_encode(array('message' => 'Performance Evaluation Updated Successfully', 'type' => 'success'));
            exit;
          }
      }
    }
    else {
      $query = $conn->prepare("UPDATE performance_evaluation SET title='$title', description='$description', created_at='$dateNow' WHERE id='$id'");
      $query->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the performance evaluation of Employee no ".$employee_number;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
      echo json_encode(array("message"=>"Performance Evaluation Updated Successfully", "type" => "success", "employeeno" => $employee_number));
      exit;
    }
  }
}

$x = new crud();

if(isset($_GET['load_performance_evaluation'])){
  $x->load_performance_evaluation();
}
if(isset($_GET['addPerformanceEvaluation'])){
  $x->addPerformanceEvaluation();
}
if(isset($_GET['deleteEvaluation'])){
  $x->deleteEvaluation();
}
if(isset($_GET['updatePerformanceEvaluation'])){
  $x->updatePerformanceEvaluation();
}
 ?>
