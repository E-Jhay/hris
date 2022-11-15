<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

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

  function ddepartment(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM department ORDER BY department ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Department--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['department'].'">'.$row['department'].'</option>';}
      echo $option;
  }



  function selectotherinfo(){
    $emp_id = $_POST['emp_id'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,b.*,YEAR(CURRENT_TIMESTAMP) - YEAR(b.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(b.dateofbirth, 5)) as age FROM tbl_employee a 
                             LEFT JOIN otherpersonalinfo b 
                             ON a.id = b.emp_id
                             WHERE a.id='$emp_id'");
    $query->execute();
    $row = $query->fetch();

    foreach ($row as $key => $input_arr) {
      $row[$key] = addslashes($input_arr);
      $row[$key] = utf8_encode($input_arr);
    }

    echo json_encode(array(
      'emp_no'=>$row['employeeno'],
      'f_name'=>$row['firstname'],
      'l_name'=>utf8_decode($row['lastname']),
      'm_name'=>$row['middlename'],
      'rank'=>$row['rank'],
      'statuss'=>$row['statuss'],
      'emp_statuss'=>$row['employment_status'],
      'company'=>$row['company'],
      'nickname'=>$row['nickname'],
      'dateofbirth'=>$row['dateofbirth'],
      'gender'=>$row['gender'],
      'height'=>$row['height'],
      'weight'=>$row['weight'],
      'marital_status'=>$row['marital_status'],
      'birth_place'=>$row['birth_place'],
      'blood_type'=>$row['blood_type'],
      'contact_name'=>$row['contact_name'],
      'contact_address'=>$row['contact_address'],
      'contact_telno'=>$row['contact_telno'],
      'contact_celno'=>$row['contact_celno'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department'],
      'age'=>$row['age'],
      'contact_relation'=>$row['contact_relation']
    ));
  }

  function editotherinfo(){

      if (($_FILES['profile']['name']!="")){

       // Where the file is going to be stored
       $employ_id = $_POST['emp_id'];

       $target_dir = "../personal_picture/";
       $file = $_FILES['profile']['name'];
       $path = pathinfo($file);
       $filename = str_replace(' ', '', $path['filename']);
       $ext = $path['extension'];
       $today = date("Ymd");
       $attachfile = $filename."-".$today.".".$ext;
       $temp_name = $_FILES['profile']['tmp_name'];
       $path_filename_ext = $target_dir.$attachfile;

       $lto_upload = $target_dir.$attachfile;
       unlink($lto_upload);

      // Check if file already exists
       if (file_exists($path_filename_ext)) {
        echo "Sorry, file already exists.";
       }else{

          move_uploaded_file($temp_name,$path_filename_ext);

          $conn=$this->connect_mysql();
          $sql = $conn->prepare("UPDATE tbl_employee SET imagepic='$attachfile' WHERE id='$employ_id'");
          $sql->execute();

       }
    }

      $emp_no = $_POST['emp_no'];
      $f_name = $_POST['f_name'];
      $l_name = $_POST['l_name'];
      $m_name = $_POST['m_name'];
      $rank = $_POST['rank'];
      $statuss = $_POST['statuss'];
      $emp_statuss = $_POST['emp_statuss'];
      $company = $_POST['company'];

      $empid = $_POST['emp_id'];
      $nickname = $_POST['nickname'];
      $dateofbirth = $_POST['dateofbirth'];
      $gender = $_POST['gender'];
      $height = $_POST['height'];
      $weight = $_POST['weight'];
      $marital_status = $_POST['marital_status'];
      $birth_place = $_POST['birth_place'];
      $blood_type = $_POST['blood_type'];
      $contact_name = $_POST['contact_name'];
      $contact_address = $_POST['contact_address'];
      $contact_telno = $_POST['contact_telno'];
      $contact_celno = $_POST['contact_celno'];
      $leave_balance = $_POST['leave_balance'];
      $department = $_POST['department'];
      $contact_relation = $_POST['contact_relation'];

      $conn = $this->connect_mysql();

      $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE id='$empid'");
      $qry1->execute();

      $qry = $conn->prepare("UPDATE otherpersonalinfo SET nickname='$nickname', dateofbirth='$dateofbirth', gender='$gender', height='$height', weight='$weight', marital_status='$marital_status', birth_place='$birth_place', blood_type='$blood_type', contact_name='$contact_name', contact_address='$contact_address', contact_telno='$contact_telno', contact_celno='$contact_celno',contact_relation='$contact_relation' WHERE emp_id='$empid'");
      $qry->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the other personal info of Employee no".$emp_no;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

      // echo json_encode(array("id"=>$empid));

      header("location:../otherinfo.php?id=".$empid);
  }


}

$x = new crud();

if(isset($_GET['demp_stat'])){
  $x->demp_stat();
}
if(isset($_GET['dcompany'])){
  $x->dcompany();
}
if(isset($_GET['ddepartment'])){
  $x->ddepartment();
}

if(isset($_GET['selectotherinfo'])){
  $x->selectotherinfo();
}
if(isset($_GET['editotherinfo'])){
  $x->editotherinfo();
}



 ?>