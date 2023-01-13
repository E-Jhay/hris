<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  // function count_leaveapp(){

  //   $employeenoo = $_POST['employeenoo'];
  //   $conn = $this->connect_mysql();

  //   $sq = $conn->prepare("SELECT department FROM tbl_employee WHERE employeeno='$employeenoo'");
  //   $sq->execute();
  //   $rw = $sq->fetch();

  //   $dept = $rw['department'];

  //   $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
  //                            LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.status='Pending' ORDER BY a.id DESC");
  //   $query->execute();

  //   $count = $query->rowCount();

  //   echo json_encode(array("count"=>$count));
  // }
  // function count_otapp(){

  //   $conn = $this->connect_mysql();
  //   $query = $conn->prepare("SELECT * FROM tbl_overtime WHERE statuss='Pending' ORDER BY id DESC");
  //   $query->execute();

  //   $count = $query->rowCount();

  //   echo json_encode(array("count"=>$count));
  // }
  // function count_payslip(){

  //   $employeenoo = $_POST['employeenoo'];
  //   $conn = $this->connect_mysql();

  //   $query = $conn->prepare("SELECT * FROM payslips WHERE employeeno='$employeenoo' AND stat='posted'");
  //   $query->execute();
  //   $count = $query->rowCount();

  //   echo json_encode(array("count"=>$count));
  // }
  // function count_reimbursement(){

  //   $conn = $this->connect_mysql();
  //   $query = $conn->prepare("SELECT * FROM tbl_reimbursement WHERE statuss='Pending'");
  //   $query->execute();

  //   $count = $query->rowCount();

  //   echo json_encode(array("count"=>$count));
  // }

  //   function readleave(){

  //     $employeeno = $_POST['employeeno'];

  //     $conn = $this->connect_mysql();
  //     $query = $conn->prepare("UPDATE leave_application SET readd='read' WHERE employeeno='$employeeno'");
  //     $query->execute();

  //   }

  //   function readpayslip(){

  //     $employeeno = $_POST['employeeno'];

  //     $conn = $this->connect_mysql();
  //     $query = $conn->prepare("UPDATE payslips SET stat='read' WHERE employeeno='$employeeno'");
  //     $query->execute();

  //   }

    function employeelistadmin(){

      $employeenoo = $_GET['employeenoo'];
      $conn=$this->connect_mysql();
      $sq = $conn->prepare("SELECT department FROM tbl_employee WHERE employeeno='$employeenoo'");
      $sq->execute();
      $rw = $sq->fetch();
      $dept = $rw['department'];

      $sql = $conn->prepare("SELECT * FROM tbl_employee  WHERE  employeeno !='$employeenoo' ORDER BY lastname ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Employee--</option>';
      while($row=$sql->fetch()){
        foreach ($row as $key => $input_arr) {
          $row[$key] = addslashes($input_arr);
          $row[$key] = utf8_encode($input_arr);
          }
       $option.='<option value="'.$row['employeeno'].'">'.$row['lastname'].", ".$row['firstname'].'</option>';
     }
      echo $option;

  }

  function leave_typelist(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM leave_type WHERE leave_stat='active'");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Leave type--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['leave_type'].'">'.$row['leave_type']." - ".$row['leave_name'].'</option>';}
      echo $option;
  }

  function get_leavebal(){

      $leave_type = $_POST['leave_type'];
      $employeeno = $_POST['employeeno'];
      $conn=$this->connect_mysql();
      $sql2 = $conn->prepare("SELECT a.*,b.* FROM leave_balance a 
                              LEFT JOIN leave_type b ON a.leave_type=b.leave_type
                              WHERE a.employee_no='$employeeno' AND a.leave_type='$leave_type'");
      $sql2->execute();
      $row = $sql2->fetch();
      $balance = $row['balance'];
      $points = $row['points'];
      if($balance=="" || $balance==null){
          echo json_encode(array("bal"=>"wala"));
      }else{  
          echo json_encode(array("bal"=>$balance,"points"=>$points));
      }

    }

    function searchleavebalance(){

      $employeeno = $_POST['employeeno'];
      $conn = $this->connect_mysql();
      $qry = $conn->prepare("SELECT * FROM tbl_employee WHERE employeeno='$employeeno'");
      $qry->execute();
      $row = $qry->fetch();
      $leave_balance = $row['leave_balance'];
      echo json_encode(array("leave_balance"=>$leave_balance));

  }

  function fetch_leave(){

        $employeeno = $_POST['employeeno'];

        $conn=$this->connect_mysql();
        $sql2 = $conn->prepare("SELECT * FROM leave_balance WHERE employee_no='$employeeno'");
        $sql2->execute();
        $row = $sql2->fetchAll();
        $return = array();
        foreach ($row as $x) {

          $data = $x['leave_type'].' - '.$x['balance'];
          $return[] = $data;
        }

        echo json_encode($return);
  
    }

    function update_deductleave(){

      $emp_id = $_POST['emp_id'];
      $new_deduct = $_POST['new_deduct'];
      $emp_rate = $_POST['emp_rate'];
      $fivepm = $_POST['fivepm'];
      $sixpm = $_POST['sixpm'];

      $conn=$this->connect_mysql();
      $sql2 = $conn->prepare("UPDATE leave_application SET no_days='$new_deduct',deduct_rate='$emp_rate',fivepm='$fivepm',sixpm='$sixpm' WHERE id='$emp_id'");
      $sql2->execute();

    }

    function approveleave(){

    $emp_id = $_POST['emp_id'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];
    $emp_number = $_POST['emp_number'];
    $emp_nodays = $_POST['emp_nodays'];
    $emp_leavetype = $_POST['emp_leavetype'];
    $datenow = date('Y-m-d');
    $timenow = date('h:i:s');
    $stat = $_POST['status'];
    $statt = $_POST['status'];
    $emp_status = $_POST['emp_status'];

    if($stat=="Cancelled"){
      $stat = "Pending";
    }

    if($statt=="Cancelled"){
      $statt = "Undo";
    }

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("UPDATE leave_application SET status='$stat', remarks='$remarks', approved_by='Administrator', readd='notread',last_update='$datenow',last_update_time='$timenow' WHERE id='$emp_id'");
      $sql->execute();

      $sqry = $conn->prepare("SELECT id,firstname,lastname,department FROM tbl_employee WHERE employeeno='$emp_number'");
      $sqry->execute();
      $srow = $sqry->fetch();
      $employee_id = $srow['id'];
      $firstname = $srow['firstname'];
      $lastname = utf8_decode($srow['lastname']);
      $department = $srow['department'];

      $sqry2 = $conn->prepare("SELECT corp_email FROM contactinfo WHERE employeeno='$emp_number'");
      $sqry2->execute();
      $srow2 = $sqry2->fetch();
      $corp_email = $srow2['corp_email'];

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
            $mail->Subject = "Leave Application Status";
            if($statt=="Disapproved"){
              $emp_nodays = 0;
            }
            $msg = 'Your request '.$emp_leavetype.' was '.$statt.' by HR Assistant-Payroll<br><br>No. of Credits to be deducted: '.$emp_nodays;
            $mail->Body = $msg;

            $mail->isHTML(true);
            $mail->AddAddress($corp_email);
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {

            }

            
      if($status=="Approved"){                                        

           
          
          $sqll = $conn->prepare("SELECT balance FROM leave_balance WHERE employee_no='$emp_number' AND leave_type='$emp_leavetype'");
          $sqll->execute();
          $roww = $sqll->fetch();
          $balance = $roww['balance'];
          // $points_deduct = $points * (int)$emp_nodays;
          $points_deduct = $_POST['emp_nodays'];
          
          $n_balance = $balance - $points_deduct;

          $sql4 = $conn->prepare("UPDATE leave_balance SET balance='$n_balance' WHERE employee_no='$emp_number' AND leave_type='$emp_leavetype'");
          $sql4->execute();

          $sql2 = $conn->prepare("SELECT * FROM tbl_employee WHERE employeeno='$emp_number'");
          $sql2->execute();
          $row = $sql2->fetch();
          $leave_balance = $row['leave_balance'];
          $new_balance = $leave_balance - $points_deduct;

          $sql3 = $conn->prepare("UPDATE tbl_employee SET leave_balance='$new_balance' WHERE employeeno='$emp_number'");
          $sql3->execute();
      }else if($status=="Cancelled" && $emp_status=="Approved"){

          $qry = $conn->prepare("SELECT balance FROM leave_balance WHERE employee_no='$emp_number' AND leave_type='$emp_leavetype'");
          $qry->execute();
          $rw = $qry->fetch();
          $balance = $rw['balance'];

          $points_deduct = $_POST['emp_nodays'];

          $n_balance = $balance + $points_deduct;

          $qry2 = $conn->prepare("UPDATE leave_balance SET balance='$n_balance' WHERE employee_no='$emp_number' AND leave_type='$emp_leavetype'");
          $qry2->execute();

          $qry3 = $conn->prepare("SELECT * FROM tbl_employee WHERE employeeno='$emp_number'");
          $qry3->execute();
          $rw2 = $qry3->fetch();
          $leave_balance = $rw2['leave_balance'];
          $new_balance = $leave_balance + $points_deduct;

          $sql3 = $conn->prepare("UPDATE tbl_employee SET leave_balance='$new_balance' WHERE employeeno='$emp_number'");
          $sql3->execute();

      }

  }

  function uploadLeaveForm() {
  
    if(($_FILES['leaveForm']['name'] != "")) {
      $target_dir = "../static/leave_form/";
      $file = $_FILES['leaveForm']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['leaveForm']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $newfilename = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir.$newfilename;

      move_uploaded_file($temp_name,$path_filename_ext);

      echo $newfilename;

    } else {

      echo "Upload Failed";

    }

  }

  function addleave(){

      $leave_type = $_POST['leave_type'];
      $datefrom = $_POST['datefrom'];
      $dateto = $_POST['dateto'];
      $comment = $_POST['comment'];
      $stat = $_POST['stat'];
      $employeeno = $_POST['employeeno'];
      $date_applied = $_POST['date_applied'];
      $no_days = $_POST['no_days'];
      // $updatedbalance = $_POST['updatedbalance'];
      $application_type = $_POST['application_type'];
      $points_todeduct = $_POST['points_todeduct'];
      // $dayss = $_POST['dayss'];
      $date_from = $_POST['date_from'];
      $leave_bal = $_POST['leave_bal'];
      $pay_leave = $_POST['pay_leave'];
      $datenow = date('Y-m-d');
      $timenow = date('H:i:s');

      // if($application_type=="Whole Day"){
      //   $date_from = $datefrom;
      // }
      
      // if($application_type=="Half Day" || $application_type=="Under Time"){
      //   $dayss = 1;
      // }

      // if($application_type=="Under Time") {
      //   $from_time = date('h:i A', strtotime($datefrom)); 
      //   $to_time = date('h:i A', strtotime($dateto));
      //   $dateto = $from_time ." - ". $to_time;
      // }

      if(!empty($_FILES["leaveForm"]["name"])) {
        $target_dir = "../static/leave_form/".$employeeno.'/';
        $file = $_FILES['leaveForm']['name'];
        $path = pathinfo($file);
        $ext = $path['extension'];
        $temp_name = $_FILES['leaveForm']['tmp_name'];
        $today = date("Y-m-d-His");
        $name = explode(".", $file);
        $leaveForm = $name[0]."-".$today.".".$ext;
        $path_filename_ext = $target_dir;
        if(!is_dir($path_filename_ext)){
          mkdir($path_filename_ext, 0755);
        }
        $path_filename_ext .= $leaveForm;
      
        move_uploaded_file($temp_name,$path_filename_ext);
      } else {
        $leaveForm = '';
      }


      session_start();
      $department = $_SESSION['department'];

      $conn = $this->connect_mysql();
      $qry = $conn->prepare("INSERT INTO leave_application SET leave_type='$leave_type', datefrom='$datefrom', dateto='$dateto', comment='$comment', status='$stat', employeeno='$employeeno', department = '$department', date_applied='$date_applied',previous_bal='$leave_bal', no_days='$no_days',application_type='$application_type',deduct_rate='$points_todeduct',fivepm='0',sixpm='0',date_from='',pay_leave='$pay_leave', remarks='', approved_by='', readd='', last_update='$datenow', last_update_time='$timenow', leave_form='$leaveForm'");
      $qry->execute();

      $qry2 = $conn->prepare("SELECT id,department,firstname,lastname FROM tbl_employee WHERE employeeno='$employeeno'");
      $qry2->execute();
      $row = $qry2->fetch();

      $department = $row['department'];
      $firstname = $row['firstname'];
      $lastname = utf8_decode($row['lastname']);
      // $id = $row['id'];

      $qry3 = $conn->prepare("SELECT dept_head_email FROM contactinfo WHERE employeeno='$employeeno'");
      $qry3->execute();
      $row2 = $qry3->fetch();

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
      $mail->Subject = "Leave Application";
      $message = $firstname.' '.$lastname.' applied '.$leave_type.' <strong>'. $application_type.'</strong> From: '.$datefrom.' To: '.$dateto;
      $mail->Body = $message;
      $dept_head_email = $row2['dept_head_email'];
      $mail->AddAddress($dept_head_email); // HR email
      $mail->AddCC('bumacodejhay@gmail.com');

      if(!$mail->Send()) {
        echo json_encode(array('type' => 'success', 'message' => 'Successful application of leave. <br /> Email not sent.'));
        exit;
      }
      echo json_encode(array('type' => 'Success', 'message' => 'Successful application of leave. <br  /> Emai sent'));

      //       $mail = new PHPMailer();
      //       $mail->IsSMTP();
      //       $mail->SMTPDebug = 0;
      //       $mail->SMTPAuth = true;
      //       $mail->SMTPSecure = 'ssl';
      //       $mail->Host = "smtp.gmail.com";
      //       $mail->Port = 465;
      //       $mail->IsHTML(true);
      //       $mail->Username = "pmcmailchimp@gmail.com";
      //       $mail->Password = "qyegdvkzvbjihbou";
      //       $mail->SetFrom("no-reply@panamed.com.ph", "");
      //       $mail->Subject = "Leave Application";
      //       $msg = $firstname.' '.$lastname.' applied '.$leave_type.' From: '.$datefrom.' To: '.$dateto;
      //       $mail->Body = $msg;
      //       $dept_head_email = $row2['dept_head_email'];
      //       $mail->AddAddress($dept_head_email);
      //       if(!$mail->Send()) {
      //         echo "Mailer Error: " . $mail->ErrorInfo;
      //       } else {
      //         echo "success";
      //       }

        // $mail = new PHPMailer();
        // $mail->IsSMTP();
        // $mail->SMTPDebug = 0;
        // $mail->SMTPAuth = true;
        // $mail->SMTPSecure = 'ssl';
        // $mail->Host = "smtp.gmail.com";
        // $mail->Port = 465;
        // $mail->IsHTML(true);
        // $mail->Username = "pmcmailchimp@gmail.com";
        // $mail->Password = "qyegdvkzvbjihbou";
        // $mail->SetFrom("no-reply@panamed.com.ph", "");
        // $dept_head_email = $row2['dept_head_email'];
        
        // $message = $firstname.' '.$lastname.' applied '.$leave_type.' <strong>'. $application_type.'</strong> From: '.$datefrom.' To: '.$dateto. ' dept_head_email: ' .$dept_head_email;
        // $mail->Subject = "Leave Application";
        // $mail->Body = $message;
        // $mail->isHTML(true);
        // $mail->AddAddress($dept_head_email);
        // $mail->AddCC('ejhaybumacod26@gmail.com');
        // $mail->Send();

        // echo json_encode(array('type' => 'success', 'message' => 'Successful application of leave', 'dept_head_email' => $dept_head_email));

      // $qry1 = $conn->prepare("UPDATE tbl_employee SET leave_balance='$updatedbalance' WHERE employeeno='$employeeno'");
      // $qry1->execute();

  }

  function delete_myleave(){

      $id = $_POST['id'];
      $leave_form = $_POST['leave_form'];
      $employeeno = $_POST['employeeno'];
      $conn=$this->connect_mysql();
      $sql = $conn->prepare("DELETE FROM leave_application WHERE id='$id' AND status='Pending'");
      $sql->execute();
      
      $link_file = "../static/leave_form/".$employeeno.'/'.$leave_form;
      unlink($link_file);
    
  }

  function loadmyleave(){

    $employeeno = $_GET['employeeno'];
    $status = $_GET['status'];
    $conn = $this->connect_mysql();
    if($status == ''){
      $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                             WHERE a.employeeno='$employeeno' ORDER BY a.id DESC");
    } else {
      $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
      LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
      WHERE a.employeeno='$employeeno' AND a.status = '$status' ORDER BY a.id DESC");
    }
    
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }
          $employeeno = $x['employeeno'];
          $leave_type = $x['leave_type'];
          $sql = $conn->prepare("SELECT balance FROM leave_balance WHERE  leave_type='$leave_type' AND employee_no='$employeeno'");
          $sql->execute();
          $rowww = $sql->fetch();
          $balanse = $rowww['balance'];
          // if($balanse < 0 ){
          //   $balanse = 0;
          // }
          $fname = $x['firstname'].' '.$x['lastname'];
          $fname = utf8_decode($fname);
          $data = array();
          
          $data['employeeno'] = utf8_decode($x['firstname'].' '.$x['lastname']);
          $data['date'] = $x['date_applied'];
          $data['leavetype'] = $x['leave_type'];

          $data['leavebalance'] = $balanse;
          $stados = $x['status'];
          if($stados=="Pending"){
            $data['numberofdays'] = "";
            $data['action'] = '<center class="d-flex justify-content-around">
            <button title="View" onclick="edit_leave('.$x['idd'].',\''.$fname.'\',\''.$x['employeeno'].'\',\''.$x['leave_type'].'\',\''.$x['date_applied'].'\',\''.$x['leave_balance'].'\',\''.$x['datefrom'].'\',\''.$x['dateto'].'\',\''.$x['no_days'].'\',\''.$x['status'].'\',\''.$x['comment'].'\',\''.$x['remarks'].'\',\''.$x['application_type'].'\',\''.$x['deduct_rate'].'\','.$x['fivepm'].','.$x['sixpm'].',\''.$balanse.'\',\''.$x['pay_leave'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i></button>
            <button title="Delete" onclick="delete_leave('.$x['idd'].',\''.$x['leave_form'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button>
            </center>
            ';

          }else{

            
            if($x['pay_leave']=="Without Pay"){
              $data['numberofdays'] = 0;
            }else{
              $data['numberofdays'] = $x['no_days'];
            }
            $data['action'] = '<center class="d-flex justify-content-around">
            <button class="btn btn-primary btn-sm" title="View" onclick="edit_leave('.$x['idd'].',\''.$fname.'\',\''.$x['employeeno'].'\',\''.$x['leave_type'].'\',\''.$x['date_applied'].'\',\''.$x['leave_balance'].'\',\''.$x['datefrom'].'\',\''.$x['dateto'].'\',\''.$x['no_days'].'\',\''.$x['status'].'\',\''.$x['comment'].'\',\''.$x['remarks'].'\',\''.$x['application_type'].'\',\''.$x['deduct_rate'].'\','.$x['fivepm'].','.$x['sixpm'].',\''.$balanse.'\',\''.$x['pay_leave'].'\')"><i class="fa fa-eye"></i></button>
            <button class="btn btn-danger btn-sm" title="Delete" disabled="" onclick="delete_leave('.$x['idd'].')"><i class="fa fa-trash"></i></button>
            </center>
            ';
          }
          
          $data['active_status'] = $x['status'];

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function loadleavelist(){

    $employeenoo = $_GET['employeenoo'];
    $stat = $_GET['stat'];
    $conn = $this->connect_mysql();

    $sq = $conn->prepare("SELECT department FROM tbl_employee WHERE employeeno='$employeenoo'");
    $sq->execute();
    $rw = $sq->fetch();

    $dept = $rw['department'];
    if($stat=="All"){
      $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno ORDER BY a.id DESC");
    }else{
      $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.status='$stat' ORDER BY a.id DESC");
    }
    
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $employeeno = $x['employeeno'];
          $leave_type = $x['leave_type'];
          $sql = $conn->prepare("SELECT balance FROM leave_balance WHERE  leave_type='$leave_type' AND employee_no='$employeeno'");
          $sql->execute();
          $rowww = $sql->fetch();
          $balanse = $rowww['balance'];
          if($balanse < 0){
            $balanse = 0;
          }
          
          $fname = $x['firstname'].' '.$x['lastname'];
          $fname = utf8_decode($fname);
          $data = array();
          $data['action'] = '<center>
          <button onclick="edit_leave('.$x['idd'].',\''.$fname.'\',\''.$x['employeeno'].'\',\''.$x['leave_type'].'\',\''.$x['date_applied'].'\',\''.$x['leave_balance'].'\',\''.$x['datefrom'].'\',\''.$x['dateto'].'\',\''.$x['no_days'].'\',\''.$x['status'].'\',\''.$x['comment'].'\',\''.$x['remarks'].'\',\''.$x['application_type'].'\',\''.$x['deduct_rate'].'\','.$x['fivepm'].','.$x['sixpm'].',\''.$balanse.'\',\''.$x['pay_leave'].'\')" style="font-size:10px;color: white;background: #4c91cd;border-color: #4c91cd;"><i class="fa fa-eye"></i> View</button> 
          </center>';
          $data['employeeno'] = utf8_decode($x['firstname'].' '.$x['lastname']);
          $data['date'] = $x['date_applied'];
          $data['leavetype'] = $x['leave_type'];
          $data['leavebalance'] = $balanse;
          // $data['numberofdays'] = round($x['no_days'],2);
          if($x['pay_leave']=="Without Pay"){
            $data['numberofdays'] = 0;
          }else if($x['status']=="Disapproved"){
            $data['numberofdays'] = 0;
          }else{
            $data['numberofdays'] = $x['no_days'];
          }
          
          $data['active_status'] = $x['status'];

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  public function countLeaves($empno){
    $conn = $this->connect_mysql();
    $sql = $conn->prepare("SELECT * FROM leave_application WHERE status !='Pending' AND employeeno='$empno' AND readd='notread'");
    $sql->execute();
    $count = $sql->rowCount();
    return $count;
  }

  public function getleavebalance($empno)
  {   
      $conn = $this->connect_mysql();
      $stmt = $conn->prepare("SELECT * FROM leave_balance WHERE employee_no='$empno'");
      $stmt->execute();
      $row = $stmt->fetchAll();
      return $row;
  }


}

$x = new crud();

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
if(isset($_GET['readleave'])){
  $x->readleave();
}
if(isset($_GET['readpayslip'])){
  $x->readpayslip();
}
if(isset($_GET['employeelistadmin'])){
  $x->employeelistadmin();
}
if(isset($_GET['leave_typelist'])){
  $x->leave_typelist();
}
if(isset($_GET['get_leavebal'])){
  $x->get_leavebal();
}
if(isset($_GET['searchleavebalance'])){
  $x->searchleavebalance();
}
if(isset($_GET['fetch_leave'])){
  $x->fetch_leave();
}
if(isset($_GET['update_deductleave'])){
  $x->update_deductleave();
}
if(isset($_GET['approveleave'])){
  $x->approveleave();
}
if(isset($_GET['uploadLeaveForm'])){
  $x->uploadLeaveForm();
}
if(isset($_GET['addleave'])){
  $x->addleave();
}
if(isset($_GET['delete_myleave'])){
  $x->delete_myleave();
}
if(isset($_GET['loadmyleave'])){
  $x->loadmyleave();
}
if(isset($_GET['loadleavelist'])){
  $x->loadleavelist();
}

 ?>
