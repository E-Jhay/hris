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

function selectmedical(){
  $employeeno = $_POST['employeeno'];
  $conn = $this->connect_mysql();
  $query = $conn->prepare("SELECT a.*,a.employeeno as emp_no,b.* FROM tbl_employee a 
                            LEFT JOIN medicalinfo b 
                            ON a.employeeno = b.employeeno
                            WHERE a.employeeno='$employeeno'");
  $query->execute();
  $row = $query->fetch();

  foreach ($row as $key => $input_arr) {
    $row[$key] = addslashes($input_arr);
    $row[$key] = utf8_encode($input_arr);
  }
  
  if($row['imagepic'] == NULL || $row['imagepic'] == ''){
    $row['imagepic'] = 'personal_picture/usera.png';
  } else {
      if(!file_exists('../personal_picture/'.$row['emp_no'].'/'.$row['imagepic'])){
        $row['imagepic'] = 'personal_picture/'.$row['imagepic'];
      } else {
        $row['imagepic'] = 'personal_picture/'.$row['emp_no'].'/'.$row['imagepic'];
      }
  }
  echo json_encode(array(
    'emp_no'=>$row['emp_no'],
    'f_name'=>$row['firstname'],
    'l_name'=>utf8_decode($row['lastname']),
    'm_name'=>$row['middlename'],
    'rank'=>$row['rank'],
    'statuss'=>$row['statuss'],
    'emp_statuss'=>$row['employment_status'],
    'company'=>$row['company'],
    'leave_balance'=>$row['leave_balance'],
    'imagepic'=>utf8_decode($row['imagepic']),
    'department'=>$row['department']

  ));
}

function editmedical(){

  $emp_no = $_POST['emp_no'];
  $f_name = $_POST['f_name'];
  $l_name = $_POST['l_name'];
  $m_name = $_POST['m_name'];
  $rank = $_POST['rank'];
  $statuss = $_POST['statuss'];
  $emp_statuss = $_POST['emp_statuss'];
  $company = $_POST['company'];

  // $empid = $_POST['emp_id'];
  $type1 = $_POST['type1'];
  $classification1 = $_POST['classification1'];
  $status1 = $_POST['status1'];
  $dateofexam1 = $_POST['dateofexam1'] != '' ? $_POST['dateofexam1'] : '0000-00-00';
  $remarks1 = $_POST['remarks1'];
  $type2 = $_POST['type2'];
  $classification2 = $_POST['classification2'];
  $status2 = $_POST['status2'];
  $dateofexam2 = $_POST['dateofexam2'] != '' ? $_POST['dateofexam2'] : '0000-00-00';
  $remarks2 = $_POST['remarks2'];
  $type3 = $_POST['type3'];
  $classification3 = $_POST['classification3'];
  $status3 = $_POST['status3'];
  $dateofexam3 = $_POST['dateofexam3'] != '' ? $_POST['dateofexam3'] : '0000-00-00';
  $remarks3 = $_POST['remarks3'];
  $leave_balance = $_POST['leave_balance'];
  $department = $_POST['department'];

  $conn = $this->connect_mysql();
  $sql = $conn->prepare("SELECT employeeno FROM medicalinfo WHERE employeeno = '$emp_no'");
  $sql->execute();

  $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE employeeno = '$emp_no'");
  $qry1->execute();

  if($sql->fetch()) {
    $qry = $conn->prepare("UPDATE medicalinfo SET type1='$type1', classification1='$classification1', status1='$status1', dateofexam1='$dateofexam1', remarks1='$remarks1', type2='$type2', classification2='$classification2', status2='$status2', dateofexam2='$dateofexam2', remarks2='$remarks2', type3='$type3', classification3='$classification3', status3='$status3', dateofexam3='$dateofexam3', remarks3='$remarks3' WHERE employeeno = '$emp_no'");
    $qry->execute();
  } else {
    $qry = $conn->prepare("INSERT INTO medicalinfo SET type1='$type1', classification1='$classification1', status1='$status1', dateofexam1='$dateofexam1', remarks1='$remarks1', type2='$type2', classification2='$classification2', status2='$status2', dateofexam2='$dateofexam2', remarks2='$remarks2', type3='$type3', classification3='$classification3', status3='$status3', dateofexam3='$dateofexam3', remarks3='$remarks3', employeeno = '$emp_no'");
    $qry->execute();
  }

  session_start();
  $useraction = $_SESSION['fullname'];
  $dateaction = date('Y-m-d');
  $auditaction = "Update the medical info of Employee no".$emp_no;
  $audittype = "EDIT";
  $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
  $q->execute();

  echo json_encode(array("employeeno"=>$emp_no));

}

function addMedical(){

  $employeeno = $_POST['employeeno'];
  $type = $_POST['type'];
  $classification = $_POST['classification'];
  $status = $_POST['status'];
  $date_of_examination = $_POST['date_of_examination'];
  $remarks = $_POST['remarks'];
  $file = $_FILES['file'];

  if (($_FILES['file']['name']!="")){
    // Where the file is going to be stored
    $target_dir = "../medical/".$employeeno."/";
    $file = $_FILES['file']['name'];
    $path = pathinfo($file);
    $filename = $path['filename'];
    $ext = $path['extension'];
    $attachfile = $filename.date('Y-m-d-His').".".$ext;
    $temp_name = $_FILES['file']['tmp_name'];
    $path_filename_ext = $target_dir.$attachfile;

    // Check if file already exists
    if (file_exists($path_filename_ext)) {
      echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error", "employeeno" => $employeeno));
      exit;
    }else{
      if(!is_dir("../medical/".$employeeno."/")){
        mkdir("../medical/".$employeeno."/");
      }

      move_uploaded_file($temp_name,$path_filename_ext);
    }
  } else {
    $attachfile = '';
  }

  $conn = $this->connect_mysql();
  $qry = $conn->prepare("INSERT INTO medicalinfo SET type = '$type', classification = '$classification', status = '$status', date_of_examination = '$date_of_examination', remarks = '$remarks', file_name = '$attachfile', employeeno = '$employeeno'");
  $qry->execute();

  echo json_encode(array('type'=>'success', 'message' => 'Medical successfully added'));

}

function load_medical(){
  $employeeno = $_GET['employeeno'];
  $conn = $this->connect_mysql();
  $query = $conn->prepare("SELECT * FROM medicalinfo
                           WHERE employeeno='$employeeno'");
  $query->execute();
  $row = $query->fetchAll();

  $return = array();
  foreach ($row as $x){

    foreach ($x as $key => $input_arr) {
      $x[$key] = addslashes($input_arr);
      $x[$key] = utf8_encode($input_arr);
    }
    $data = array();
    $data['action'] = '<center class="d-flex justify-content-around">
                          <button title="Edit" onclick="edit(\''.$x['id'].'\',\''.$x['type'].'\',\''.$x['classification'].'\',\''.$x['status'].'\',\''.$x['date_of_examination'].'\',\''.$x['remarks'].'\',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')"  class="btn btn-warning btn-sm">
                            <i class="fas fa-sm fa-edit"></i>
                            Edit
                          </button>
                          <button title="Delete" onclick="deleteMedical(\''.$x['id'].'\',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')"  class="btn btn-danger btn-sm">
                            <i class="fas fa-sm fa-trash"></i>
                            Delete
                          </button>
                        </center> ';
    // $data['employeeno'] = $x['employeeno'];
    $data['type'] = ucfirst($x['type']);
    $data['classification'] = ucfirst($x['classification']);
    $data['status'] = ucfirst($x['status']);
    $data['date_of_examination'] = $x['date_of_examination'];
    $data['remarks'] = $x['remarks'];
    $disabled = $x['file_name'] == '' ? 'disabled' : '';
    $text = $x['file_name'] == '' ? 'Unavailable' : 'View FIle';
    $data['file'] = '<center>
                      <button '.$disabled.' title="View Id" onclick="viewFile(\''.$x['file_name'].'\',\''.$x['employeeno'].'\')"  class="btn btn-primary btn-sm">
                        <i class="fas fa-sm fa-eye"></i>
                        '.$text.'
                      </button>
                    </center>';
    $return[] = $data;
  }
  echo json_encode(array('data'=>$return));
}

function deleteMedical() {
  $employeeno = $_POST['employeeno'];
  $file_name = $_POST['file_name'];
  $id = $_POST['id'];

  $conn = $this->connect_mysql();
  $query = $conn->prepare("DELETE FROM medicalinfo WHERE id='$id'");
  $query->execute();

  $link_file = "../medical/".$employeeno."/".$file_name;
  unlink($link_file);
}

function updateMedical() {

  $id = $_POST['medical_id'];
  $type = $_POST['medical_type'];
  $classification = $_POST['medical_classification'];
  $status = $_POST['medical_status'];
  $date_of_examination = $_POST['medical_date_of_examination'];
  $remarks = $_POST['medical_remarks'];
  $currentFile = $_POST['medical_file_name'];
  // $file = $_POST['medical_file'];
  $employeeno = $_POST['medical_employeeno'];
  $dateNow = date('Y-m-d');

  $conn = $this->connect_mysql();
  if($_FILES['medical_file']['size'] > 0) {
    // Where the file is going to be stored
    $target_dir = "../medical/".$employeeno."/";
    $file = $_FILES['medical_file']['name'];
    $path = pathinfo($file);
    $filename = $path['filename'];
    $ext = $path['extension'];
    $attachfile = $filename.date('Y-m-d-His').".".$ext;
    $temp_name = $_FILES['medical_file']['tmp_name'];
    $path_filename_ext = $target_dir.$attachfile;

    if(!is_dir("../medical/".$employeeno."/")){
      mkdir("../medical/".$employeeno."/");
    }

    if(move_uploaded_file($temp_name,$path_filename_ext)){
      if($currentFile != '' || $currentFile != NULL){
        $link_file = $target_dir.$currentFile;
        if(file_exists($link_file))
        unlink($link_file);
      }

      $conn = $this->connect_mysql();

      $qry = $conn->prepare("UPDATE medicalinfo SET type = '$type', classification = '$classification', status = '$status', date_of_examination = '$date_of_examination', remarks = '$remarks', file_name = '$attachfile' WHERE id='$id'");
      $qry->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the Medical of Employee no ".$employeeno;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

      echo json_encode(array('message' => 'Medical Updated Successfully', 'type' => 'success'));
      exit;
    }
  }
  else {
    $query = $conn->prepare("UPDATE medicalinfo SET type = '$type', classification = '$classification', status = '$status', date_of_examination = '$date_of_examination', remarks = '$remarks' WHERE id='$id'");
    $query->execute();

    session_start();
    $useraction = $_SESSION['fullname'];
    $dateaction = date('Y-m-d');
    $auditaction = "Update the MEdical of Employee no ".$employeeno;
    $audittype = "EDIT";
    $query2 = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
    $query2->execute();
    echo json_encode(array("message"=>"Medical Updated Successfully", "type" => "success", "employeeno" => $employeeno));
    exit;
  }
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
if(isset($_GET['selectmedical'])){
  $x->selectmedical();
}
if(isset($_GET['editmedical'])){
  $x->editmedical();
}
if(isset($_GET['addMedical'])){
  $x->addMedical();
}
if(isset($_GET['load_medical'])){
  $x->load_medical();
}
if(isset($_GET['deleteMedical'])){
  $x->deleteMedical();
}
if(isset($_GET['updateMedical'])){
  $x->updateMedical();
}

 ?>
