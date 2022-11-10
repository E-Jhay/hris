<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

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
       $option.='<option value="'.$row['employeeno'].'">'.utf8_decode($row['lastname'].', '.$row['firstname']).'</option>';
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

          if($balance <=0){
            $balance = 0;
          }
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

  /////////////////////////////////////////////////////////////////////

  // function update_deductleave(){

  //     $emp_id = $_POST['emp_id'];
  //     $new_deduct = $_POST['new_deduct'];
  //     $emp_rate = $_POST['emp_rate'];
  //     $fivepm = $_POST['fivepm'];
  //     $sixpm = $_POST['sixpm'];

  //     $conn=$this->connect_mysql();
  //     $sql2 = $conn->prepare("UPDATE leave_application SET no_days='$new_deduct',deduct_rate='$emp_rate',fivepm='$fivepm',sixpm='$sixpm' WHERE id='$emp_id'");
  //     $sql2->execute();

  // }

  /////////////////////////////////////////////////////////////////////

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

      $sqry2 = $conn->prepare("SELECT corp_email FROM contactinfo WHERE emp_id='$employee_id'");
      $sqry2->execute();
      $srow2 = $sqry2->fetch();
      $corp_email = $srow2['corp_email'];

            /////////////////////////////////////////////////////////////////////

            // require 'Exception.php';
            // require 'PHPMailer.php';
            // require 'SMTP.php';
            // require 'PHPMailerAutoload.php';

            // $mail = new PHPMailer();
            // $mail->IsSMTP();
            // $mail->SMTPDebug = 0;
            // $mail->SMTPAuth = true;
            // $mail->Host = "mail.panamed.com.ph";
            // $mail->IsHTML(true);
            // $mail->Username = "no-reply@panamed.com.ph";
            // $mail->Password = "Unimex123!";
            // $mail->SetFrom("no-reply@panamed.com.ph", "");
            // $mail->Subject = "Leave Application Status";
            // if($statt=="Disapproved"){
            //   $emp_nodays = 0;
            // }
            // $msg = 'Your request '.$emp_leavetype.' was '.$statt.' by HR Assistant-Payroll<br><br>No. of Credits to be deducted: '.$emp_nodays;
            // $mail->Body = $msg;

            // $mail->isHTML(true);
            // $mail->AddAddress($corp_email);
            // if(!$mail->Send()) {
            //     echo "Mailer Error: " . $mail->ErrorInfo;
            // } else {

            // }

            /////////////////////////////////////////////////////////////////////

            
      if($status=="Approved"){
          
          $sqll = $conn->prepare("SELECT balance FROM leave_balance WHERE employee_no='$emp_number' AND leave_type='$emp_leavetype'");
          $sqll->execute();
          $roww = $sqll->fetch();
          $balance = $roww['balance'];
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

  function addleave(){

      $leave_type = $_POST['leave_type'];
      $datefrom = $_POST['datefrom'];
      $dateto = $_POST['dateto'];
      $comment = $_POST['comment'];
      $stat = $_POST['stat'];
      $employeeno = $_POST['employeeno'];
      $date_applied = $_POST['date_applied'];
      $no_days = $_POST['no_days'];
      $updatedbalance = $_POST['updatedbalance'];
      $application_type = $_POST['application_type'];
      $points_todeduct = $_POST['points_todeduct'];
      $dayss = $_POST['dayss'];
      $date_from = $_POST['date_from'];
      $leave_bal = $_POST['leave_bal'];
      $pay_leave = $_POST['pay_leave'];
      if($application_type=="Whole Day"){
        $date_from = $datefrom;
      }
      $conn = $this->connect_mysql();
      $qry = $conn->prepare("INSERT INTO leave_application SET leave_type='$leave_type', datefrom='$datefrom', dateto='$dateto', comment='$comment', status='$stat', employeeno='$employeeno', date_applied='$date_applied',previous_bal='$leave_bal', no_days='$no_days',application_type='$application_type',deduct_rate='$points_todeduct',fivepm='0',sixpm='$dayss',date_from='$date_from',pay_leave='$pay_leave'");
      $qry->execute();

      $qry2 = $conn->prepare("SELECT id,department,firstname,lastname FROM tbl_employee WHERE employeeno='$employeeno'");
      $qry2->execute();
      $row = $qry2->fetch();

      $department = $row['department'];
      $firstname = $row['firstname'];
      $lastname = $row['lastname'];
      $id = $row['id'];

      $qry3 = $conn->prepare("SELECT dept_head_email FROM contactinfo WHERE emp_id='$id'");
      $qry3->execute();
      $row2 = $qry3->fetch();


          /////////////////////////////////////////////////////////////////////

          require 'Exception.php';
          require 'PHPMailer.php';
          require 'SMTP.php';
          require 'PHPMailerAutoload.php';

          // $mail = new PHPMailer();
          // $mail->IsSMTP();
          // $mail->SMTPDebug = 0;
          // $mail->SMTPAuth = true;
          // $mail->Host = "mail.panamed.com.ph";
          // $mail->IsHTML(true);
          // $mail->Username = "no-reply@panamed.com.ph";
          // $mail->Password = "Unimex123!";
          // $mail->SetFrom("no-reply@panamed.com.ph", "");
          // $mail->Subject = "Leave Application";
          // $msg = $firstname.' '.$lastname.' applied '.$leave_type.' From: '.$datefrom.' To: '.$dateto;
          // $mail->Body = $msg;
          // $dept_head_email = $row2['dept_head_email'];
          // $mail->AddAddress($dept_head_email);
          // if(!$mail->Send()) {
          //     echo "Mailer Error: " . $mail->ErrorInfo;
          // } else {
          //     echo "success";
          // }

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
          $mail->Subject = "Leave Application";
          $msg = $firstname.' '.$lastname.' applied '.$leave_type.' From: '.$datefrom.' To: '.$dateto;
          $mail->Body = $msg;
          $dept_head_email = $row2['dept_head_email'];
          $mail->AddAddress($dept_head_email);
          if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
          } else {
            echo "success";
          }

          /////////////////////////////////////////////////////////////////////

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

  function loadmyleave(){

    $employeeno = $_GET['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno
                             WHERE a.employeeno='$employeeno' ORDER BY a.id DESC");
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
          if($balanse < 0 ){
            $balanse = 0;
          }
          $fname = utf8_decode($x['firstname'].' '.$x['lastname']);
          $data = array();
          
          $data['employeeno'] = utf8_decode($x['firstname'].' '.$x['lastname']);
          $data['date'] = $x['date_applied'];
          $data['leavetype'] = $x['leave_type'];

          $data['leavebalance'] = $balanse;
          $stados = $x['status'];
          if($stados=="Pending"){
            $data['numberofdays'] = "";
            $data['action'] = '<center>
            <button onclick="edit_leave('.$x['idd'].',\''.$fname.'\',\''.$x['employeeno'].'\',\''.$x['leave_type'].'\',\''.$x['date_applied'].'\',\''.$x['leave_balance'].'\',\''.$x['datefrom'].'\',\''.$x['dateto'].'\',\''.$x['no_days'].'\',\''.$x['status'].'\',\''.$x['comment'].'\',\''.$x['remarks'].'\',\''.$x['application_type'].'\',\''.$x['deduct_rate'].'\','.$x['fivepm'].','.$x['sixpm'].',\''.$balanse.'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i> View</button>
            <button onclick="delete_leave('.$x['idd'].')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>
            </center>
            ';

          }else{

            
            if($x['pay_leave']=="Without Pay"){
              $data['numberofdays'] = 0;
            }else{
              $data['numberofdays'] = $x['no_days'];
            }
            $data['action'] = '<center>
            <button onclick="edit_leave('.$x['idd'].',\''.$fname.'\',\''.$x['employeeno'].'\',\''.$x['leave_type'].'\',\''.$x['date_applied'].'\',\''.$x['leave_balance'].'\',\''.$x['datefrom'].'\',\''.$x['dateto'].'\',\''.$x['no_days'].'\',\''.$x['status'].'\',\''.$x['comment'].'\',\''.$x['remarks'].'\',\''.$x['application_type'].'\',\''.$x['deduct_rate'].'\','.$x['fivepm'].','.$x['sixpm'].',\''.$balanse.'\')" style="font-size:10px;color: white;background: #4c91cd;border-color: #4c91cd;"><i class="fa fa-eye"></i> View</button>
            <button disabled="" onclick="delete_leave('.$x['idd'].')" style="font-size:10px;color: white;background: #ff8080;border-color: #ff8080;"><i class="fa fa-trash"></i> Delete</button>
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
          
          $fname = utf8_decode($x['firstname'].' '.$x['lastname']);
          $data = array();
          $data['action'] = '<center>
          <button onclick="edit_leave('.$x['idd'].',\''.$fname.'\',\''.$x['employeeno'].'\',\''.$x['leave_type'].'\',\''.$x['date_applied'].'\',\''.$x['leave_balance'].'\',\''.$x['datefrom'].'\',\''.$x['dateto'].'\',\''.$x['no_days'].'\',\''.$x['status'].'\',\''.$x['comment'].'\',\''.$x['remarks'].'\',\''.$x['application_type'].'\',\''.$x['deduct_rate'].'\','.$x['fivepm'].','.$x['sixpm'].',\''.$balanse.'\',\''.$x['pay_leave'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i> View</button> 
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

  function loadleavelistreport(){

    $filter_type = $_GET['filter_type'];
    $filter_from = $_GET['filter_from'];
    $filter_to = $_GET['filter_to'];

        $conn = $this->connect_mysql();
        if($filter_type=="All"){
          $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                                 LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno ORDER BY a.id DESC");
        }else{
          $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                                 LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.status='$filter_type' AND a.date_applied BETWEEN '$filter_from' AND '$filter_to' ORDER BY a.id DESC");
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

              
              $fname = utf8_decode($x['firstname'].' '.$x['lastname']);
              $data = array();
              $data['action'] = '<center>
              <button onclick="edit_leave('.$x['idd'].',\''.$fname.'\',\''.$x['employeeno'].'\',\''.$x['leave_type'].'\',\''.$x['date_applied'].'\',\''.$x['leave_balance'].'\',\''.$x['datefrom'].'\',\''.$x['dateto'].'\',\''.$x['no_days'].'\',\''.$x['status'].'\',\''.$x['comment'].'\',\''.$x['remarks'].'\',\''.$x['application_type'].'\',\''.$x['deduct_rate'].'\','.$x['fivepm'].','.$x['sixpm'].',\''.$balanse.'\')" style="font-size:10px;color: white;background: #4c91cd;border-color: #4c91cd;"><i class="fa fa-eye"></i> View</button>
              
              </center>
              ';
              $data['employeeno'] = utf8_decode($x['firstname'].' '.$x['lastname']);
              $apptype = $x['application_type'];
              
              $dateffrom = $x['date_from'];
              if($apptype=="Whole Day"){
                $dateffrom = $x['dateto'];
              }
              $data['date_from'] = $x['date_from'];
              $data['date_to'] =  $dateffrom;
              $data['leavetype'] = $x['leave_type'];
              if ($balanse < 0){
                $balanse = 0;
              }
              $data['leavebalance'] = $balanse;
              if($x['pay_leave']=="Without Pay"){
                $data['numberofdays'] = 0;
              }else if($x['status']=="Disapproved"){
                $data['numberofdays'] = 0;
              }else{
                $data['numberofdays'] = $x['no_days'];
              }
              // $data['numberofdays'] = $x['no_days'];
              $data['active_status'] = $x['status'];

            $return[] = $data;
          }
        
        echo json_encode(array('data'=>$return));
  }

  public function getLeaveapplication($filter_type,$filter_from,$filter_to)
  {
      $conn = $this->connect_mysql();
      if($filter_type=="All"){
        $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno ORDER BY a.id DESC");
      }else{
        $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.status='$filter_type' AND a.date_applied BETWEEN '$filter_from' AND '$filter_to' ORDER BY a.id DESC");
      }
      $query->execute();
      $row = $query->fetchAll();
      return $row;
  }

  public function getbalance($leave_type,$employeeno)
  {
      $conn = $this->connect_mysql();
      $sql = $conn->prepare("SELECT balance FROM leave_balance WHERE  leave_type='$leave_type' AND employee_no='$employeeno'");
      $sql->execute();
      $rowww = $sql->fetch();
      $balanse = $rowww['balance'];
      if ($balanse < 0) {
          $balanse = 0;
      }
      return $balanse;
  }


}

$x = new crud();

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

/////////////////////////////////////////////////////////////////////

// if(isset($_GET['update_deductleave'])){
//   $x->update_deductleave();
// }

/////////////////////////////////////////////////////////////////////

if(isset($_GET['approveleave'])){
  $x->approveleave();
}

if(isset($_GET['addleave'])){
  $x->addleave();
}

if(isset($_GET['readleave'])){
  $x->readleave();
}

if(isset($_GET['readpayslip'])){
  $x->readpayslip();
}

if(isset($_GET['loadmyleave'])){
  $x->loadmyleave();
}

if(isset($_GET['loadleavelist'])){
  $x->loadleavelist();
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

if(isset($_GET['loadleavelistreport'])){
  $x->loadleavelistreport();
}


 ?>
