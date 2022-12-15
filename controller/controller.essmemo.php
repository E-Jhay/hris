<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function load_memoess(){

    $employeeno = $_GET['employeeno'];
    $department = $_GET['department'];
    $memo = $_GET['memo'];
    $conn = $this->connect_mysql();
    if($memo == 'employee'){
      $query = $conn->prepare("SELECT * FROM tbl_memo WHERE employee_no='$employeeno' ORDER BY datee DESC");
      $query->execute();
      $row = $query->fetchAll();
      $return = array();
        foreach ($row as $x){
          $disabled = '';
          if($x['status'] == 'acknowledge'){
            $disabled = 'disabled';
          }

            foreach ($x as $key => $input_arr) {
            $x[$key] = addslashes($input_arr);
            $x[$key] = utf8_encode($input_arr);
            }
            $data = array();
            $data['action'] = '<center>
            <button title="View Memo" onclick="dl_memo(\''.$x['file_name'].'\',\''.$x['employee_no'].'\')" class="inv-button-sm btn btn-xs btn-primary" style="font-size:10px"><i class="fa fa-eye"></i> View Memo</button>
            <button '.$disabled.' title="Acknowledge" onclick="uploadExplain(\''.$x['id'].'\',\''.$x['datee'].'\',\''.$x['memo_name'].'\',\''.$x['remarks'].'\',\''.$x['explanation'].'\')" class="inv-button-sm btn btn-xs btn-primary" style="font-size:10px"><i class="fa fa-upload"></i> Acknowledge</button>
            </center>
            ';

            $data['employeeno'] = $x['employee_no'];
            $data['memo'] = $x['memo_name'];
            $data['status'] = ucfirst($x['status']);
            $data['remarks'] = $x['remarks'];
            $data['date'] = $x['datee'];

          $return[] = $data;
        }
      
      echo json_encode(array('data'=>$return));
    } else if($memo == 'department') {
      $query = $conn->prepare("SELECT * FROM tbl_memo WHERE department='$department' ORDER BY datee DESC");
      $query->execute();
      $row = $query->fetchAll();
      $return = array();
      foreach ($row as $x){
        $disabled = '';
        if($x['status'] == 'acknowledge'){
          $disabled = 'disabled';
        }

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
        $data['action'] = '<div class="text-center">
          <button title="View Memo" onclick="dl_memo(\''.$x['file_name'].'\',\''.$x['department'].'\')" class="inv-button-sm btn btn-xs btn-primary" style="font-size:10px"><i class="fa fa-eye"></i> View Memo</button>
          <button '.$disabled.' title="Acknowledge" onclick="uploadExplain(\''.$x['id'].'\',\''.$x['datee'].'\',\''.$x['memo_name'].'\',\''.$x['remarks'].'\',\''.$x['explanation'].'\')" class="inv-button-sm btn btn-xs btn-primary" style="font-size:10px"><i class="fa fa-upload"></i> Acknowledge</button>
        </div>';

        $data['department'] = $x['department'];
        $data['memo'] = $x['memo_name'];
        $data['status'] = ucfirst($x['status']);
        $data['remarks'] = strlen($x['remarks']) > 20 ? substr($x['remarks'], 0, 20)."..." : $x['remarks'];
        $data['date'] = date('F d, Y',strtotime($x['datee']));

        $return[] = $data;
      }
      echo json_encode(array('data'=>$return));
    }

  }

  function uploadExplanation() {
    $memo_id = $_POST['memo_id'];
    $action = $_POST['action'];
    $employeeno = $_POST['employeeno'];
    $department = $_POST['department'];
    $explanation = $_POST['explanation'];
    if(!empty($_FILES["file"]["name"])) {
      if($action == 'employee'){
        $target_dir = "../memo/Explanation/".$employeeno."/";
      } else {
        $target_dir = "../memo/Explanation/".$department."/";
      }
      $file = $_FILES['file']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['file']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $fileExplanation = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir;
      if(!is_dir($path_filename_ext)){
        mkdir($path_filename_ext, 0755);
      }
      $path_filename_ext .= $fileExplanation;
    
      if (move_uploaded_file($temp_name,$path_filename_ext)) {
        if($explanation != '' || $explanation != NULL){
          $link_file = $target_dir.$explanation;
          if(file_exists($link_file))
          unlink($link_file);
        }
        $conn = $this->connect_mysql();
        $qry = $conn->prepare("UPDATE tbl_memo SET explanation='$fileExplanation', status='acknowledge' WHERE id = '$memo_id'");
        $qry->execute();

        require 'Exception.php';
        require 'PHPMailer.php';
        require 'SMTP.php';
        require 'PHPMailerAutoload.php';

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->IsHTML(true);
        $mail->Username = "pmcmailchimp@gmail.com";
        $mail->Password = "qyegdvkzvbjihbou";
        $mail->SetFrom("no-reply@panamed.com.ph", "");

        
        if($action == 'employee'){
          $message = "Employee ".$employeeno." uploaded an explanation to a memo";
        } else {
          $message = "The ".$department." department uploaded an explanation to a memo";
        }
        $mail->Subject = "Memorandum";
        $mail->Body = $message;
        $mail->isHTML(true);
        // $dept_head_email = $row2['dept_head_email'];
        $mail->AddAddress('bumacodejhay@gmail.com');
        $mail->AddCC('ejhaybumacod26@gmail.com');
        $mail->Send();

        echo json_encode(array('message' => 'Explanation Uploaded Successfully', 'type' => 'success'));
        exit;
      }
    }
    echo json_encode(array('message' => 'An Error Occured', 'type' => 'error'));
  }

  function readleave(){

    $employeeno = $_POST['employeeno'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("UPDATE leave_application SET readd='read' WHERE employeeno='$employeeno'");
    $query->execute();

  }

  function readpayslip(){

    $employeeno = $_POST['employeeno'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("UPDATE payslips SET stat='read' WHERE employeeno='$employeeno'");
    $query->execute();

  }  

  function count_leaveapp(){

    $employeenoo = $_POST['employeenoo'];
    $conn = $this->connect_mysql();

    $sq = $conn->prepare("SELECT department FROM tbl_employee WHERE employeeno='$employeenoo'");
    $sq->execute();
    $rw = $sq->fetch();

    $dept = $rw['department'];

    $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.status='Pending' ORDER BY a.id DESC");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function count_otapp(){

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM tbl_overtime WHERE statuss='Pending' ORDER BY id DESC");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function count_payslip(){

    $employeenoo = $_POST['employeenoo'];
    $conn = $this->connect_mysql();

    $query = $conn->prepare("SELECT * FROM payslips WHERE employeeno='$employeenoo' AND stat='posted'");
    $query->execute();
    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function count_reimbursement(){

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM tbl_reimbursement WHERE statuss='Pending'");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

}

$x = new crud();

if(isset($_GET['load_memoess'])){
  $x->load_memoess();
}

if(isset($_GET['readleave'])){
  $x->readleave();
}

if(isset($_GET['readpayslip'])){
  $x->readpayslip();
}

if(isset($_GET['count_leaveapp'])){
  $x->count_leaveapp();
}

if(isset($_GET['count_otapp'])){
  $x->count_otapp();
}

if(isset($_GET['count_payslip'])){
  $x->count_payslip();
}

if(isset($_GET['count_reimbursement'])){
  $x->count_reimbursement();
}
if(isset($_GET['uploadExplanation'])){
  $x->uploadExplanation();
}

 ?>
