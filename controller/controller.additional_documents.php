<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{
  function selectAdditionalDocuments(){
    $employeeno = $_GET['employeeno'];
    $conn = $this->connect_mysql();
    $marriage_contract = $conn->prepare("SELECT * FROM marriage_contract WHERE employee_number = '$employeeno' ORDER BY id DESC LIMIT 1");
    $marriage_contract->execute();
    $marriage_contract_data = $marriage_contract->fetch();
    $dependent = $conn->prepare("SELECT * FROM dependents WHERE employee_number = '$employeeno' ORDER BY id DESC LIMIT 1");
    $dependent->execute();
    $dependent_data = $dependent->fetch();
    $additional_id = $conn->prepare("SELECT * FROM additional_id WHERE employee_number = '$employeeno' ORDER BY id DESC LIMIT 1");
    $additional_id->execute();
    $additional_id_data = $additional_id->fetch();
    $proof_of_billing = $conn->prepare("SELECT * FROM proof_of_billing WHERE employee_number = '$employeeno' ORDER BY id DESC LIMIT 1");
    $proof_of_billing->execute();
    $proof_of_billing_data = $proof_of_billing->fetch();

    $data = array();
    $return = array();
    $data['marriage_contract'] = $marriage_contract_data && $marriage_contract_data['marriage_contract'] ? '<button onclick="viewDocument(\''.$marriage_contract_data['marriage_contract'].'\',\''.$employeeno.'\', \'marriage_contract\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-download"></i> View</button>' : 'N/A';

    $data['dependent'] = $dependent_data && $dependent_data['dependent'] ? '<button onclick="viewDocument(\''.$dependent_data['dependent'].'\',\''.$employeeno.'\', \'dependent\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-download"></i> View</button>' : '<p>N/A</p>';

    $data['additional_id'] = $additional_id_data && $additional_id_data['additional_id'] ? '<button onclick="viewDocument(\''.$additional_id_data['additional_id'].'\',\''.$employeeno.'\', \'additional_id\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-download"></i> View</button>' : '<p>N/A</p>';

    $data['proof_of_billing'] = $proof_of_billing_data && $proof_of_billing_data['proof_of_billing'] ? '<button onclick="viewDocument(\''.$proof_of_billing_data['proof_of_billing'].'\',\''.$employeeno.'\', \'proof_of_billing\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-download"></i> View</button>' : '<p>N/A</p>';

    $return[] = $data;
  
    echo json_encode(array('data'=>$return));
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

function ddepartment(){

  $conn=$this->connect_mysql();
  $sql = $conn->prepare("SELECT * FROM department ORDER BY department ASC");
  $sql->execute();
  $option = '<option value="" disabled="" selected="">--Select Department--</option>';
  while($row=$sql->fetch()){ $option.='<option value="'.$row['department'].'">'.$row['department'].'</option>';}
  echo $option;
}

function selectcontact(){
  $employeeno = $_POST['employeeno'];
  $conn = $this->connect_mysql();
  $query = $conn->prepare("SELECT * FROM tbl_employee WHERE employeeno='$employeeno'");
  $query->execute();
  $row = $query->fetch();

  foreach ($row as $key => $input_arr) {
    $row[$key] = addslashes($input_arr);
    $row[$key] = utf8_encode($input_arr);
  }
  if($row['imagepic'] == NULL || $row['imagepic'] == ''){
    $row['imagepic'] = 'personal_picture/usera.png';
  } else {
      if(!file_exists('../personal_picture/'.$row['employeeno'].'/'.$row['imagepic'])){
        $row['imagepic'] = 'personal_picture/'.$row['imagepic'];
      } else {
        $row['imagepic'] = 'personal_picture/'.$row['employeeno'].'/'.$row['imagepic'];
      }
  }

  echo json_encode(array(
    'emp_no'=>$row['employeeno'],
    'f_name'=>$row['firstname'],
    'l_name'=>utf8_decode($row['lastname']),
    'm_name'=>$row['middlename'],
    'rank'=>$row['rank'],
    'statuss'=>$row['statuss'],
    'emp_statuss'=>$row['employment_status'],
    'department'=>$row['department'],
    'company'=>$row['company'],
    'leave_balance'=>$row['leave_balance'],
    'imagepic'=>utf8_decode($row['imagepic']),
  ));
}

function update(){

  $emp_no = $_POST['emp_no'];
  $f_name = $_POST['f_name'];
  $l_name = $_POST['l_name'];
  $m_name = $_POST['m_name'];
  $rank = $_POST['rank'];
  $statuss = $_POST['statuss'];
  $emp_statuss = $_POST['emp_statuss'];
  $company = $_POST['company'];

  // $empid = $_POST['emp_id'];
  $leave_balance = $_POST['leave_balance'];
  $department = $_POST['department'];

  $conn = $this->connect_mysql();

  $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE employeeno = '$emp_no'");
  $qry1->execute();

  if(!empty($_FILES["marriageContract"]["name"])) {
    $target_dir = "../documents/".$emp_no."/marriage_contract/";
    $file = $_FILES['marriageContract']['name'];
    $path = pathinfo($file);
    $ext = $path['extension'];
    $temp_name = $_FILES['marriageContract']['tmp_name'];
    $today = date("Ymd");
    $name = explode(".", $file);
    $marriageContract = $name[0]."-".$today.".".$ext;
    $path_filename_ext = $target_dir;
    if(!is_dir($path_filename_ext)){
      mkdir($path_filename_ext, 0777, true);
    }
    $path_filename_ext .= $marriageContract;

    if(move_uploaded_file($temp_name,$path_filename_ext)) {
      $sql = $conn->prepare("SELECT id FROM marriage_contract WHERE employee_number = '$emp_no'");
      $sql->execute();

      if($sql->fetch()) {
        $query = $conn->prepare("UPDATE marriage_contract SET marriage_contract = '$marriageContract' WHERE employee_number = '$emp_no'");
        $query->execute();
      } else {
        $qry = $conn->prepare("INSERT INTO marriage_contract SET marriage_contract = '$marriageContract', employee_number = '$emp_no'");
        $qry->execute();
      }
    }
  } else {
    $marriageContract = '';
  }

  if(!empty($_FILES["dependent"]["name"])) {
    $target_dir = "../documents/".$emp_no."/dependent/";
    $file = $_FILES['dependent']['name'];
    $path = pathinfo($file);
    $ext = $path['extension'];
    $temp_name = $_FILES['dependent']['tmp_name'];
    $today = date("Ymd");
    $name = explode(".", $file);
    $dependent = $name[0]."-".$today.".".$ext;
    $path_filename_ext = $target_dir;
    if(!is_dir($path_filename_ext)){
      mkdir($path_filename_ext, 0777, true);
    }
    $path_filename_ext .= $dependent;

    if(move_uploaded_file($temp_name,$path_filename_ext)) {
      $sql = $conn->prepare("SELECT id FROM dependents WHERE employee_number = '$emp_no'");
      $sql->execute();

      if($sql->fetch()) {
        $query2 = $conn->prepare("UPDATE dependents SET dependent = '$dependent' WHERE employee_number = '$emp_no'");
        $query2->execute();
      } else {
        $qry = $conn->prepare("INSERT INTO dependents SET dependent = '$dependent', employee_number = '$emp_no'");
        $qry->execute();
      }
    }

  } else {
    $dependent = '';
  }

  if(!empty($_FILES["additionalId"]["name"])) {
    $target_dir = "../documents/".$emp_no."/additional_id/";
    $file = $_FILES['additionalId']['name'];
    $path = pathinfo($file);
    $ext = $path['extension'];
    $temp_name = $_FILES['additionalId']['tmp_name'];
    $today = date("Ymd");
    $name = explode(".", $file);
    $additionalId = $name[0]."-".$today.".".$ext;
    $path_filename_ext = $target_dir;
    if(!is_dir($path_filename_ext)){
      mkdir($path_filename_ext, 0777, true);
    }
    $path_filename_ext .= $additionalId;

    if(move_uploaded_file($temp_name,$path_filename_ext)) {

      $sql = $conn->prepare("SELECT id FROM additional_id WHERE employee_number = '$emp_no'");
      $sql->execute();

      if($sql->fetch()) {
        $query3 = $conn->prepare("UPDATE additional_id SET additional_id = '$additionalId' WHERE employee_number = '$emp_no'");
        $query3->execute();
      } else {
        $qry = $conn->prepare("INSERT INTO additional_id SET additional_id = '$additionalId', employee_number = '$emp_no'");
        $qry->execute();
      }
    }

  } else {
    $additionalId = '';
  }

  if(!empty($_FILES["proofOFBilling"]["name"])) {
    $target_dir = "../documents/".$emp_no."/proof_of_billing/";
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
      mkdir($path_filename_ext, 0777, true);
    }
    $path_filename_ext .= $proofOFBilling;

    if(move_uploaded_file($temp_name,$path_filename_ext)) {
      $sql = $conn->prepare("SELECT id FROM proof_of_billing WHERE employee_number = '$emp_no'");
      $sql->execute();

      if($sql->fetch()) {
        $query4 = $conn->prepare("UPDATE proof_of_billing SET proof_of_billing = '$proofOFBilling' WHERE employee_number = '$emp_no'");
        $query4->execute();
      } else {
        $qry = $conn->prepare("INSERT INTO proof_of_billing SET proof_of_billing = '$proofOFBilling', employee_number = '$emp_no'");
        $qry->execute();
      }
    }

  } else {
    $proofOFBilling = '';
  }

  session_start();
  $useraction = $_SESSION['fullname'];
  $dateaction = date('Y-m-d');
  $auditaction = "Update the contact info of Employee no".$emp_no;
  $audittype = "EDIT";
  $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
  $q->execute();
  echo json_encode(array("employeeno"=>$emp_no));

}

}

$x = new crud();

// if(isset($_GET['demp_stat'])){
// $x->demp_stat();
// }
// if(isset($_GET['dcompany'])){
// $x->dcompany();
// }
// if(isset($_GET['ddepartment'])){
// $x->ddepartment();
// }
// if(isset($_GET['selectcontact'])){
// $x->selectcontact();
// }
// if(isset($_GET['update'])){
// $x->update();
// }

// if(isset($_GET['selectAdditionalDocuments'])){
//   $x->selectAdditionalDocuments();
// }
 ?>
