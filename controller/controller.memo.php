<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function employeelist(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM tbl_employee ORDER BY firstname ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Employee--</option>';
      while($row=$sql->fetch()){
        foreach ($row as $key => $input_arr) {
          $row[$key] = addslashes($input_arr);
          $row[$key] = utf8_encode($input_arr);
          }
       $option.='<option value="'.$row['employeeno'].'">'.$row['firstname']." ".$row['lastname'].'</option>';
     }
      echo $option;
  }

  function deletememo(){


    $id = $_POST['id'];
    $filename = $_POST['filename'];
    $employeeno = $_POST['employeeno'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("DELETE FROM tbl_memo WHERE id='$id'");
    $query->execute();

    $link_file = "../memo/".$employeeno."/".$filename;
    unlink($link_file);

    session_start();
    $useraction = $_SESSION['fullname'];
    $dateaction = date('Y-m-d');
    $auditaction = "Deleted a memo";
    $audittype = "Delete";
    $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
    $q->execute();

  }

  function load_memo(){
    
    $memo = $_GET['memo'];

    $conn = $this->connect_mysql();
    if ($memo == 'employee'){
      $query = $conn->prepare("SELECT a.*, b.fullname FROM tbl_memo a LEFT JOIN user_account b ON a.employee_no = b.employeeno WHERE a.employee_no != ''");
      $query->execute();
      $row = $query->fetchAll();
      $return = array();
      foreach ($row as $x){

        foreach ($x as $key => $input_arr) {
        $x[$key] = addslashes($input_arr);
        $x[$key] = utf8_encode($input_arr);
        }
        $data = array();
        $data['action'] = '<button onclick="dl_memo(\''.$x['file_name'].'\',\''.$x['employee_no'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-download"></i> Download</button>
        <button onclick="delete_memo('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employee_no'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';

        $data['employeeno'] = $x['employee_no'];
        $data['name'] = $x['fullname'];
        $data['memo'] = $x['memo_name'];
        $data['date'] = date('F d, Y',strtotime($x['datee']));

        $return[] = $data;
      }
      
      echo json_encode(array('data'=>$return));
    } else if ($memo == 'department') {
        $query = $conn->prepare("SELECT a.*, b.department FROM tbl_memo a LEFT JOIN department b ON a.department = b.department WHERE a.department != ''");
        $query->execute();
        $row = $query->fetchAll();
        $return = array();
        foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }
          $data = array();
          $data['action'] = '<button onclick="dl_memo(\''.$x['file_name'].'\',\''.$x['department'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-download"></i> Download</button>
          <button onclick="delete_memo('.$x['id'].',\''.$x['file_name'].'\',\''.$x['department'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';

          $data['department'] = $x['department'];
          $data['memo'] = $x['memo_name'];
          $data['date'] = date('F d, Y',strtotime($x['datee']));

          $return[] = $data;
        }
        echo json_encode(array('data'=>$return));
    }

  }

  function uploadmemo(){

    if (($_FILES['empfile']['name']!="")){

      $employeeddown = $_POST['employeeddown'];
      $departmentList = $_POST['departmentList'];
      $memoname = $_POST['memoname'];
      $datenow = date('Y-m-d');
      // Where the file is going to be stored
      if($employeeddown != '' || $employeeddown != NULL){
        $target_dir = "../memo/".$employeeddown."/";
      } else {
        $target_dir = "../memo/".$departmentList."/";
      }
      $file = $_FILES['empfile']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $attachfile = $filename.".".$ext;
      $temp_name = $_FILES['empfile']['tmp_name'];
      $path_filename_ext = $target_dir.$filename.".".$ext;


      // Check if file already exists
       if (file_exists($path_filename_ext)) {
        echo "Sorry, file already exists.";
       }else{
  
        mkdir("../memo/".$departmentList);

          move_uploaded_file($temp_name,$path_filename_ext);

          $conn=$this->connect_mysql();
          $sql = $conn->prepare("INSERT INTO tbl_memo SET employee_no='$employeeddown', file_name='$attachfile', datee='$datenow', status='active', memo_name='$memoname', department='$departmentList'");
          $sql->execute();

          session_start();
          $useraction = $_SESSION['fullname'];
          $dateaction = date('Y-m-d');
          $auditaction = "Added new memo for ".$employeeddown;
          $audittype = "ADD";
          $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
          $q->execute();

          header("location:../memo.php");

          
       }

       
    }

  }
  // function uploadInterOfficeMemo(){

  //   if (($_FILES['empfile']['name']!="")){

  //     $departmentList = $_POST['departmentList'];
  //     $memoname = $_POST['memoname'];
  //     $datenow = date('Y-m-d');
  //     // Where the file is going to be stored
  //      $target_dir = "../memo/".$employeeddown."/";
  //      $file = $_FILES['empfile']['name'];
  //      $path = pathinfo($file);
  //      $filename = $path['filename'];
  //      $ext = $path['extension'];
  //      $attachfile = $filename.".".$ext;
  //      $temp_name = $_FILES['empfile']['tmp_name'];
  //      $path_filename_ext = $target_dir.$filename.".".$ext;


  //     // Check if file already exists
  //      if (file_exists($path_filename_ext)) {
  //       echo "Sorry, file already exists.";
  //      }else{
  
  //       mkdir("../memo/".$employeeddown);

  //         move_uploaded_file($temp_name,$path_filename_ext);

  //         $conn=$this->connect_mysql();
  //         $sql = $conn->prepare("INSERT INTO tbl_memo SET employee_no='$employeeddown', file_name='$attachfile', datee='$datenow', status='active', memo_name='$memoname'");
  //         $sql->execute();

  //         session_start();
  //         $useraction = $_SESSION['fullname'];
  //         $dateaction = date('Y-m-d');
  //         $auditaction = "Added new memo for ".$employeeddown;
  //         $audittype = "ADD";
  //         $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
  //         $q->execute();

  //         header("location:../memo.php");

          
  //      }

       
  //   }

  // }
  function departmentList(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM department WHERE statuss = 'active' ORDER BY department ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Department--</option>';
      while($row=$sql->fetch()){
        foreach ($row as $key => $input_arr) {
          $row[$key] = addslashes($input_arr);
          $row[$key] = utf8_encode($input_arr);
          }
       $option.='<option value="'.$row['department'].'">'.$row['department'].'</option>';
     }
      echo $option;
  }

}

$x = new crud();

if(isset($_GET['employeelist'])){
  $x->employeelist();
}
if(isset($_GET['deletememo'])){
  $x->deletememo();
}
if(isset($_GET['load_memo'])){
  $x->load_memo();
}
if(isset($_GET['uploadmemo'])){
  $x->uploadmemo();
}
// if(isset($_GET['uploadInterOfficeMemo'])){
//   $x->uploadInterOfficeMemo();
// }
if(isset($_GET['departmentList'])){
  $x->departmentList();
}

 ?>
