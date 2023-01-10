<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

// jerico
  function selectotherid(){
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,a.employeeno as emp_no,c.date_hired FROM tbl_employee a 
                             LEFT JOIN contractinfo c
                             ON a.employeeno = c.employeeno
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
      'department'=>$row['department'],
      'job_title'=>$row['job_title'],
      'date_hired'=>$row['date_hired'],
    ));
  }
  function load_other_id(){
    $employeeno = $_GET['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM otheridinfo
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
                            <button title="Edit" onclick="edit(\''.$x['id'].'\',\''.$x['id_type'].'\',\''.$x['card_number'].'\',\''.$x['description'].'\',\''.$x['date_issued'].'\',\''.$x['validity_date'].'\',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')"  class="btn btn-warning btn-sm">
                              <i class="fas fa-sm fa-edit"></i>
                              Edit
                            </button>
                            <button title="Delete" onclick="deleteId(\''.$x['id'].'\',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')"  class="btn btn-danger btn-sm">
                              <i class="fas fa-sm fa-trash"></i>
                              Delete
                            </button>
                          </center> ';
      // $data['employeeno'] = $x['employeeno'];
      $data['id_type'] = ucfirst($x['id_type']);
      $data['card_number'] = $x['card_number'];
      $data['description'] = ucfirst($x['description']);
      $data['date_issued'] = $x['date_issued'];
      $data['validity_date'] = $x['validity_date'];
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
// jerico
  // function editotherid(){

  //     $emp_no = $_POST['emp_no'];
  //     $f_name = $_POST['f_name'];
  //     $l_name = $_POST['l_name'];
  //     $m_name = $_POST['m_name'];
  //     $rank = $_POST['rank'];
  //     $statuss = $_POST['statuss'];
  //     $emp_statuss = $_POST['emp_statuss'];
  //     $company = $_POST['company'];

  //     // $empid = $_POST['emp_id'];
  //     $comp_id_dateissue = $_POST['comp_id_dateissue'] != '' ? $_POST['comp_id_dateissue'] : '0000-00-00';
  //     $comp_id_vdate = $_POST['comp_id_vdate'] != '' ? $_POST['comp_id_vdate'] : '0000-00-00';
  //     $fac_ap_dateissue = $_POST['fac_ap_dateissue']  != '' ? $_POST['fac_ap_dateissue'] : '0000-00-00';
  //     $fac_ap_vdate = $_POST['fac_ap_vdate'] != '' ? $_POST['fac_ap_vdate'] : '0000-00-00';
  //     $leave_balance = $_POST['leave_balance'];
  //     $department = $_POST['department'];
  //     $fac_card_number = $_POST['fac_card_number'];
  //     $driver_id = $_POST['driver_id'];
  //     $driver_exp = $_POST['driver_exp'] != '' ? $_POST['driver_exp'] : '0000-00-00';
  //     $prc_number = $_POST['prc_number'];
  //     $prc_exp = $_POST['prc_exp'] != '' ? $_POST['prc_exp'] : '0000-00-00';
  //     $civil_service = $_POST['civil_service'];

  //     $conn = $this->connect_mysql();
  //     $sql = $conn->prepare("SELECT employeeno FROM otheridinfo WHERE employeeno = '$emp_no'");
  //     $sql->execute();

  //     $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE employeeno = '$emp_no'");
  //     $qry1->execute();

  //     if($sql->fetch()) {
  //       $qry = $conn->prepare("UPDATE otheridinfo SET comp_id_dateissue='$comp_id_dateissue', comp_id_vdate='$comp_id_vdate', fac_ap_dateissue='$fac_ap_dateissue', fac_ap_vdate='$fac_ap_vdate', card_number='$fac_card_number',driver_id='$driver_id',driver_exp='$driver_exp',prc_number='$prc_number',prc_exp='$prc_exp',civil_service='$civil_service' WHERE employeeno = '$emp_no'");
  //       $qry->execute();
  //     } else {
  //       $qry = $conn->prepare("INSERT INTO otheridinfo SET comp_id_dateissue='$comp_id_dateissue', comp_id_vdate='$comp_id_vdate', fac_ap_dateissue='$fac_ap_dateissue', fac_ap_vdate='$fac_ap_vdate', card_number='$fac_card_number',driver_id='$driver_id',driver_exp='$driver_exp',prc_number='$prc_number',prc_exp='$prc_exp',civil_service='$civil_service', employeeno = '$emp_no'");
  //       $qry->execute();
  //     }

  //     session_start();
  //     $useraction = $_SESSION['fullname'];
  //     $dateaction = date('Y-m-d');
  //     $auditaction = "Update the other id info of Employee no".$emp_no;
  //     $audittype = "EDIT";
  //     $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
  //     $q->execute();

  //     echo json_encode(array("employeeno"=>$emp_no));

  // }
  function addId(){

      $employeeno = $_POST['employeeno'];
      $id_type = $_POST['id_type'];
      $card_number = $_POST['card_number'];
      $description = $_POST['description'];
      $date_issued = $_POST['date_issued'];
      $validity_date = $_POST['validity_date'];
      $file = $_FILES['file'];

      if (($_FILES['file']['name']!="")){
        // Where the file is going to be stored
        $target_dir = "../ids/".$employeeno."/";
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
          if(!is_dir("../ids/".$employeeno."/")){
            mkdir("../ids/".$employeeno."/");
          }

          move_uploaded_file($temp_name,$path_filename_ext);
        }
      } else {
        $attachfile = '';
      }

      $conn = $this->connect_mysql();
      // $qry1 = $conn->prepare("UPDATE tbl_employee SET employeeno='$emp_no',lastname='$l_name', firstname='$f_name', middlename='$m_name', rank='$rank', statuss='$statuss', employment_status='$emp_statuss', company='$company',leave_balance='$leave_balance',department='$department' WHERE employeeno = '$employeeno'");
      // $qry1->execute();
      $qry = $conn->prepare("INSERT INTO otheridinfo SET id_type = '$id_type', card_number = '$card_number', description = '$description', date_issued = '$date_issued', validity_date = '$validity_date', file_name = '$attachfile', employeeno = '$employeeno'");
      $qry->execute();

      echo json_encode(array('type'=>'success', 'message' => 'ID successfully added'));

      // $empid = $_POST['emp_id'];
      // $comp_id_dateissue = $_POST['comp_id_dateissue'] != '' ? $_POST['comp_id_dateissue'] : '0000-00-00';
      // $comp_id_vdate = $_POST['comp_id_vdate'] != '' ? $_POST['comp_id_vdate'] : '0000-00-00';
      // $fac_ap_dateissue = $_POST['fac_ap_dateissue']  != '' ? $_POST['fac_ap_dateissue'] : '0000-00-00';
      // $fac_ap_vdate = $_POST['fac_ap_vdate'] != '' ? $_POST['fac_ap_vdate'] : '0000-00-00';
      // $leave_balance = $_POST['leave_balance'];
      // $department = $_POST['department'];
      // $fac_card_number = $_POST['fac_card_number'];
      // $driver_id = $_POST['driver_id'];
      // $driver_exp = $_POST['driver_exp'] != '' ? $_POST['driver_exp'] : '0000-00-00';
      // $prc_number = $_POST['prc_number'];
      // $prc_exp = $_POST['prc_exp'] != '' ? $_POST['prc_exp'] : '0000-00-00';
      // $civil_service = $_POST['civil_service'];

      

  }

  function deleteId() {
    $employeeno = $_POST['employeeno'];
    $file_name = $_POST['file_name'];
    $id = $_POST['id'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("DELETE FROM otheridinfo WHERE id='$id'");
    $query->execute();

    $link_file = "../ids/".$employeeno."/".$file_name;
    unlink($link_file);
  }

  
  function updateOtherId() {

    $id = $_POST['other_id_id'];
    $id_type = $_POST['other_id_id_type'];
    $card_number = $_POST['other_id_card_number'];
    $description = $_POST['other_id_description'];
    $date_issued = $_POST['other_id_date_issued'];
    $validity_date = $_POST['other_id_validity_date'];
    $currentFile = $_POST['other_id_file_name'];
    // $file = $_POST['other_id_file'];
    $employeeno = $_POST['other_id_employeeno'];
    $dateNow = date('Y-m-d');

    $conn = $this->connect_mysql();
    if($_FILES['other_id_file']['size'] > 0) {
      // Where the file is going to be stored
      $target_dir = "../ids/".$employeeno."/";
      $file = $_FILES['other_id_file']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $attachfile = $filename.date('Y-m-d-His').".".$ext;
      $temp_name = $_FILES['other_id_file']['tmp_name'];
      $path_filename_ext = $target_dir.$attachfile;

      if(!is_dir("../ids/".$employeeno."/")){
        mkdir("../ids/".$employeeno."/");
      }

      if(move_uploaded_file($temp_name,$path_filename_ext)){
        if($currentFile != '' || $currentFile != NULL){
          $link_file = $target_dir.$currentFile;
          if(file_exists($link_file))
          unlink($link_file);
        }

        $conn = $this->connect_mysql();

        $qry = $conn->prepare("UPDATE otheridinfo SET id_type = '$id_type', card_number = '$card_number', description = '$description', date_issued = '$date_issued', validity_date = '$validity_date', file_name = '$attachfile' WHERE id='$id'");
        $qry->execute();

        session_start();
        $useraction = $_SESSION['fullname'];
        $dateaction = date('Y-m-d');
        $auditaction = "Update the ID of Employee no ".$employeeno;
        $audittype = "EDIT";
        $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
        $q->execute();

        echo json_encode(array('message' => 'ID Updated Successfully', 'type' => 'success'));
        exit;
      }
    }
    else {
      $query = $conn->prepare("UPDATE otheridinfo SET id_type = '$id_type', card_number = '$card_number', description = '$description', date_issued = '$date_issued', validity_date = '$validity_date' WHERE id='$id'");
      $query->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the ID of Employee no ".$employeeno;
      $audittype = "EDIT";
      $query2 = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $query2->execute();
      echo json_encode(array("message"=>"ID Updated Successfully", "type" => "success", "employeeno" => $employeeno));
      exit;
    }
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
  
}

$x = new crud();

if(isset($_GET['selectotherid'])){
  $x->selectotherid();
}
if(isset($_GET['editotherid'])){
  $x->editotherid();
}
if(isset($_GET['load_other_id'])){
  $x->load_other_id();
}
if(isset($_GET['addId'])){
  $x->addId();
}
if(isset($_GET['deleteId'])){
  $x->deleteId();
}
if(isset($_GET['updateOtherId'])){
  $x->updateOtherId();
}
if(isset($_GET['demp_stat'])){
  $x->demp_stat();
}
if(isset($_GET['dcompany'])){
  $x->dcompany();
}
if(isset($_GET['ddepartment'])){
  $x->ddepartment();
}

 ?>
