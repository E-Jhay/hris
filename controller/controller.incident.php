<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{
  function load_employee_incident(){
    
    $employee_number = $_GET['employee'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM incident WHERE employeeno = '$employee_number' ORDER BY date DESC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
    foreach ($row as $x){

    foreach ($x as $key => $input_arr) {
    $x[$key] = addslashes($input_arr);
    $x[$key] = utf8_encode($input_arr);
    }
    $editBtn = $x['status'] == 'active' ? '' : 'disabled';
    $editText = $x['status'] == 'active' ? 'Edit' : 'Acknowledge';
    $editTitle = $x['status'] == 'active' ? 'Edit Incident Report' : '';
    $data = array();
    $data['action'] = '<div class="text-center">
    <button title="'.$editTitle.'" style="background-color: green; color: white" onclick="editIncident('.$x['id'].',\''.$x['title'].'\',\''.$x['description'].'\',\''.$x['file_name'].'\')" class="btn btn-sm" '.$editBtn.'><i class="fas fa-sm fa-eye"></i>  '.$editText.'</button>'
    ;
    if($x['status'] == 'pending') {
      $data['action'] .= ' <button title="Delete" onclick="delete_incident('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button></div>';
    }

    $data['title'] = ucfirst($x['title']);
    $data['description'] = strlen($x['description']) > 20 ? ucfirst(substr($x['description'], 0, 20))."..." : ucfirst($x['description']);
    $data['date'] = date('F d, Y',strtotime($x['date']));
    $data['status'] = ucfirst($x['status']);
    $data['file'] = '<div class="text-center">
        <button title="View File" onclick="viewFile(\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-primary btn-sm"><i class="fas fa-sm fa-eye"></i> View File</button>
        </div>';
    $return[] = $data;
    }
    
    echo json_encode(array('data'=>$return));
  }
  function load_employee_incident_all(){
    
    $status = $_GET['status'];
    
    $conn = $this->connect_mysql();
    if($status == 'all'){
      $query = $conn->prepare("SELECT * FROM incident ORDER BY date DESC");
    } else {
      $query = $conn->prepare("SELECT * FROM incident WHERE status = '$status' ORDER BY date DESC");
    }
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
    foreach ($row as $x){

    foreach ($x as $key => $input_arr) {
    $x[$key] = addslashes($input_arr);
    $x[$key] = utf8_encode($input_arr);
    }
    
    // $editBtn = $x['status'] == 'active' ? '' : 'disabled';
    // $editTitle = $x['status'] == 'active' ? 'Acknowledge Incident Report' : 'Acknowledged';
    // $data = array();
    $data['action'] = '<div class="text-center">
    <button title="View details" style="background-color: green; color: white" onclick="editIncident('.$x['id'].',\''.$x['title'].'\',\''.$x['description'].'\',\''.$x['file_name'].'\',\''.$x['employeeno'].'\',\''.$x['date'].'\',\''.$x['status'].'\')" class="btn btn-sm"><i class="fas fa-sm fa-eye"></i>  Details</button>
    </div>';

    $data['title'] = ucfirst($x['title']);
    $data['description'] = strlen($x['description']) > 20 ? ucfirst(substr($x['description'], 0, 20))."..." : ucfirst($x['description']);
    $data['date'] = date('F d, Y',strtotime($x['date']));
    $data['status'] = ucfirst($x['status']);
    $data['file'] = '<div class="text-center">
        <button title="View File" onclick="viewFile(\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-primary btn-sm"><i class="fas fa-sm fa-eye"></i> View File</button>
        </div>';
    $return[] = $data;
    }
    
    echo json_encode(array('data'=>$return));
  }

  function addIncidentReport(){

    if (($_FILES['incidentFile']['name']!="")){
        $employee_number = $_POST['employee_number'];
        $incidentTitle = $_POST['incidentTitle'];
        $incidentDescription = $_POST['incidentDescription'];

        // Where the file is going to be stored
        $target_dir = "../incident_report/".$employee_number."/";
        $file = $_FILES['incidentFile']['name'];
        $path = pathinfo($file);
        $ext = $path['extension'];
        $temp_name = $_FILES['incidentFile']['tmp_name'];
        $today = date("Ymd");
        $name = explode(".", $file);
        $fileIncident = $name[0]."-".$today.".".$ext;
        $path_filename_ext = $target_dir;
        if(!is_dir($path_filename_ext)){
            mkdir($path_filename_ext, 0755);
        }
        $path_filename_ext .= $fileIncident;


        // Check if file already exists
        if (file_exists($path_filename_ext)) {
            echo json_encode(array('message' => 'An error has occured, File already Exist', 'type' => 'error'));
            exit;
        }else{
            $dateNow = date('Y-m-d');
            if(move_uploaded_file($temp_name,$path_filename_ext)) {
                $conn = $this->connect_mysql();
                $qry = $conn->prepare("INSERT INTO incident (employeeno, title, description, date, status, file_name) VALUES ('$employee_number', '$incidentTitle', '$incidentDescription', '$dateNow', 'pending', '$fileIncident')");
                $qry->execute();

                $qry2 = $conn->prepare("SELECT id,department,firstname,lastname FROM tbl_employee WHERE employeeno='$employee_number'");
                $qry2->execute();
                $row = $qry2->fetch();

                $department = $row['department'];
                $firstname = $row['firstname'];
                $lastname = utf8_decode($row['lastname']);
                $id = $row['id'];

                $qry3 = $conn->prepare("SELECT dept_head_email FROM contactinfo WHERE emp_id='$id'");
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
                $mail->SMTPSecure = 'ssl';
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 465;
                $mail->IsHTML(true);
                $mail->Username = "pmcmailchimp@gmail.com";
                $mail->Password = "qyegdvkzvbjihbou";
                $mail->SetFrom("no-reply@panamed.com.ph", "");
                
                $message = $firstname.' '.$lastname.' uploaded an incident report <br />Date: '.$dateNow;
                $mail->Subject = "Incident Report";
                $mail->Body = $message;
                $mail->isHTML(true);
                // $dept_head_email = $row2['dept_head_email'];
                $mail->AddAddress('bumacodejhay@gmail.com');
                $mail->AddCC('ejhaybumacod26@gmail.com');
                $mail->Send();

                echo json_encode(array('message' => 'Incident Report Submitted Successfully', 'type' => 'success'));
                exit;
            }            
        }       
    }
    else {
        echo json_encode(array('message' => 'Incident File is Required', 'type' => 'error'));
        exit;
    }

  }

  function deleteIncidentReport() {
    $id = $_POST['id'];
    $file_name = $_POST['file_name'];
    $employee_number = $_POST['employee_number'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("DELETE FROM incident WHERE id='$id'");
    $query->execute();

    $link_file = "../incident_report/".$employee_number."/".$file_name;
    unlink($link_file);
  }
  function updateIncidentReport() {
    $incident_id = $_POST['incident_id'];
    $incident_employee_number = $_POST['incident_employee_number'];
    $incident_title = $_POST['incident_title'];
    $incident_description = $_POST['incident_description'];
    $file_name_current = $_POST['file_name'];

    
    $conn = $this->connect_mysql();

    if($_FILES['incident_file']['size'] > 0) {

      // Where the file is going to be stored
      $target_dir = "../incident_report/".$incident_employee_number."/";
      $file = $_FILES['incident_file']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $attachfile = $filename.date('Y-m-d-His').".".$ext;
      $temp_name = $_FILES['incident_file']['tmp_name'];
      $path_filename_ext = $target_dir.$attachfile;


      // Check if file already exists
      if (file_exists($path_filename_ext)) {
        echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $incident_employee_number));
        exit;
      }
      else{
        if(!is_dir("../incident_report/".$incident_employee_number."/")){
          mkdir("../incident_report/".$incident_employee_number."/");
        }

        if(move_uploaded_file($temp_name,$path_filename_ext)){
          if($file_name_current != '' || $file_name_current != NULL){
            $link_file = $target_dir.$file_name_current;
            if(file_exists($link_file))
            unlink($link_file);
          }

          $squery = $conn->prepare("UPDATE incident SET title='$incident_title', description='$incident_description', file_name='$attachfile' WHERE id = '$incident_id'");
          $squery->execute();

          echo json_encode(array("message"=>"Incident Report Updated Successfully", "type" => "success", "employeeno" => $incident_employee_number));
          exit;
        }
        else {
          echo json_encode(array("message"=>"Incident File is required", "type" => "error", "employeeno" => $incident_employee_number));
          exit;
        }
      }
    }
    else {
      $query = $conn->prepare("UPDATE incident SET title='$incident_title', description='$incident_description' WHERE id = '$incident_id'");
      $query->execute();
      echo json_encode(array("message"=>"Incident Report Updated Successfully", "type" => "success", "employeeno" => $incident_employee_number));
      exit;
    }
  }
  function acknowledgeIncidentReport() {
    $incident_id = $_POST['incident_id'];
    $employeeno = $_POST['incident_employeeno'];
    $date = $_POST['incident_date'];
    $remarks = $_POST['remarks'];

    $conn = $this->connect_mysql();

    if($remarks && $incident_id) {
      $squery = $conn->prepare("UPDATE incident SET remarks='$remarks', status='acknowledged' WHERE id = '$incident_id'");
      $squery->execute();

      $qry2 = $conn->prepare("SELECT id,department,firstname,lastname FROM tbl_employee WHERE employeeno='$employeeno'");
      $qry2->execute();
      $row = $qry2->fetch();

      $department = $row['department'];
      $firstname = $row['firstname'];
      $lastname = utf8_decode($row['lastname']);
      $id = $row['id'];

      // $sqry2 = $conn->prepare("SELECT corp_email FROM contactinfo WHERE emp_id='$id'");
      // $sqry2->execute();
      // $srow2 = $sqry2->fetch();
      // $corp_email = $srow2['corp_email'];

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
      
      $message = 'Your incident report posted last '.$date.' has been acknowledge by HR<br /> Status: Acknowledged <br />Remarks: '.$remarks;
      $mail->Subject = "Incident Report";
      $mail->Body = $message;
      $mail->isHTML(true);
      // $dept_head_email = $row2['dept_head_email'];
      $mail->AddAddress('bumacodejhay@gmail.com');
      $mail->AddCC('ejhaybumacod26@gmail.com');
      $mail->Send();

      echo json_encode(array("message"=>"Incident Report Acknowledge", "type" => "success"));
      exit;
    }else {
      echo json_encode(array("message"=>"Sorry, remarks is required.", "type" => "error"));
      exit;
    }
  }

  function rejectIncidentReport() {
    $incident_id = $_POST['incident_id'];
    $employeeno = $_POST['incident_employeeno'];
    $date = $_POST['incident_date'];
    $remarks = $_POST['remarks'];

    $conn = $this->connect_mysql();

    if($remarks && $incident_id) {
      $squery = $conn->prepare("UPDATE incident SET remarks='$remarks', status='rejected' WHERE id = '$incident_id'");
      $squery->execute();

      $qry2 = $conn->prepare("SELECT id,department,firstname,lastname FROM tbl_employee WHERE employeeno='$employeeno'");
      $qry2->execute();
      $row = $qry2->fetch();

      $department = $row['department'];
      $firstname = $row['firstname'];
      $lastname = utf8_decode($row['lastname']);
      $id = $row['id'];

      $sqry2 = $conn->prepare("SELECT corp_email FROM contactinfo WHERE emp_id='$id'");
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
      $mail->SMTPSecure = 'ssl';
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->IsHTML(true);
      $mail->Username = "pmcmailchimp@gmail.com";
      $mail->Password = "qyegdvkzvbjihbou";
      $mail->SetFrom("no-reply@panamed.com.ph", "");
      
      $message = 'Your incident report posted last '.$date.' has been rejected by HR<br /> Status: Rejected <br /> Remarks: '.$remarks;
      $mail->Subject = "Incident Report";
      $mail->Body = $message;
      $mail->isHTML(true);
      // $dept_head_email = $row2['dept_head_email'];
      $mail->AddAddress('bumacodejhay@gmail.com');
      $mail->AddCC('ejhaybumacod26@gmail.com');
      $mail->Send();

      echo json_encode(array("message"=>"Incident Report Rejected", "type" => "success"));
      exit;
    }else {
      echo json_encode(array("message"=>"Sorry, remarks is required.", "type" => "error"));
      exit;
    }
  }
  function cancelIncidentReport() {
    $incident_id = $_POST['incident_id'];
    $employeeno = $_POST['incident_employeeno'];
    $date = $_POST['incident_date'];
    $remarks = $_POST['remarks'];

    $conn = $this->connect_mysql();

    if($incident_id) {
      $squery = $conn->prepare("UPDATE incident SET remarks='$remarks', status='pending' WHERE id = '$incident_id'");
      $squery->execute();

      $qry2 = $conn->prepare("SELECT id,department,firstname,lastname FROM tbl_employee WHERE employeeno='$employeeno'");
      $qry2->execute();
      $row = $qry2->fetch();

      $department = $row['department'];
      $firstname = $row['firstname'];
      $lastname = utf8_decode($row['lastname']);
      $id = $row['id'];

      $sqry2 = $conn->prepare("SELECT corp_email FROM contactinfo WHERE emp_id='$id'");
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
      $mail->SMTPSecure = 'ssl';
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 465;
      $mail->IsHTML(true);
      $mail->Username = "pmcmailchimp@gmail.com";
      $mail->Password = "qyegdvkzvbjihbou";
      $mail->SetFrom("no-reply@panamed.com.ph", "");
      
      $message = 'Your incident report posted last '.$date.' has been cancelled by HR<br />Status: Pending <br /> Remarks: '.$remarks;
      $mail->Subject = "Incident Report";
      $mail->Body = $message;
      $mail->isHTML(true);
      // $dept_head_email = $row2['dept_head_email'];
      $mail->AddAddress('bumacodejhay@gmail.com');
      $mail->AddCC('ejhaybumacod26@gmail.com');
      $mail->Send();

      echo json_encode(array("message"=>"Incident Report Cancelled", "type" => "success"));
      exit;
    }else {
      echo json_encode(array("message"=>"Sorry, remarks is required.", "type" => "error"));
      exit;
    }
  }
}

$x = new crud();

if(isset($_GET['load_employee_incident'])){
  $x->load_employee_incident();
}
if(isset($_GET['load_employee_incident_all'])){
  $x->load_employee_incident_all();
}
if(isset($_GET['addIncidentReport'])){
  $x->addIncidentReport();
}
if(isset($_GET['deleteIncidentReport'])){
  $x->deleteIncidentReport();
}
if(isset($_GET['updateIncidentReport'])){
  $x->updateIncidentReport();
}
if(isset($_GET['acknowledgeIncidentReport'])){
  $x->acknowledgeIncidentReport();
}
if(isset($_GET['rejectIncidentReport'])){
  $x->rejectIncidentReport();
}
if(isset($_GET['cancelIncidentReport'])){
  $x->cancelIncidentReport();
}

 ?>
