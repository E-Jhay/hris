<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function selectotherid(){
    $emp_id = $_POST['emp_id'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT a.*,b.*,c.date_hired FROM tbl_employee a 
                             LEFT JOIN otheridinfo b 
                             ON a.id = b.emp_id
                             LEFT JOIN contractinfo c
                             ON a.id = c.emp_id
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
      'comp_id_dateissue'=>$row['comp_id_dateissue'],
      'comp_id_vdate'=>$row['comp_id_vdate'],
      'fac_ap_dateissue'=>$row['fac_ap_dateissue'],
      'fac_ap_vdate'=>$row['fac_ap_vdate'],
      'leave_balance'=>$row['leave_balance'],
      'imagepic'=>utf8_decode($row['imagepic']),
      'department'=>$row['department'],
      'job_title'=>$row['job_title'],
      'date_hired'=>$row['date_hired'],
      'card_number'=>$row['card_number'],
      'driver_id'=>$row['driver_id'],
      'driver_exp'=>$row['driver_exp'],
      'prc_number'=>$row['prc_number'],
      'prc_exp'=>$row['prc_exp'],
      'civil_service'=>$row['civil_service']

    ));
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

  function check_file(){
      $conn = $this->connect_mysql();
      $fragment = $_POST['fragment'];
      $employeeno = $_POST['employeeno'];
      $newfragment = substr($fragment, 0, -2);
      $founded = "";
      $strnew = explode("**",$newfragment);
      $strcount = count($strnew);
      $a = 0;
      for($a==0;$a<$strcount;$a++){
        $filename = $strnew[$a];
        $squery = $conn->prepare("SELECT * FROM file_attach WHERE filename='$filename' AND employeeno='$employeeno'");
        $squery->execute();
        $found = $squery->rowCount();
        if($found>=1){
          $founded .= "- ".$filename."\n";
        }
      }
      if($founded !=""){
        $newfounded = substr($founded, 0, -1);  
      }else{
        $newfounded = "";
      }
      

      echo json_encode(array("fragment"=>$newfragment,"count"=>$strcount,"founded"=>$newfounded));
  }

  function deletefile(){


    $id = $_POST['id'];
    $filename = $_POST['filename'];
    $employeeno = $_POST['employeeno'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("DELETE FROM file_attach WHERE id='$id'");
    $query->execute();

    $link_file = "../attach_file/".$employeeno."/".$filename;
    unlink($link_file);



  }

  function loadfile(){

    $employeeno = $_GET['employeeno'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM file_attach WHERE employeeno='$employeeno' ORDER BY id DESC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $data['action'] = '<center>
          <button onclick="dl_file(\''.$x['filename'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-download"></i> Download</button>
          <button onclick="delete_file('.$x['id'].',\''.$x['filename'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>
          
          </center>
          ';
          $data['file_name'] = $x['filename'];

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function uploadfile(){

    if (($_FILES['empfile']['name']!="")){
      session_start();
      $countfiles = count($_FILES['empfile']['name']);


      for($i=0;$i<$countfiles;$i++){
       
           $employeeid = $_POST['emp_id'];
           $employeeno = $_POST['emp_no'];

          // Where the file is going to be stored
           $target_dir = "../attach_file/".$employeeno."/";
           $file = $_FILES['empfile']['name'][$i];
           $path = pathinfo($file);
           $filename = $path['filename'];
           $ext = $path['extension'];
           $attachfile = $filename.".".$ext;
           $temp_name = $_FILES['empfile']['tmp_name'][$i];
           $path_filename_ext = $target_dir.$filename.".".$ext;

          // Check if file already exists
           if (file_exists($path_filename_ext)) {
            echo json_encode(array("id"=>$employeeid, "error" => true, "message" => "Sorry, file already exists."));
            exit;
           }else{
            
            if (!file_exists($target_dir)) {
              mkdir('../attach_file/'.$employeeno);
            }

            $lto_upload = $target_dir.$attachfile;
            // unlink($lto_upload);

            move_uploaded_file($temp_name,$path_filename_ext);

            $conn=$this->connect_mysql();
            $sql = $conn->prepare("INSERT INTO file_attach SET employeeno='$employeeno',filename='$attachfile'");
            $sql->execute();

            
            $useraction = $_SESSION['fullname'];
            $dateaction = date('Y-m-d');
            $auditaction = "Added new file for Employee no".$employeeno;
            $audittype = "ADD";
            $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
            $q->execute();

           }
      }
      echo json_encode(array("id"=>$employeeid, "error" => false, "message" => "Successfully Saved"));


    }

  }

}

$x = new crud();

if(isset($_GET['uploadfile'])){
  $x->uploadfile();
}
if(isset($_GET['loadfile'])){
  $x->loadfile();
}
if(isset($_GET['deletefile'])){
  $x->deletefile();
}
if(isset($_GET['check_file'])){
  $x->check_file();
}
if(isset($_GET['selectotherid'])){
  $x->selectotherid();
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
