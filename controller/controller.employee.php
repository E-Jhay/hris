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

      $query = $conn->prepare("SELECT a.*,a.id as idd,a.employeeno as employee_no,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno ORDER BY a.lastname ASC");
    
    }else if($statusdd=="Active"){

      $query = $conn->prepare("SELECT a.*,a.id as idd,a.employeeno as employee_no,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno
                             WHERE a.statuss='Active' ORDER BY a.lastname ASC");

    }else if($statusdd=="Inactive"){

      $query = $conn->prepare("SELECT a.*,a.id as idd,a.employeeno as employee_no,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno
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
          $data['action'] = '<center class="d-flex justify-content-around"><button title="View more" onclick="editemp(\''.$x['employee_no'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i></button>
          <button title="Delete" onclick="deleteemp(\''.$x['employee_no'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button></center>';
          // $imge = utf8_decode($x['imagepic']);
          // $picture = "personal_picture/".$imge;
          // if($x['imagepic']==""){
          //   $picture = "usera.png";
          // }
          // if(!file_exists('../'.$picture)) $picture = "usera.png";
          
          if($x['imagepic'] == NULL || $x['imagepic'] == ''){
            $x['imagepic'] = 'personal_picture/usera.png';
          } else {
              if(!file_exists('../personal_picture/'.$x['employee_no'].'/'.$x['imagepic'])){
                $x['imagepic'] = utf8_decode('personal_picture/'.$x['imagepic']);
              } else {
                $x['imagepic'] = utf8_decode('personal_picture/'.$x['employee_no'].'/'.$x['imagepic']);
              }
          }
          $data['pic'] = '<img src="'.$x['imagepic'].'" style="width:40px;height:40px;border-radius:10%">';
          $data['employeeno'] = $x['employee_no'];
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

    $employeeno = $_POST['employeeno'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("UPDATE tbl_employee SET statuss = 'Deleted' WHERE employeeno = '$employeeno'");
    $query->execute();

    // $que = $conn->prepare("SELECT employeeno FROM tbl_employee WHERE id='$id'");
    // $que->execute();
    // $row = $que->fetch();
    // $emplono = $row['employeeno'];

    // $qry0 = $conn->prepare("DELETE FROM leave_balance WHERE employee_no='$emplono'");
    // $qry0->execute();

    // $qry0 = $conn->prepare("DELETE FROM user_account WHERE employeeno='$emplono'");
    // $qry0->execute();

    // $qry = $conn->prepare("DELETE FROM tbl_employee WHERE id='$id'");
    // $qry->execute();

    // $qry1 = $conn->prepare("DELETE FROM contactinfo WHERE emp_id='$id'");
    // $qry1->execute();

    // $qry2 = $conn->prepare("DELETE FROM contractinfo WHERE emp_id='$id'");
    // $qry2->execute();

    // $qry3 = $conn->prepare("DELETE FROM govtidinfo WHERE emp_id='$id'");
    // $qry3->execute();

    // $qry4 = $conn->prepare("DELETE FROM otherpersonalinfo WHERE emp_id='$id'");
    // $qry4->execute();

    // $qry5 = $conn->prepare("DELETE FROM benefitsinfo WHERE emp_id='$id'");
    // $qry5->execute();

    // $qry6 = $conn->prepare("DELETE FROM disciplinarytracking WHERE emp_id='$id'");
    // $qry6->execute();

    // $qry7 = $conn->prepare("DELETE FROM otheridinfo WHERE emp_id='$id'");
    // $qry7->execute();

    // $qry8 = $conn->prepare("DELETE FROM previous_empinfo WHERE emp_id='$id'");
    // $qry8->execute();

    // $qry9 = $conn->prepare("DELETE FROM medicalinfo WHERE emp_id='$id'");
    // $qry9->execute();

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
    $end_of_contract = $_POST['end_of_contract'] != '' ? $_POST['end_of_contract'] : '0000-00-00';
    $regularized = $_POST['regularized'] != '' ? $_POST['regularized'] : '0000-00-00';
    if(!empty($_FILES["profile"]["name"])) {
      // Where the file is going to be stored
      $target_dir = "../personal_picture/".$employeeno."/";
      $file = $_FILES['profile']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $profile = $filename.date('Y-m-d-His').".".$ext;
      $temp_name = $_FILES['profile']['tmp_name'];
      $path_filename_ext = $target_dir.$profile;

      if (file_exists($path_filename_ext)) {
        echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employeeno));
        exit;
      }else{
        if(!is_dir("../personal_picture/".$employeeno."/")){
          mkdir("../personal_picture/".$employeeno."/");
        }
        if(!move_uploaded_file($temp_name,$path_filename_ext)){
          echo json_encode(array("message"=>"An error has occured, file not uploaded.", "type" => "error", "employeeno" => $employeeno));
          exit;
        }
      }
    } else {
      $profile = '';
    }

    if(!empty($_FILES["marriageContract"]["name"])) {
      $target_dir = "../documents/".$employeeno."/marriage_contract/";
      $file = $_FILES['marriageContract']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['marriageContract']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $marriageContract = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir;
      if(!is_dir($path_filename_ext)){
        mkdir("../documents/".$employeeno."/marriage_contract/", 0777, true);
      }
      $path_filename_ext .= $marriageContract;

      move_uploaded_file($temp_name,$path_filename_ext);

    } else {
      $marriageContract = '';
    }

    if(!empty($_FILES["dependent"]["name"])) {
      $target_dir = "../documents/".$employeeno."/dependent/";
      $file = $_FILES['dependent']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['dependent']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $dependent = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir;
      if(!is_dir($path_filename_ext)){
        mkdir("../documents/".$employeeno."/dependent/", 0777, true);
      }
      $path_filename_ext .= $dependent;

      move_uploaded_file($temp_name,$path_filename_ext);

    } else {
      $dependent = '';
    }

    if(!empty($_FILES["additionalId"]["name"])) {
      $target_dir = "../documents/".$employeeno."/additional_id/";
      $file = $_FILES['additionalId']['name'];
      $path = pathinfo($file);
      $ext = $path['extension'];
      $temp_name = $_FILES['additionalId']['tmp_name'];
      $today = date("Ymd");
      $name = explode(".", $file);
      $additionalId = $name[0]."-".$today.".".$ext;
      $path_filename_ext = $target_dir;
      if(!is_dir($path_filename_ext)){
        mkdir("../documents/".$employeeno."/additional_id/", 0777, true);
      }
      $path_filename_ext .= $additionalId;

      move_uploaded_file($temp_name,$path_filename_ext);

    } else {
      $additionalId = '';
    }

    if(!empty($_FILES["proofOFBilling"]["name"])) {
      $target_dir = "../documents/".$employeeno."/proof_of_billing/";
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
        mkdir("../documents/".$employeeno."/proof_of_billing/", 0777, true);
      }
      $path_filename_ext .= $proofOFBilling;

      move_uploaded_file($temp_name,$path_filename_ext);

    } else {
      $proofOFBilling = '';
    }

    // $conn = $this->connect_mysql();
    // $query = $conn->prepare("INSERT INTO tbl_employee SET employeeno='$employeeno', id_number='$id_number', lastname='$lastname', firstname='$firstname', middlename='$middlename', rank='',statuss='$statuss' ,employment_status='$employment_status', company='$company',reimbursement_bal='3500', imagepic='$profile', leave_balance='0', job_title='$job_title', job_category='$job_category', department='$department'");
    // $query->execute();

    // $id = $conn->lastInsertId();

    // $fullname = $firstname." ".$lastname;
    // $username = $firstname.".".$lastname;

    $conn = $this->connect_mysql();
    try {


      
      $conn->beginTransaction();
      $conn->exec("INSERT INTO tbl_employee SET employeeno='$employeeno', id_number='$id_number', lastname='$lastname', firstname='$firstname', middlename='$middlename', rank='',statuss='$statuss' ,employment_status='$employment_status', company='$company',reimbursement_bal='3500', imagepic='$profile', leave_balance='0', job_title='$job_title', job_category='$job_category', department='$department'");

      // $id = $conn->lastInsertId();

      $fullname = $firstname." ".$lastname;
      $username = $firstname.".".$lastname;

      $conn->exec("INSERT INTO user_account SET employeeno='$employeeno', fullname='$fullname', username='$username', password='$password', empstatus='active', usertype='employee', userrole='3',approver='no'");
      $conn->exec("INSERT INTO contactinfo SET employeeno='$employeeno', street='$street', municipality='$municipality', province='$province', contactno='$contact_no', telephoneno='', corp_email='$corp_email', personal_email='$personal_email', nationality='$nationality', driver_license='', driver_expdate='0000-00-00', dept_head_email='$dept_head_email'");
      $conn->exec("INSERT INTO contractinfo SET employeeno='$employeeno', date_hired='$date_hired', eoc='$end_of_contract', regularized='$regularized', preterm='0000-00-00', resigned='0000-00-00', retired='0000-00-00', terminatedd='0000-00-00', lastpay='0000-00-00', remarks=''");
      $conn->exec("INSERT INTO govtidinfo SET employeeno='$employeeno', tin_no='$tin', sss_no='$sss', phic_no='$phic', hdmf_no='$hdmf', atm_no='$atm', bank_name='$bank_name', sss_remarks='', phic_remarks='', hdmf_remarks=''");
      $conn->exec("INSERT INTO otherpersonalinfo SET employeeno='$employeeno', nickname='', dateofbirth='$dateofbirth', gender='$gender', height='', weight='', marital_status='$marital_status', birth_place='$birth_place', blood_type='', contact_name='', contact_address='', contact_telno='', contact_celno='', contact_relation=''");
      // $conn->exec("INSERT INTO benefitsinfo SET employeeno='$employeeno', dependent1='', age1='', sex1='', dependent2='', age2='', sex2='', dependent3='', age3='', sex3='', dependent4='', age4='', sex4='', dependent5='', age5='', sex5='', relation1='', relation2='', relation3='', relation4='', relation5=''");
      // $conn->exec("INSERT INTO disciplinarytracking SET employeeno='$employeeno', violation='', specifc_offense='', of_offense='', dateissued='0000-00-00', datecommitted='0000-00-00', action=''");
      // $conn->exec("INSERT INTO otheridinfo SET employeeno='$employeeno', comp_id_dateissue='0000-00-00', comp_id_vdate='0000-00-00', fac_ap_dateissue='0000-00-00', fac_ap_vdate='0000-00-00', card_number='', driver_id='', driver_exp='0000-00-00', prc_number='', prc_exp='0000-00-00', civil_service=''");
      // $conn->exec("INSERT INTO previous_empinfo SET employeeno='$employeeno', company1='', naturebusiness1='', year1='', position1='', rate1='', company2='', naturebusiness2='', year2='', position2='', rate2='', yearend1='', yearend2=''");
      // $conn->exec("INSERT INTO medicalinfo SET employeeno='$employeeno', type1='', classification1='', status1='', dateofexam1='0000-00-00', remarks1='', type2='', classification2='', status2='', dateofexam2='0000-00-00', remarks2='', type3='', classification3='', status3='', dateofexam3='0000-00-00', remarks3=''");
      // $conn->exec("INSERT INTO marriage_contract (employee_number, marriage_contract) VALUES ('$employeeno', '$marriageContract')");
      // $conn->exec("INSERT INTO dependents (employee_number, dependent) VALUES ('$employeeno', '$dependent')");
      // $conn->exec("INSERT INTO additional_id (employee_number, additional_id) VALUES ('$employeeno', '$additionalId')");
      // $conn->exec("INSERT INTO proof_of_billing (employee_number, proof_of_billing) VALUES ('$employeeno', '$proofOFBilling')");
      // $conn->exec("INSERT INTO leave_balance SET employee_no='$employeeno',leave_type='SL',balance='0',earned='no',what_month='0', stat='', decem=''");
      // $conn->exec("INSERT INTO leave_balance SET employee_no='$employeeno',leave_type='VL',balance='0',earned='no',what_month='0', stat='', decem=''");
      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Added new Employee. Employee no ".$employeeno;
      $audittype = "Add";
      $conn->exec("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $conn->commit();
      
      echo json_encode(array('type' => 'success', 'message' => 'Successfully added employee '.$employeeno));
      exit;
    } catch (\PDOException $e) {
      echo json_encode(array('type' => 'error', 'message' => 'An error has occured during the process of creating employee. <br /> Please try again'));
      $conn->rollback();
      // exit;
      throw $e;
    }
    // $squery = $conn->prepare("INSERT INTO user_account SET employeeno='$employeeno', fullname='$fullname', username='$username', password='$password', empstatus='active', usertype='employee', userrole='3',approver='no'");
    // $squery->execute();
    // $qry1 = $conn->prepare("INSERT INTO contactinfo SET emp_id='$id', employeeno='$employeeno', street='$street', municipality='$municipality', province='$province', contactno='$contact_no', telephoneno='', corp_email='$corp_email', personal_email='$personal_email', nationality='$nationality', driver_license='', driver_expdate='0000-00-00', dept_head_email='$dept_head_email'");
    // $qry1->execute();

    // $qry2 = $conn->prepare("INSERT INTO contractinfo SET emp_id='$id', employeeno='$employeeno', date_hired='$date_hired', eoc='$end_of_contract', regularized='$regularized', preterm='0000-00-00', resigned='0000-00-00', retired='0000-00-00', terminatedd='0000-00-00', lastpay='0000-00-00', remarks=''");
    // $qry2->execute();

    // $qry3 = $conn->prepare("INSERT INTO govtidinfo SET emp_id='$ida', employeeno='$employeeno', tin_no='$tin', sss_no='$sss', phic_no='$phic', hdmf_no='$hdmf', atm_no='$atm', bank_name='$bank_name', sss_remarks='', phic_remarks='', hdmf_remarks=''");
    // $qry3->execute();

    // $qry4 = $conn->prepare("INSERT INTO otherpersonalinfo SET emp_id='$id', employeeno='$employeeno', nickname='', dateofbirth='$dateofbirth', gender='$gender', height='', weight='', marital_status='$marital_status', birth_place='$birth_place', blood_type='', contact_name='', contact_address='', contact_telno='', contact_celno='', contact_relation=''");
    // $qry4->execute();

    // $qry5 = $conn->prepare("INSERT INTO benefitsinfo SET emp_id='$id', employeeno='$employeeno', dependent1='', age1='', sex1='', dependent2='', age2='', sex2='', dependent3='', age3='', sex3='', dependent4='', age4='', sex4='', dependent5='', age5='', sex5='', relation1='', relation2='', relation3='', relation4='', relation5=''");
    // $qry5->execute();

    // $qry6 = $conn->prepare("INSERT INTO disciplinarytracking SET emp_id='$id', employeeno='$employeeno', violation='', specifc_offense='', of_offense='', dateissued='0000-00-00', datecommitted='0000-00-00', action=''");
    // $qry6->execute();

    // $qry7 = $conn->prepare("INSERT INTO otheridinfo SET emp_id='$id', employeeno='$employeeno', comp_id_dateissue='0000-00-00', comp_id_vdate='0000-00-00', fac_ap_dateissue='0000-00-00', fac_ap_vdate='0000-00-00', card_number='', driver_id='', driver_exp='0000-00-00', prc_number='', prc_exp='0000-00-00', civil_service=''");
    // $qry7->execute();

    // $qry8 = $conn->prepare("INSERT INTO previous_empinfo SET emp_id='$id', employeeno='$employeeno', company1='', naturebusiness1='', year1='', position1='', rate1='', company2='', naturebusiness2='', year2='', position2='', rate2='', yearend1='', yearend2=''");
    // $qry8->execute();

    // $qry9 = $conn->prepare("INSERT INTO medicalinfo SET emp_id='$id', employeeno='$employeeno', type1='', classification1='', status1='', dateofexam1='0000-00-00', remarks1='', type2='', classification2='', status2='', dateofexam2='0000-00-00', remarks2='', type3='', classification3='', status3='', dateofexam3='0000-00-00', remarks3=''");
    // $qry9->execute();

    // // // $qry10 = $conn->prepare("INSERT INTO employee_documents (employee_number, marriage_contract, dependent, additional_id, proof_of_billing) VALUES ('$employeeno', '$marriageContract', '$dependent', '$additionalId', '$proofOFBilling')");
    // // // $qry10->execute();

    // $query10 = $conn->prepare("INSERT INTO marriage_contract (employee_number, marriage_contract) VALUES ('$employeeno', '$marriageContract')");
    // $query10->execute();
    // $query11 = $conn->prepare("INSERT INTO dependents (employee_number, dependent) VALUES ('$employeeno', '$dependent')");
    // $query11->execute();
    // $query12 = $conn->prepare("INSERT INTO additional_id (employee_number, additional_id) VALUES ('$employeeno', '$additionalId')");
    // $query12->execute();
    // $query13 = $conn->prepare("INSERT INTO proof_of_billing (employee_number, proof_of_billing) VALUES ('$employeeno', '$proofOFBilling')");
    // $query13->execute();

    // $query14 = $conn->prepare("INSERT INTO leave_balance SET employee_no='$employeeno',leave_type='SL',balance='0',earned='no',what_month='0', stat='', decem=''");
    // $query14->execute();

    // $query15 = $conn->prepare("INSERT INTO leave_balance SET employee_no='$employeeno',leave_type='VL',balance='0',earned='no',what_month='0', stat='', decem=''");
    // $query15->execute();

    // session_start();
    // $useraction = $_SESSION['fullname'];
    // $dateaction = date('Y-m-d');
    // $auditaction = "Added new Employee. Employee no ".$employeeno;
    // $audittype = "Add";
    // $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
    // $q->execute();


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
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno";
      }else if($type=="bday"){
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno WHERE EXTRACT(MONTH FROM c.dateofbirth) BETWEEN '$from' AND '$to'";
      }else if($type=="gender"){
          if($from=="All"){
              $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno";
          }else{
              $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno WHERE c.gender='$from'";
          }
         
      }else if($type=="employment"){
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno WHERE a.employment_status='$from'";
      }else if($type=="division"){
      
          $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno WHERE a.department='$from' ORDER BY a.lastname ASC";
      }else if($type=="job_category"){
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno WHERE a.job_category='$from'";
      }else if($type=="age"){
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno
          WHERE YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) BETWEEN '$from' AND '$to'";
      }else if($type=="evaluation"){
        
        $query = "SELECT a.*,b.*,c.*,
           YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                            LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                            LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno
         WHERE (YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5))) AND (YEAR(date_hired) = YEAR(DATE(NOW() - INTERVAL '$from' MONTH)) AND MONTH(date_hired) = MONTH(DATE(NOW() - INTERVAL '$from' MONTH)) AND DAY(date_hired) >= DAY(DATE(NOW() - INTERVAL '$from' MONTH))) ORDER BY a.lastname ASC";
     }else{
        
         $query = "SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
                             LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno WHERE b.date_hired BETWEEN '$from' AND '$to'";
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
        $employee_sql = "INSERT INTO tbl_employee (employeeno, id_number, lastname, firstname,	middlename, rank, statuss, employment_status, company, imagepic, leave_balance, job_title, job_category, department, reimbursement_bal) VALUES ";

        $user_sql = "INSERT INTO user_account (employeeno, fullname, username, password, empstatus, usertype, userrole, approver) VALUES ";

        $contact_sql = "INSERT INTO contactinfo (employeeno, street, municipality, province, contactno, telephoneno, corp_email, personal_email, nationality, driver_license, driver_expdate, dept_head_email) VALUES ";
        
        $contract_sql = "INSERT INTO contractinfo (employeeno, date_hired, eoc, regularized, preterm, resigned, retired, terminatedd, lastpay, remarks) VALUES ";

        $govid_sql = "INSERT INTO govtidinfo (employeeno, tin_no, sss_no, phic_no, hdmf_no, atm_no, bank_name, aub_no, sss_remarks, phic_remarks, hdmf_remarks) VALUES ";

        $other_personal_sql = "INSERT INTO otherpersonalinfo (employeeno, nickname, dateofbirth, gender, height, weight, marital_status, birth_place, blood_type, contact_name, contact_address, contact_telno, contact_celno, contact_relation) VALUES ";

        $employee_table = array();
        $user_table = array();
        $contact_table = array();
        $contract_table = array();
        $govid_table = array();
        $other_personal_table = array();

        for ($row = 2; $row <= $getHighestRow; $row++) {
            $employeeno = $sheet->getCellByColumnAndRow(0, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(0, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(0, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(0, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(0, $row)->getValue());

            $id_number = $sheet->getCellByColumnAndRow(1, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(1, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(1, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(1, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(1, $row)->getValue());

            $lastname = ucwords(strtolower($sheet->getCellByColumnAndRow(2, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(2, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(2, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(2, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(2, $row)->getValue())));

            $firstname = ucwords(strtolower($sheet->getCellByColumnAndRow(3, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(3, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(3, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(3, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(3, $row)->getValue())));

            $middlename = ucwords(strtolower($sheet->getCellByColumnAndRow(4, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(4, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(4, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(4, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(4, $row)->getValue())));

            $statuss = ucwords(strtolower($sheet->getCellByColumnAndRow(5, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(5, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(5, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(5, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(5, $row)->getValue())));

            $employment_status = ucwords(strtolower($sheet->getCellByColumnAndRow(6, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(6, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(6, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(6, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(6, $row)->getValue())));
            
            $company = $sheet->getCellByColumnAndRow(7, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(7, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(7, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(7, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(7, $row)->getValue());

            $job_title = $sheet->getCellByColumnAndRow(8, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(8, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(8, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(8, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(8, $row)->getValue());

            $imagepic = '';
            $rank = '';

            $job_category = ucwords(strtolower($sheet->getCellByColumnAndRow(9, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(9, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(9, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(9, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(9, $row)->getValue())));

            $department = ucwords(strtolower($sheet->getCellByColumnAndRow(10, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(10, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(10, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(10, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(10, $row)->getValue())));


            // Contact table
            $street = ucwords(strtolower($sheet->getCellByColumnAndRow(11, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(11, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(11, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(11, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(11, $row)->getValue())));

            $municipality = ucwords(strtolower($sheet->getCellByColumnAndRow(12, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(12, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(12, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(12, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(12, $row)->getValue())));

            $province = ucwords(strtolower($sheet->getCellByColumnAndRow(13, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(13, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(13, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(13, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(13, $row)->getValue())));

            $contact_no = $sheet->getCellByColumnAndRow(14, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(14, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(14, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(14, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(14, $row)->getValue());

            
            $telephone_no = '';
            $corp_email = '';

            $personal_email = $sheet->getCellByColumnAndRow(15, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(15, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(15, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(15, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(15, $row)->getValue());

            $nationality = $sheet->getCellByColumnAndRow(16, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(16, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(16, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(16, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(16, $row)->getValue());

            $driver_licence = '';
            $driver_expdate = '0000-00-00';
            $dept_head_email = '';

            // Contract table

            $date_hired = $sheet->getCellByColumnAndRow(17, $row)->getFormattedValue();

            $regularized = $sheet->getCellByColumnAndRow(18, $row)->getFormattedValue();

            $eoc = '0000-00-00';
            $preterm = '0000-00-00';
            $resigned = '0000-00-00';
            $retired = '0000-00-00';
            $terminated = '0000-00-00';
            $lastpay = '0000-00-00';
            $remarks = '';

            // Government ID's / Account
            $tin = $sheet->getCellByColumnAndRow(19, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(19, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(19, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(19, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(19, $row)->getValue());

            $sss = $sheet->getCellByColumnAndRow(20, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(20, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(20, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(20, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(20, $row)->getValue());

            $philhealth = $sheet->getCellByColumnAndRow(21, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(21, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(21, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(21, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(21, $row)->getValue());

            $hdmf = $sheet->getCellByColumnAndRow(22, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(22, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(22, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(22, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(22, $row)->getValue());

            $atm = $sheet->getCellByColumnAndRow(23, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(23, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(23, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(23, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(23, $row)->getValue());

            $bank_name = $sheet->getCellByColumnAndRow(24, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(24, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(24, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(24, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(24, $row)->getValue());

            $aub_no = $sheet->getCellByColumnAndRow(25, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(25, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(25, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(25, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(25, $row)->getValue());

            // Other personal Info
            $birthday = $sheet->getCellByColumnAndRow(26, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(26, $row)->getValue() == NULL ? '' : $sheet->getCellByColumnAndRow(26, $row)->getFormattedValue();
            
            $nickname = ucwords(strtolower($sheet->getCellByColumnAndRow(27, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(27, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(27, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(27, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(27, $row)->getValue())));

            $gender = ucwords(strtolower($sheet->getCellByColumnAndRow(28, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(28, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(28, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(28, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(28, $row)->getValue())));

            $marital_status = ucwords(strtolower($sheet->getCellByColumnAndRow(29, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(29, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(29, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(29, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(29, $row)->getValue())));

            $birth_place = ucwords(strtolower($sheet->getCellByColumnAndRow(30, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(30, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(30, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(30, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(30, $row)->getValue())));

            $blood_type = $sheet->getCellByColumnAndRow(31, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(31, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(31, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(31, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(31, $row)->getValue());

            $height = $sheet->getCellByColumnAndRow(32, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(32, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(32, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(32, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(32, $row)->getValue());

            $weight = $sheet->getCellByColumnAndRow(33, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(33, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(33, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(33, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(33, $row)->getValue());

            $contact_name = ucwords(strtolower($sheet->getCellByColumnAndRow(34, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(34, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(34, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(34, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(34, $row)->getValue())));

            $contact_address = ucwords(strtolower($sheet->getCellByColumnAndRow(35, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(35, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(35, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(35, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(35, $row)->getValue())));

            $contact_telno = '';

            $contact_celno = $sheet->getCellByColumnAndRow(36, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(36, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(36, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(36, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(36, $row)->getValue());

            $contact_relation = ucwords(strtolower($sheet->getCellByColumnAndRow(37, $row)->getValue() == '' || $sheet->getCellByColumnAndRow(37, $row)->getValue() == NULL ? '' : ($sheet->getCellByColumnAndRow(37, $row)->getValue()[0] == '=' ? $sheet->getCellByColumnAndRow(37, $row)->getCalculatedValue() : $sheet->getCellByColumnAndRow(37, $row)->getValue())));

            $fullname = $firstname. " " .$lastname;
            $username = $firstname. "." .$lastname;
            $password = 'password';


            $employee_table[] = "('$employeeno', '$id_number', '$lastname', '$firstname', '$middlename', '$rank', '$statuss', '$employment_status', '$company', '$imagepic', '0', '$job_title', '$job_category', '$department', '3500')";

            $user_table[] = "('$employeeno', '$fullname', '$username', '$password', 'active', 'employee', '3', 'no')";

            $contact_table[] = "('$employeeno', '$street', '$municipality', '$province', '$contact_no', '$telephone_no', '$corp_email', '$personal_email', '$nationality', '$driver_licence', '$driver_expdate', '$dept_head_email')";

            $contract_table[] = "('$employeeno', '$date_hired', '$eoc', '$regularized', '$preterm', '$resigned', '$retired', '$terminated', '$lastpay', '$remarks')";

            $govid_table[] = "('$employeeno', '$tin', '$sss', '$philhealth', '$hdmf', '$atm', '$bank_name', '$aub_no', 'aa', 'aa', 'aa')";

            $other_personal_table[] = "('$employeeno', 'nickname', '$birthday', 'gender', 'height', 'weight', 'marital_status', 'birth_place', '$blood_type', '$contact_name', '$contact_address', '$contact_telno', '$contact_celno', '$contact_relation')";
        }
        // print_r(implode(',', $values));
        $employee_sql .= implode(',', $employee_table);
        $employee_sql .=  ' ON DUPLICATE KEY UPDATE lastname=VALUES(lastname), firstname=VALUES(firstname), middlename=VALUES(middlename), rank=VALUES(rank), statuss=VALUES(statuss), employment_status=VALUES(employment_status), company=VALUES(company), leave_balance=VALUES(leave_balance), job_title=VALUES(job_title), job_category=VALUES(job_category), department=VALUES(department), reimbursement_bal=VALUES(reimbursement_bal)';
        $user_sql .= implode(',', $user_table);
        $user_sql .=  ' ON DUPLICATE KEY UPDATE fullname=VALUES(fullname), username=VALUES(username), password=VALUES(password), empstatus=VALUES(empstatus), usertype=VALUES(usertype), userrole=VALUES(userrole), approver=VALUES(approver)';
        $contact_sql .= implode(',', $contact_table);
        $contact_sql .=  ' ON DUPLICATE KEY UPDATE employeeno=VALUES(employeeno), street=VALUES(street), municipality=VALUES(municipality), province=VALUES(province), contactno=VALUES(contactno), telephoneno=VALUES(telephoneno), corp_email=VALUES(corp_email), personal_email=VALUES(personal_email), nationality=VALUES(nationality), driver_license=VALUES(driver_license), driver_expdate=VALUES(driver_expdate), dept_head_email=VALUES(dept_head_email)';
        $contract_sql .= implode(',', $contract_table);
        $contract_sql .=  ' ON DUPLICATE KEY UPDATE date_hired=VALUES(date_hired), eoc=VALUES(eoc), regularized=VALUES(regularized), preterm=VALUES(preterm), resigned=VALUES(resigned), retired=VALUES(retired), terminatedd=VALUES(terminatedd), lastpay=VALUES(lastpay), remarks=VALUES(remarks)';
        $govid_sql .= implode(',', $govid_table);
        $govid_sql .=  ' ON DUPLICATE KEY UPDATE tin_no=VALUES(tin_no), sss_no=VALUES(sss_no), phic_no=VALUES(phic_no), hdmf_no=VALUES(hdmf_no), atm_no=VALUES(atm_no), bank_name=VALUES(bank_name), aub_no=VALUES(aub_no), sss_remarks=VALUES(sss_remarks), phic_remarks=VALUES(phic_remarks), hdmf_remarks=VALUES(hdmf_remarks)';
        $other_personal_sql .= implode(',', $other_personal_table);
        $other_personal_sql .=  ' ON DUPLICATE KEY UPDATE nickname=VALUES(nickname), dateofbirth=VALUES(dateofbirth), gender=VALUES(gender), height=VALUES(height), weight=VALUES(weight), marital_status=VALUES(marital_status), birth_place=VALUES(birth_place), blood_type=VALUES(blood_type), contact_name=VALUES(contact_name), contact_address=VALUES(contact_address), contact_telno=VALUES(contact_telno), contact_celno=VALUES(contact_celno), contact_relation=VALUES(contact_relation)';
        

        try {
          $conn->beginTransaction();

          // $employeeQuery = $conn->prepare($employee_sql);
          // $employeeQuery->execute();

          // $userQuery = $conn->prepare($user_sql);
          // $userQuery->execute();

          // $contactQuery = $conn->prepare($contact_sql);
          // $contactQuery->execute();

          // $contractQuery = $conn->prepare($contract_sql);
          // $contractQuery->execute();

          // $govidQuery = $conn->prepare($govid_sql);
          // $govidQuery->execute();

          // $otherPersonalQuery = $conn->prepare($other_personal_sql);
          // $otherPersonalQuery->execute();

          $conn->exec($employee_sql);
          $conn->exec($user_sql);
          $conn->exec($contact_sql);
          $conn->exec($contract_sql);
          $conn->exec($govid_sql);
          $conn->exec($other_personal_sql);
          // $conn->exec('TRUNCATE TABLE tbl_employee;
          //               TRUNCATE TABLE user_account;
          //               TRUNCATE TABLE contactinfo;
          //               TRUNCATE TABLE contractinfo;
          //               TRUNCATE TABLE govidinfo;
          //               TRUNCATE TABLE otherpersonalinfo;');
          $conn->commit();
          
          echo json_encode(array('type' => 'success', 'message' => 'Successfully updated the employee masterlist'));
          exit;

        } catch (\PDOException $e) {
          echo json_encode(array('type' => 'error', 'message' => 'Theres an error updating the employees'));
          throw $e;
          exit;
        }

        // $query = $conn->prepare($other_personal_sql);
        // $query->execute();
        // echo json_encode($employee_table);
        // echo json_encode($contact_sql);
        echo json_encode($contract_sql);
        // echo json_encode($employee_sql);
        // echo json_encode($other_personal_sql);
    }
  }

  function exportEmployeeMasterFile() {

    $conn = $this->connect_mysql();

    $query = $conn->prepare("
      SELECT a.employeeno, a.id_number, a.lastname, a.firstname, a.middlename, a.statuss, a.employment_status, a.company, a.job_title, a.job_category, a.department,
      b.street, b.municipality, b.province, b.contactno, b.personal_email, b.nationality,
      c.date_hired, c.regularized,
      d.tin_no, d.sss_no, d.phic_no, d.hdmf_no, d.atm_no, d.bank_name, d.aub_no,
      e.dateofbirth, e.nickname, e.gender, e.marital_status, e.birth_place, e.blood_type, e.height, e.weight, e.contact_name, e.contact_address, e.contact_celno, e.contact_relation
      FROM tbl_employee a 
      LEFT JOIN contactinfo b ON a.employeeno = b.employeeno
      LEFT JOIN contractinfo c ON a.employeeno = c.employeeno
      LEFT JOIN govtidinfo d ON a.employeeno = d.employeeno
      LEFT JOIN otherpersonalinfo e ON a.employeeno = e.employeeno
    ");

    $query->execute();
    $row = $query->fetchAll();
    return $row;
    
  }

  function sendNotificationEvaluation() {
    // SEnd notification for employees who is for regularization and 18th month evaluation
    $conn = $this->connect_mysql();
    $stmt18Month = $conn->prepare("SELECT a.*,b.*,c.*,
        YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
        LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
        LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno
        WHERE (YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5))) AND (YEAR(date_hired) = YEAR(DATE(NOW() - INTERVAL 18 MONTH)) AND MONTH(date_hired) = MONTH(DATE(NOW() - INTERVAL 18 MONTH)) AND DAY(date_hired) >= DAY(DATE(NOW() - INTERVAL 18 MONTH))) ORDER BY a.lastname ASC");
    $stmt18Month->execute();
    $eighteenMonths = $stmt18Month->fetchAll();

    $stmtRegular = $conn->prepare("SELECT a.*,b.*,c.*,
        YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
        LEFT JOIN contractinfo b ON a.employeeno=b.employeeno
        LEFT JOIN otherpersonalinfo c ON a.employeeno=c.employeeno
        WHERE (YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5))) AND (YEAR(date_hired) = YEAR(DATE(NOW() - INTERVAL 6 MONTH)) AND MONTH(date_hired) = MONTH(DATE(NOW() - INTERVAL 6 MONTH)) AND DAY(date_hired) >= DAY(DATE(NOW() - INTERVAL 6 MONTH))) ORDER BY a.lastname ASC");
    $stmtRegular->execute();
    $regulars = $stmtRegular->fetchAll();
    
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

    if(count($regulars) > 0 ) {
      $namesRegulars = array();
      $message = "<strong>Due for Evaluation - Regularization</strong><br />"; 
      foreach($regulars as $regular) {
        $message .= "<strong>Name: </strong>". " " .$regular['firstname']. " " .$regular['lastname']. "<br /><strong>Regularization Date: </strong>". date('Y-m-d', strtotime("+6 months", strtotime($regular['date_hired']))). "<br /><br />";
      }

      // Send notification for regularization evaluation of employees
      $mail->Subject = "Due for Evaluation - Regularization";
      $mail->Body = $message;
      $mail->isHTML(true);
      // $dept_head_email = $row2['dept_head_email'];
      $mail->AddAddress('bumacodejhay@gmail.com');
      if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
      } else {
        echo "Success";
      }
    }
    if(count($eighteenMonths) > 0 ) {
      $namesEighteenMonths = array();
      $message = "<strong>Due for Evaluation - 18th month Evaluation</strong><br />"; 
      foreach($eighteenMonths as $eighteenMonth) {
        $message .= "<strong>Name: </strong>". " " .$eighteenMonth['firstname']. " " .$eighteenMonth['lastname']. "<br /><strong>18th Month on: </strong>". date('Y-m-d', strtotime("+18 months", strtotime($eighteenMonth['date_hired']))). "<br /><br />";
      }

      // Send notification for 18 month evaluation of employees
      $mail->Subject = "Due for Evaluation - 18th month Evaluation";
      $mail->Body = $message;
      $mail->isHTML(true);
      // $dept_head_email = $row2['dept_head_email'];
      $mail->AddAddress('bumacodejhay@gmail.com');
      if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
      } else {
        echo "Success";
      }
    }

  }


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
if(isset($_GET['sendNotificationEvaluation'])){
  $x->sendNotificationEvaluation();
}




 ?>