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
          $data['action'] = '<button onclick="editemp('.$x['idd'].')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i> View</button>
          <button onclick="deleteemp('.$x['idd'].')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';
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

  function addnewemployee(){
   
    $employeeno = $_POST['employeeno'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $employment_status = $_POST['employment_status'];
    $company = $_POST['company'];
    $corp_email = $_POST['corp_email'];
    $contact_no = $_POST['contact_no'];
    $password = $_POST['password'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("INSERT INTO tbl_employee SET employeeno='$employeeno', lastname='$lastname', firstname='$firstname', middlename='$middlename', rank='',statuss='Active' ,employment_status='$employment_status', company='$company',reimbursement_bal='3500', imagepic='usera.png', leave_balance='0', job_title='', job_category='', department=''");
    $query->execute();

    $id = $conn->lastInsertId();

    $fullname = $firstname." ".$lastname;
    $username = $firstname.".".$lastname;

    $squery = $conn->prepare("INSERT INTO user_account SET employeeno='$employeeno', fullname='$fullname', username='$username', password='$password', empstatus='active', usertype='employee', userrole='3',approver='no'");
    $squery->execute();
    $qry1 = $conn->prepare("INSERT INTO contactinfo SET emp_id='$id', street='', municipality='', province='', contactno='$contact_no', telephoneno='', corp_email='$corp_email', personal_email=''");
    $qry1->execute();

    $qry2 = $conn->prepare("INSERT INTO contractinfo SET emp_id='$id', date_hired='0000-00-00', eoc='0000-00-00', regularized='0000-00-00', preterm='0000-00-00', resigned='0000-00-00', retired='0000-00-00', terminatedd='0000-00-00', lastpay='0000-00-00', remarks=''");
    $qry2->execute();

    $qry3 = $conn->prepare("INSERT INTO govtidinfo SET emp_id='$id', tin_no='', sss_no='', phic_no='', hdmf_no='', atm_no='', bank_name='', sss_remarks='', phic_remarks='', hdmf_remarks=''");
    $qry3->execute();

    $qry4 = $conn->prepare("INSERT INTO otherpersonalinfo SET emp_id='$id', nickname='', dateofbirth='0000-00-00', gender='', height='', weight='', marital_status='', birth_place='', blood_type='', contact_name='', contact_address='', contact_telno='', contact_celno=''");
    $qry4->execute();

    $qry5 = $conn->prepare("INSERT INTO benefitsinfo SET emp_id='$id', dependent1='', age1='', sex1='', dependent2='', age2='', sex2='', dependent3='', age3='', sex3='', dependent4='', age4='', sex4='', dependent5='', age5='', sex5=''");
    $qry5->execute();

    $qry6 = $conn->prepare("INSERT INTO disciplinarytracking SET emp_id='$id', violation='', specifc_offense='', of_offense='', dateissued='0000-00-00', datecommitted='0000-00-00', action=''");
    $qry6->execute();

    $qry7 = $conn->prepare("INSERT INTO otheridinfo SET emp_id='$id', comp_id_dateissue='0000-00-00', comp_id_vdate='0000-00-00', fac_ap_dateissue='0000-00-00', fac_ap_vdate='0000-00-00'");
    $qry7->execute();

    $qry8 = $conn->prepare("INSERT INTO previous_empinfo SET emp_id='$id', company1='', naturebusiness1='', year1='', position1='', rate1='', company2='', naturebusiness2='', year2='', position2='', rate2=''");
    $qry8->execute();

    $qry9 = $conn->prepare("INSERT INTO medicalinfo SET emp_id='$id', type1='', classification1='', status1='', dateofexam1='0000-00-00', remarks1='', type2='', classification2='', status2='', dateofexam2='0000-00-00', remarks2='', type3='', classification3='', status3='', dateofexam3='0000-00-00', remarks3=''");
    $qry9->execute();

    session_start();
    $useraction = $_SESSION['fullname'];
    $dateaction = date('Y-m-d');
    $auditaction = "Added new Employee";
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
if(isset($_GET['addnewemployee'])){
  $x->addnewemployee();
}




 ?>