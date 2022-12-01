<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{
// jerico
  function loademployee(){
    $statusdd = $_GET['statusdd'];
    $conn = $this->connect_mysql();
    $query = "";
    if($statusdd=="All"){

      $query = $conn->prepare("SELECT a.*,a.id as idd,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id ORDER BY a.lastname ASC");
    
    }else if($statusdd=="Active"){

      $query = $conn->prepare("SELECT a.*,a.id as idd,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id
                             WHERE a.statuss='Active' ORDER BY a.lastname ASC");

    }else if($statusdd=="Inactive"){

      $query = $conn->prepare("SELECT a.*,a.id as idd,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id
                             WHERE a.statuss='Inactive' ORDER BY a.lastname ASC");
    
    }
    $query->execute();
    $row = $query->fetchAll();
    $return = array();

      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {

          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);

          }
          $data = array();
          $data['action'] = '<center><button title="View" onclick="editemp('.$x['idd'].')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i></button>
          <button title="Delete" onclick="deleteemp('.$x['idd'].')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button></center>';
          $imge = utf8_decode($x['imagepic']);
          $picture = "personal_picture/".$imge;
          if($x['imagepic']==""){
            $picture = "usera.png";
          }
          $data['pic'] = '<img src='.$picture.' style="width:40px;height:40px;border-radius:10%">';
          $data['employeeno'] = $x['employeeno'];
          $data['lastname'] = utf8_decode($x['lastname']);
          $data['firstname'] = $x['firstname'];
          $data['middlename'] = $x['middlename'];
          $data['birthdate'] = $x['dateofbirth'];

          $from = new DateTime($x['dateofbirth']);
          $to   = new DateTime('today');
          $age = $from->diff($to)->y;

          if($age> 1000){
            $age = "";
          }

          $data['age'] = $age;

          $data['gender'] = $x['gender'];
          $data['employment_status'] = $x['employment_status'];
          $data['company'] = $x['company'];
          $data['job_title'] = $x['job_title'];
          $data['job_category'] = $x['job_category'];
        
        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }
// jerico
  function deleteemployee(){

    $id = $_POST['id'];

    $conn = $this->connect_mysql();

    $que = $conn->prepare("SELECT employeeno FROM tbl_employee WHERE id='$id'");
    $que->execute();
    $row = $que->fetch();
    $emplono = $row['employeeno'];

    $qry0 = $conn->prepare("DELETE FROM leave_balance WHERE employee_no='$emplono'");
    $qry0->execute();

    $qry0 = $conn->prepare("DELETE FROM user_account WHERE employeeno='$emplono'");
    $qry0->execute();

    $qry = $conn->prepare("DELETE FROM tbl_employee WHERE id='$id'");
    $qry->execute();

    $qry1 = $conn->prepare("DELETE FROM contactinfo WHERE emp_id='$id'");
    $qry1->execute();

    $qry2 = $conn->prepare("DELETE FROM contractinfo WHERE emp_id='$id'");
    $qry2->execute();

    $qry3 = $conn->prepare("DELETE FROM govtidinfo WHERE emp_id='$id'");
    $qry3->execute();

    $qry4 = $conn->prepare("DELETE FROM otherpersonalinfo WHERE emp_id='$id'");
    $qry4->execute();

    $qry5 = $conn->prepare("DELETE FROM benefitsinfo WHERE emp_id='$id'");
    $qry5->execute();

    $qry6 = $conn->prepare("DELETE FROM disciplinarytracking WHERE emp_id='$id'");
    $qry6->execute();

    $qry7 = $conn->prepare("DELETE FROM otheridinfo WHERE emp_id='$id'");
    $qry7->execute();

    $qry8 = $conn->prepare("DELETE FROM previous_empinfo WHERE emp_id='$id'");
    $qry8->execute();

    $qry9 = $conn->prepare("DELETE FROM medicalinfo WHERE emp_id='$id'");
    $qry9->execute();

    session_start();
    $useraction = $_SESSION['fullname'];
    $dateaction = date('Y-m-d');
    $auditaction = "Deleted an Employee.";
    $audittype = "Delete";
    $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
    $q->execute();

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
  function department() {
    $conn=$this->connect_mysql();
    $sql = $conn->prepare("SELECT * FROM department ORDER BY department ASC");
    $sql->execute();
    $option = '<option value="" disabled="" selected="">--Select Department--</option>';
    while($row=$sql->fetch()){ $option.='<option value="'.$row['department'].'">'.$row['department'].'</option>';}
    echo $option;
  }

  function job_title() {
    $conn=$this->connect_mysql();
    $sql = $conn->prepare("SELECT * FROM job_titles ORDER BY job_title ASC");
    $sql->execute();
    $option = '<option value="" disabled="" selected="">--Select Job title--</option>';
    while($row=$sql->fetch()){ $option.='<option value="'.$row['job_title'].'">'.$row['job_title'].'</option>';}
    echo $option;
  }

  function job_category() {
    $conn=$this->connect_mysql();
    $sql = $conn->prepare("SELECT * FROM job_categories ORDER BY job_category ASC");
    $sql->execute();
    $option = '<option value="" disabled="" selected="">--Select Job Category--</option>';
    while($row=$sql->fetch()){ $option.='<option value="'.$row['job_category'].'">'.$row['job_category'].'</option>';}
    echo $option;
  }

  // Auto generate employee number
  function generateEmployeeNumber() {
    $conn=$this->connect_mysql();
    $sql = $conn->prepare("SELECT MAX(id_number) AS latestIdNumber, MAX(employeeno) AS latestEmployeeNumber FROM tbl_employee");
    $sql->execute();
    while($row=$sql->fetch()){
      $latestEmployeeNumber = $row['latestEmployeeNumber'];
      $latestIdNumber = $row['latestIdNumber'] + 1;
    }
    $latestEmployeeNumber = explode("-", $latestEmployeeNumber);
    $separator = "-";
    if($latestIdNumber < 100) {
      $separator = "-0";
    }
    if($latestIdNumber < 10) {
      $separator = "-00";
    }
    $generatedEmployeeId = $latestEmployeeNumber[0]. $separator .$latestIdNumber;

    $data = array();
    $data['generatedEmployeeId'] = $generatedEmployeeId;
    $data['latestIdNumber'] = $latestIdNumber;
    echo json_encode(array('data'=>$data));
  }

  function addnewemployee(){
   
    $employeeno = $_POST['employeeno'];
    $id_number = $_POST['id_number'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $employment_status = $_POST['employment_status'];
    $company = $_POST['company'];
    $statuss = $_POST['statuss'];
    $job_title = $_POST['job_title'];
    $job_category = $_POST['job_category'];
    $department = $_POST['department'];
    $corp_email = $_POST['corp_email'];
    $contact_no = $_POST['contact_no'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $dateofbirth = $_POST['dateofbirth'];
    $age = $_POST['age'];
    $birth_place = $_POST['birth_place'];
    $marital_status = $_POST['marital_status'];
    $street = $_POST['street'];
    $municipality = $_POST['municipality'];
    $province = $_POST['province'];
    $tin = $_POST['tin'];
    $sss = $_POST['sss'];
    $phic = $_POST['phic'];
    $hdmf = $_POST['hdmf'];
    $atm = $_POST['atm'];
    $bank_name = $_POST['bank_name'];
    $nationality = $_POST['nationality'];
    $personal_email = $_POST['personal_email'];
    $dept_head_email = $_POST['dept_head_email'];
    $date_hired = $_POST['date_hired'] != '' ? $_POST['date_hired'] : '0000-00-00';
    $eoc = $_POST['eoc'] != '' ? $_POST['eoc'] : '0000-00-00';
    $regularized = $_POST['regularized'] != '' ? $_POST['regularized'] : '0000-00-00';
    if(!empty($_FILES["profile"]["name"])) {
      $target_dir = "../personal_picture/";
      $file = $_FILES['profile']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['profile']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $profile = str_replace(' ', '', $name[0])."-".$today.".".$ext;
      $path_filename_ext = $target_dir.$profile;

      move_uploaded_file($temp_name,$path_filename_ext);

    } else {
      $profile = 'usera.png';
    }

    if(!empty($_FILES["marriageContract"]["name"])) {
      $target_dir = "../documents/".$employeeno."/";
      $file = $_FILES['marriageContract']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['marriageContract']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $marriageContract = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir;
      if(!is_dir($path_filename_ext)){
        mkdir($path_filename_ext, 0755);
      }
      $path_filename_ext .= $marriageContract;

      move_uploaded_file($temp_name,$path_filename_ext);

    } else {
      $marriageContract = '';
    }

    if(!empty($_FILES["dependent"]["name"])) {
      $target_dir = "../documents/".$employeeno."/";
      $file = $_FILES['dependent']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['dependent']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $dependent = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir;
      if(!is_dir($path_filename_ext)){
        mkdir($path_filename_ext, 0755);
      }
      $path_filename_ext .= $dependent;

      move_uploaded_file($temp_name,$path_filename_ext);

    } else {
      $dependent = '';
    }

    if(!empty($_FILES["additionalId"]["name"])) {
      $target_dir = "../documents/".$employeeno."/";
      $file = $_FILES['additionalId']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['additionalId']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $additionalId = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir;
      if(!is_dir($path_filename_ext)){
        mkdir($path_filename_ext, 0755);
      }
      $path_filename_ext .= $additionalId;

      move_uploaded_file($temp_name,$path_filename_ext);

    } else {
      $additionalId = '';
    }

    if(!empty($_FILES["proofOFBilling"]["name"])) {
      $target_dir = "../documents/".$employeeno."/";
      $file = $_FILES['proofOFBilling']['name'];
      $path = pathinfo($file);
      // $proofOFBilling = $path['filename'];
      $ext = $path['extension'];
      // $attachfile = $filename.".".$ext;
      $temp_name = $_FILES['proofOFBilling']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $proofOFBilling = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir;
      if(!is_dir($path_filename_ext)){
        mkdir($path_filename_ext, 0755);
      }
      $path_filename_ext .= $proofOFBilling;

      move_uploaded_file($temp_name,$path_filename_ext);

    } else {
      $proofOFBilling = '';
    }

    $conn = $this->connect_mysql();
    $query = $conn->prepare("INSERT INTO tbl_employee SET employeeno='$employeeno', id_number='$id_number', lastname='$lastname', firstname='$firstname', middlename='$middlename', rank='',statuss='$statuss' ,employment_status='$employment_status', company='$company',reimbursement_bal='3500', imagepic='$profile', leave_balance='0', job_title='$job_title', job_category='$job_category', department='$department'");
    $query->execute();

    $id = $conn->lastInsertId();

    $fullname = $firstname." ".$lastname;
    $username = $firstname.".".$lastname;

    $squery = $conn->prepare("INSERT INTO user_account SET employeeno='$employeeno', fullname='$fullname', username='$username', password='$password', empstatus='active', usertype='employee', userrole='3',approver='no'");
    $squery->execute();
    $qry1 = $conn->prepare("INSERT INTO contactinfo SET emp_id='$id', street='$street', municipality='$municipality', province='$province', contactno='$contact_no', telephoneno='', corp_email='$corp_email', personal_email='$personal_email', nationality='$nationality', driver_license='', driver_expdate='0000-00-00', dept_head_email='$dept_head_email'");
    $qry1->execute();

    $qry2 = $conn->prepare("INSERT INTO contractinfo SET emp_id='$id', date_hired='$date_hired', eoc='$eoc', regularized='$regularized', preterm='0000-00-00', resigned='0000-00-00', retired='0000-00-00', terminatedd='0000-00-00', lastpay='0000-00-00', remarks=''");
    $qry2->execute();

    $qry3 = $conn->prepare("INSERT INTO govtidinfo SET emp_id='$id', tin_no='$tin', sss_no='$sss', phic_no='$phic', hdmf_no='$hdmf', atm_no='$atm', bank_name='$bank_name', sss_remarks='', phic_remarks='', hdmf_remarks=''");
    $qry3->execute();

    $qry4 = $conn->prepare("INSERT INTO otherpersonalinfo SET emp_id='$id', nickname='', dateofbirth='$dateofbirth', gender='$gender', height='', weight='', marital_status='$marital_status', birth_place='$birth_place', blood_type='', contact_name='', contact_address='', contact_telno='', contact_celno='', contact_relation=''");
    $qry4->execute();

    $qry5 = $conn->prepare("INSERT INTO benefitsinfo SET emp_id='$id', dependent1='', age1='', sex1='', dependent2='', age2='', sex2='', dependent3='', age3='', sex3='', dependent4='', age4='', sex4='', dependent5='', age5='', sex5='', relation1='', relation2='', relation3='', relation4='', relation5=''");
    $qry5->execute();

    $qry6 = $conn->prepare("INSERT INTO disciplinarytracking SET emp_id='$id', violation='', specifc_offense='', of_offense='', dateissued='0000-00-00', datecommitted='0000-00-00', action=''");
    $qry6->execute();

    $qry7 = $conn->prepare("INSERT INTO otheridinfo SET emp_id='$id', comp_id_dateissue='0000-00-00', comp_id_vdate='0000-00-00', fac_ap_dateissue='0000-00-00', fac_ap_vdate='0000-00-00', card_number='', driver_id='', driver_exp='0000-00-00', prc_number='', prc_exp='0000-00-00', civil_service=''");
    $qry7->execute();

    $qry8 = $conn->prepare("INSERT INTO previous_empinfo SET emp_id='$id', company1='', naturebusiness1='', year1='', position1='', rate1='', company2='', naturebusiness2='', year2='', position2='', rate2='', yearend1='', yearend2=''");
    $qry8->execute();

    $qry9 = $conn->prepare("INSERT INTO medicalinfo SET emp_id='$id', type1='', classification1='', status1='', dateofexam1='0000-00-00', remarks1='', type2='', classification2='', status2='', dateofexam2='0000-00-00', remarks2='', type3='', classification3='', status3='', dateofexam3='0000-00-00', remarks3=''");
    $qry9->execute();

    // // $qry10 = $conn->prepare("INSERT INTO employee_documents (employee_number, marriage_contract, dependent, additional_id, proof_of_billing) VALUES ('$employeeno', '$marriageContract', '$dependent', '$additionalId', '$proofOFBilling')");
    // // $qry10->execute();

    $query10 = $conn->prepare("INSERT INTO marriage_contract (employee_number, marriage_contract) VALUES ('$employeeno', '$marriageContract')");
    $query10->execute();
    $query11 = $conn->prepare("INSERT INTO dependents (employee_number, dependent) VALUES ('$employeeno', '$dependent')");
    $query11->execute();
    $query12 = $conn->prepare("INSERT INTO additional_id (employee_number, additional_id) VALUES ('$employeeno', '$additionalId')");
    $query12->execute();
    $query13 = $conn->prepare("INSERT INTO proof_of_billing (employee_number, proof_of_billing) VALUES ('$employeeno', '$proofOFBilling')");
    $query13->execute();

    $query14 = $conn->prepare("INSERT INTO leave_balance SET employee_no='$employeeno',leave_type='SL',balance='0',earned='no',what_month='0', stat='', decem=''");
    $query14->execute();

    $query15 = $conn->prepare("INSERT INTO leave_balance SET employee_no='$employeeno',leave_type='VL',balance='0',earned='no',what_month='0', stat='', decem=''");
    $query15->execute();

    session_start();
    $useraction = $_SESSION['fullname'];
    $dateaction = date('Y-m-d');
    $auditaction = "Added new Employee. Employee no ".$employeeno;
    $audittype = "Add";
    $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
    $q->execute();


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
            // $mail->Subject = "Your Personal User Account";
            // $msg = 'Username: '.$username.'<br>Password: '.$password.'<br><br> You may login here --> https://panamed.com.ph/hris';
            // $mail->Body = $msg;
            // $mail->AddAddress($corp_email);
            // if(!$mail->Send()) {
            //     echo "Mailer Error: " . $mail->ErrorInfo;
            // } else {
            // }
  
  }

  public function getemployee($type,$from,$to)
  {
      $conn = $this->connect_mysql();
      if($type=="all"){
    
        $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id";
      }else if($type=="bday"){
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE EXTRACT(MONTH FROM c.dateofbirth) BETWEEN '$from' AND '$to'";
      }else if($type=="gender"){
          if($from=="All"){
              $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id";
          }else{
              $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE c.gender='$from'";
          }
         
      }else if($type=="employment"){
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE a.employment_status='$from'";
      }else if($type=="division"){
      
          $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE a.department='$from' ORDER BY a.lastname ASC";
      }else if($type=="job_category"){
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE a.job_category='$from'";
      }else if($type=="age"){
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id
          WHERE YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) BETWEEN '$from' AND '$to'";
      }else if($type=="evaluation"){
        
        $query = "SELECT a.*,b.*,c.*,
           YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                            LEFT JOIN contractinfo b ON a.id=b.emp_id
                            LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id
         WHERE (YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5))) AND (YEAR(date_hired) = YEAR(DATE(NOW() - INTERVAL '$from' MONTH)) AND MONTH(date_hired) = MONTH(DATE(NOW() - INTERVAL '$from' MONTH)) AND DAY(date_hired) >= DAY(DATE(NOW() - INTERVAL '$from' MONTH))) ORDER BY a.lastname ASC";
     }else{
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE b.date_hired BETWEEN '$from' AND '$to'";
      }
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $row = $stmt->fetchAll();
      return $row;
  }

  function updateEmployeeMasterfile() {
    require('../PHPExcel/PHPExcel.php');
    require('../PHPExcel/PHPExcel/IOFactory.php');
    $file = $_FILES['file']['tmp_name'];
    $obj = PHPExcel_IOFactory::load($file);
    foreach($obj->getWorksheetIterator() as $sheet) {
        $getHighestRow = $sheet->getHighestRow();
        $getHighestColumn = $sheet->getHighestDataColumn();
        $getHighestColumnIndex = PHPExcel_Cell::columnIndexFromString($getHighestColumn);
        
        $conn = $this->connect_mysql();
        $sql = "INSERT INTO tbl_employee (employeeno, id_number, lastname, firstname,	middlename, rank, statuss, employment_status, company, imagepic, leave_balance, job_title, job_category, department, reimbursement_bal) VALUES ";
        $values = array();

        for ($row = 2; $row <= $getHighestRow; $row++) {
            $employeeno = $sheet->getCellByColumnAndRow(0, $row)->getValue();
            $id_number = (int)$sheet->getCellByColumnAndRow(1, $row)->getValue();
            $lastname = $sheet->getCellByColumnAndRow(2, $row)->getValue();
            $firstname = $sheet->getCellByColumnAndRow(3, $row)->getValue();
            $middlename = $sheet->getCellByColumnAndRow(4, $row)->getValue();
            $rank = $sheet->getCellByColumnAndRow(5, $row)->getValue();
            $statuss = $sheet->getCellByColumnAndRow(6, $row)->getValue();
            $employment_status = $sheet->getCellByColumnAndRow(7, $row)->getValue();
            $company = $sheet->getCellByColumnAndRow(8, $row)->getValue();
            $imagepic = 'usera.png';
            $job_title = $sheet->getCellByColumnAndRow(9, $row)->getValue();
            $job_category = $sheet->getCellByColumnAndRow(10, $row)->getValue();
            $department = $sheet->getCellByColumnAndRow(11, $row)->getValue();
            $values[] = "('$employeeno', '$id_number', '$lastname', '$firstname', '$middlename', '$rank', '$statuss', '$employment_status', '$company', '$imagepic', '0', '$job_title', '$job_category', '$department', '3500')";
        }
        // print_r(implode(',', $values));
        $sql .= implode(',', $values);
        
        $query = $conn->prepare($sql);
        $query->execute();
        echo 'success';
    }
  }

  // function sendNotificationEvaluation() {
  //   // SEnd notification for employees who is for regularization and 18th month evaluation
  //   $conn = $this->connect_mysql();
  //   $stmt18Month = $conn->prepare("SELECT a.*,b.*,c.*,
  //       YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
  //       LEFT JOIN contractinfo b ON a.id=b.emp_id
  //       LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id
  //       WHERE (YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5))) AND (YEAR(date_hired) = YEAR(DATE(NOW() - INTERVAL 18 MONTH)) AND MONTH(date_hired) = MONTH(DATE(NOW() - INTERVAL 18 MONTH)) AND DAY(date_hired) >= DAY(DATE(NOW() - INTERVAL 18 MONTH))) ORDER BY a.lastname ASC");
  //   $stmt18Month->execute();
  //   $eighteenMonths = $stmt18Month->fetchAll();

  //   $stmtRegular = $conn->prepare("SELECT a.*,b.*,c.*,
  //       YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
  //       LEFT JOIN contractinfo b ON a.id=b.emp_id
  //       LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id
  //       WHERE (YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5))) AND (YEAR(date_hired) = YEAR(DATE(NOW() - INTERVAL 6 MONTH)) AND MONTH(date_hired) = MONTH(DATE(NOW() - INTERVAL 6 MONTH)) AND DAY(date_hired) >= DAY(DATE(NOW() - INTERVAL 6 MONTH))) ORDER BY a.lastname ASC");
  //   $stmtRegular->execute();
  //   $regulars = $stmtRegular->fetchAll();
    
  //   require 'Exception.php';
  //   require 'PHPMailer.php';
  //   require 'SMTP.php';
  //   require 'PHPMailerAutoload.php';

  //   $mail = new PHPMailer();
  //   $mail->IsSMTP();
  //   $mail->SMTPDebug = 0;
  //   $mail->SMTPAuth = true;
  //   $mail->SMTPSecure = 'ssl';
  //   $mail->Host = "smtp.gmail.com";
  //   $mail->Port = 465;
  //   $mail->IsHTML(true);
  //   $mail->Username = "pmcmailchimp@gmail.com";
  //   $mail->Password = "qyegdvkzvbjihbou";
  //   $mail->SetFrom("no-reply@panamed.com.ph", "");

  //   if(count($regulars) > 0 ) {
  //     $namesRegulars = array();
  //     $message = "<strong>Due for Evaluation - Regularization</strong><br />"; 
  //     foreach($regulars as $regular) {
  //       $message .= "<strong>Name: </strong>". " " .$regular['firstname']. " " .$regular['lastname']. "<br /><strong>Regularization Date: </strong>". date('Y-m-d', strtotime("+6 months", strtotime($regular['date_hired']))). "<br /><br />";
  //     }

  //     // Send notification for regularization evaluation of employees
  //     $mail->Subject = "Due for Evaluation - Regularization";
  //     $mail->Body = $message;
  //     $mail->isHTML(true);
  //     // $dept_head_email = $row2['dept_head_email'];
  //     $mail->AddAddress('bumacodejhay@gmail.com');
  //     if(!$mail->Send()) {
  //       echo "Mailer Error: " . $mail->ErrorInfo;
  //     } else {
  //       echo "Success";
  //     }
  //   }
  //   if(count($eighteenMonths) > 0 ) {
  //     $namesEighteenMonths = array();
  //     $message = "<strong>Due for Evaluation - 18th month Evaluation</strong><br />"; 
  //     foreach($eighteenMonths as $eighteenMonth) {
  //       $message .= "<strong>Name: </strong>". " " .$eighteenMonth['firstname']. " " .$eighteenMonth['lastname']. "<br /><strong>18th Month on: </strong>". date('Y-m-d', strtotime("+18 months", strtotime($eighteenMonth['date_hired']))). "<br /><br />";
  //     }

  //     // Send notification for 18 month evaluation of employees
  //     $mail->Subject = "Due for Evaluation - 18th month Evaluation";
  //     $mail->Body = $message;
  //     $mail->isHTML(true);
  //     // $dept_head_email = $row2['dept_head_email'];
  //     $mail->AddAddress('bumacodejhay@gmail.com');
  //     if(!$mail->Send()) {
  //       echo "Mailer Error: " . $mail->ErrorInfo;
  //     } else {
  //       echo "Success";
  //     }
  //   }

  // }


}

$x = new crud();

if(isset($_GET['loademployee'])){
  $x->loademployee();
}
if(isset($_GET['deleteemployee'])){
  $x->deleteemployee();
}
if(isset($_GET['demp_stat'])){
  $x->demp_stat();
}
if(isset($_GET['dcompany'])){
  $x->dcompany();
}
if(isset($_GET['department'])){
  $x->department();
}
if(isset($_GET['job_title'])){
  $x->job_title();
}
if(isset($_GET['job_category'])){
  $x->job_category();
}
if(isset($_GET['addnewemployee'])){
  $x->addnewemployee();
}
if(isset($_GET['generateEmployeeNumber'])){
  $x->generateEmployeeNumber();
}
if(isset($_GET['updateEmployeeMasterfile'])){
  $x->updateEmployeeMasterfile();
}
// if(isset($_GET['sendNotificationEvaluation'])){
//   $x->sendNotificationEvaluation();
// }




 ?>