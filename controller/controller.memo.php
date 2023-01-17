<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function acknowledgeMemo() {
    $conn=$this->connect_mysql();
    $query = $conn->prepare("UPDATE tbl_memo SET status = 'acknowledged' WHERE end_date < DATE(NOW()) AND status = 'active' AND notice_to_explain = 'no'");
    $query->execute();
  }

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
    $status = $_GET['status'];

    $conn = $this->connect_mysql();
    if ($memo == 'employee'){
      if($status == 'all'){
        $query = $conn->prepare("SELECT a.*, b.fullname FROM tbl_memo a LEFT JOIN user_account b ON a.employee_no = b.employeeno WHERE a.employee_no != '' ORDER BY a.datee DESC");
      } else {
        $query = $conn->prepare("SELECT a.*, b.fullname FROM tbl_memo a LEFT JOIN user_account b ON a.employee_no = b.employeeno WHERE a.employee_no != '' AND a.status = '$status' ORDER BY a.datee DESC");
      }
      $query->execute();
      $row = $query->fetchAll();
      $return = array();
      foreach ($row as $x){

        foreach ($x as $key => $input_arr) {
        $x[$key] = addslashes($input_arr);
        $x[$key] = utf8_encode($input_arr);
        }
        if($x['explanation'] != NULL || $x['explanation'] != '') {
          $explanationBtn = '';
          $explanationText = 'Explanation';
        } else {
          $explanationBtn = 'disabled';
          $explanationText = 'Unavailable';
        }
        $data = array();
        $data['action'] = '<div class="text-center d-flex justify-content-around">
        <button title="View Explanation" style="background-color: green; color: white" onclick="viewExplanation(\''.$x['explanation'].'\',\''.$x['employee_no'].'\')" class="btn btn-sm" '.$explanationBtn.'><i class="fas fa-sm fa-eye"></i>  '.$explanationText.'</button>
        <button title="View Memo" onclick="dl_memo(\''.$x['file_name'].'\',\''.$x['employee_no'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i></button>
        <button title="Delete" onclick="delete_memo('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employee_no'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button></div>';

        $data['employeeno'] = $x['employee_no'];
        $data['name'] = $x['fullname'];
        $data['memo'] = $x['memo_name'];
        $data['notice_to_explain'] = ucfirst($x['notice_to_explain']);
        $data['status'] = ucfirst($x['status']);
        $data['remarks'] = strlen($x['remarks']) > 20 ? substr($x['remarks'], 0, 20)."..." : $x['remarks'];
        $data['date'] = date('F d, Y',strtotime($x['datee']));

        $return[] = $data;
      }
      
      echo json_encode(array('data'=>$return));
    } else if ($memo == 'department') {
      if($status == 'all'){
        $query = $conn->prepare("SELECT * FROM tbl_memo WHERE department != '' ORDER BY datee DESC");
      } else {
        $query = $conn->prepare("SELECT * FROM tbl_memo WHERE department != '' AND status = '$status' ORDER BY datee DESC");
      }
        $query->execute();
        $row = $query->fetchAll();
        $return = array();
        foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }
          if($x['explanation'] != NULL || $x['explanation'] != '') {
            $explanationBtn = '';
            $explanationText = 'Explanation';
          } else {
            $explanationBtn = 'disabled';
            $explanationText = 'Unavailable';
          }
          $data = array();
          $data['action'] = '<div class="text-center d-flex justify-content-around">
          <button title="View Explanation" style="background-color: green; color: white" onclick="viewExplanation(\''.$x['explanation'].'\',\''.$x['department'].'\')" class="btn btn-sm" '.$explanationBtn.'><i class="fas fa-sm fa-eye"></i>  '.$explanationText.'</button>
          <button title="View Memo" onclick="dl_memo(\''.$x['file_name'].'\',\''.$x['department'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i></button>
          <button title="Delete" onclick="delete_memo('.$x['id'].',\''.$x['file_name'].'\',\''.$x['department'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button></div>';

          $data['department'] = $x['department'];
          $data['memo'] = $x['memo_name'];
          $data['notice_to_explain'] = ucfirst($x['notice_to_explain']);
          $data['status'] = ucfirst($x['status']);
          $data['remarks'] = strlen($x['remarks']) > 20 ? substr($x['remarks'], 0, 20)."..." : $x['remarks'];
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
      $remarks = $_POST['remarks'];
      $notice_to_explain = $_POST['notice_to_explain'];
      $publish_date = $_POST['publish_date'];
      $end_date = $_POST['end_date'];
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
      $dateNow = date('Y-m-d-His');
      $attachfile = $filename.$dateNow.".".$ext;
      $temp_name = $_FILES['empfile']['tmp_name'];
      $path_filename_ext = $target_dir.$attachfile;

      // Check if file already exists
       if (file_exists($path_filename_ext)) {
        echo json_encode(array('type' => 'error', 'message' => 'Sorry, file already exists.'));
        exit;
       }else{
          if($employeeddown != '' || $employeeddown != NULL) {
            if(!is_dir("../memo/".$employeeddown)){
              mkdir("../memo/".$employeeddown);
            }
            $auditaction = "Added new memo for ".$employeeddown;
          } else {
            if(!is_dir("../memo/".$departmentList)){
              mkdir("../memo/".$departmentList);
            }
            $auditaction = "Added new memo for ".$departmentList. "department.";
          }

          if(move_uploaded_file($temp_name,$path_filename_ext)){
            $conn=$this->connect_mysql();
            $sql = $conn->prepare("INSERT INTO tbl_memo SET employee_no='$employeeddown', file_name='$attachfile', datee='$datenow', status='active', memo_name='$memoname', department='$departmentList', remarks='$remarks', notice_to_explain = '$notice_to_explain', publish_date = '$publish_date', end_date = '$end_date'");
            $sql->execute();
  
            if($employeeddown != '' && $employeeddown != NULL){
              $sqry2 = $conn->prepare("SELECT corp_email FROM contactinfo WHERE employeeno='$employeeddown'");
              $sqry2->execute();
              $srow2 = $sqry2->fetch();
              $emailToSend = $srow2 ? $srow2['corp_email'] : '';
            }else {
              $sqry2 = $conn->prepare("SELECT dept_head_email FROM contactinfo WHERE employeeno='$employeeddown'");
              $sqry2->execute();
              $srow2 = $sqry2->fetch();
              $emailToSend = $srow2 ? $srow2['dept_head_email'] : '';
            }
  
            require 'Exception.php';
            require 'PHPMailer.php';
            require 'SMTP.php';
            require 'PHPMailerAutoload.php';
  
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.ipower.com";
            $mail->IsHTML(true);
            $mail->Username = "no-reply@panamed.com.ph";
            $mail->Password = "Unimex123!!";
            $mail->SetFrom("no-reply@panamed.com.ph", "");
            
            if($employeeddown != '' || $employeeddown != NULL){
              $message = "There's a memo uploaded by HR for you on your HRIS account";
            } else {
              $message = "There's a memo uploaded for your department " .$departmentList. " by HR on your HRIS account";
            }
            $mail->Subject = "Memorandum";
            $mail->Body = $message;
            $mail->isHTML(true);
            // $dept_head_email = $row2['dept_head_email'];
            $mail->AddAddress('bumacodejhay@gmail.com'); 
            $mail->AddCC($emailToSend); // Employee or department email
            if(!$mail->Send()) {
              echo json_encode(array('type' => 'success', 'message' => 'Memo uploded successfully <br /> Email not sent'));
              exit;
            } else {
              echo json_encode(array('type' => 'success', 'message' => 'Memo uploded successfully <br /> Email sent'));
              exit;
            }
  
            session_start();
            $useraction = $_SESSION['fullname'];
            $dateaction = date('Y-m-d');
            $audittype = "ADD";
            $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
            $q->execute();
          } else {
            echo json_encode(array('type' => 'error', 'message' => 'There\'s an error uploading your file'));
            exit;
          }
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
     $option .= '<option value="For Everyone">For Everyone</option>';
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
if(isset($_GET['acknowledgeMemo'])){
  $x->acknowledgeMemo();
}

 ?>
