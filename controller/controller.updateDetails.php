<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

// jerico
  function select(){
    $employeeno = $_POST['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*, b.street, b.municipality, b.province, b.proof_of_billing, c.marital_status, c.marriage_contract FROM tbl_employee a 
                             LEFT JOIN contactinfo b
                             ON a.employeeno = b.employeeno
                             LEFT JOIN otherpersonalinfo c
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
      'company'=>$row['company'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department'],
      'job_title'=>$row['job_title'],
      'marital_status'=>$row['marital_status'],
      'street'=>$row['street'],
      'municipality'=>$row['municipality'],
      'province'=>$row['province'],
      'proof_of_billing'=>$row['proof_of_billing'],
      'marriage_contract'=>$row['marriage_contract'],
    ));
  }
  
  function updateAddress() {
    $employeeno = $_POST['employeeno'];
    $street = $_POST['street'];
    $municipality = $_POST['municipality'];
    $province = $_POST['province'];
    $currentFile = $_POST['proof_of_billing'];

    $conn = $this->connect_mysql();
    if($_FILES['addressFile']['size'] > 0) {
      // Where the file is going to be stored
      $target_dir = "../documents/".$employeeno."/proof_of_billing/";
      $file = $_FILES['addressFile']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $attachfile = $filename.date('Y-m-d-His').".".$ext;
      $temp_name = $_FILES['addressFile']['tmp_name'];
      $path_filename_ext = $target_dir;

      
      if(!is_dir($path_filename_ext)){
        mkdir($path_filename_ext, 0777, true);
      }
      $path_filename_ext .= $attachfile;

      if(move_uploaded_file($temp_name,$path_filename_ext)){
        if($currentFile != '' || $currentFile != NULL){
          $link_file = $target_dir.$currentFile;
          if(file_exists($link_file))
          unlink($link_file);
        }

        $conn = $this->connect_mysql();

        $qry = $conn->prepare("UPDATE contactinfo SET street = '$street', municipality = '$municipality', province = '$province', proof_of_billing = '$attachfile' WHERE employeeno='$employeeno'");
        $qry->execute();
        echo json_encode(array('message' => 'Address Updated Successfully', 'type' => 'success'));
        exit;
      } else {
        echo json_encode(array('message' => 'There is an error during the ploading of file. Please try again', 'type' => 'error'));
        exit;
      }
    } else {
      echo json_encode(array('message' => 'Proof of Billing is required', 'type' => 'error'));
      exit;
    }
  }
  function updateCivilStatus() {
    $employeeno = $_POST['employeeno'];
    $civilStatus = $_POST['civilStatus'];
    $currentFile = $_POST['marriage_contract'];

    $conn = $this->connect_mysql();
    if(!empty($_FILES['marriageContractFile']['name'])) {
      // Where the file is going to be stored
      $target_dir = "../documents/".$employeeno."/marriage_contract/";
      $file = $_FILES['marriageContractFile']['name'];
      $path = pathinfo($file);
      $filename = $path['filename'];
      $ext = $path['extension'];
      $attachfile = $filename.date('Y-m-d-His').".".$ext;
      $temp_name = $_FILES['marriageContractFile']['tmp_name'];
      $path_filename_ext = $target_dir;

      
      if(!is_dir($path_filename_ext)){
        mkdir($path_filename_ext, 0777, true);
      }
      $path_filename_ext .= $attachfile;

      if(move_uploaded_file($temp_name,$path_filename_ext)){
        if($currentFile != '' || $currentFile != NULL){
          $link_file = $target_dir.$currentFile;
          if(file_exists($link_file))
          unlink($link_file);
        }

        $conn = $this->connect_mysql();

        $qry = $conn->prepare("UPDATE otherpersonalinfo SET marital_status = '$civilStatus', marriage_contract = '$attachfile' WHERE employeeno='$employeeno'");
        $qry->execute();
        echo json_encode(array('message' => 'Civil Status Updated Successfully', 'type' => 'success'));
        exit;
      } else {
        echo json_encode(array('message' => 'There is an error during the uploading of file. Please try again', 'type' => 'error'));
        exit;
      }
    } else {
      $conn = $this->connect_mysql();

      $qry = $conn->prepare("UPDATE otherpersonalinfo SET marital_status = '$civilStatus' WHERE employeeno='$employeeno'");
      $qry->execute();
      echo json_encode(array('message' => 'Civil Status Updated Successfully', 'type' => 'success'));
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

if(isset($_GET['select'])){
  $x->select();
}
if(isset($_GET['updateOtherId'])){
  $x->updateOtherId();
}
if(isset($_GET['updateAddress'])){
  $x->updateAddress();
}
if(isset($_GET['updateCivilStatus'])){
  $x->updateCivilStatus();
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
