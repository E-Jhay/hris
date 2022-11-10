<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function loadusertype(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM user_role");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select usertype--</option>';
      while($row=$sql->fetch()){
       foreach ($row as $key => $input_arr) { 
          $row[$key] = addslashes($input_arr);
          $row[$key] = utf8_encode($input_arr);
        }
       $option.='<option value="'.$row['usertype'].'">'.$row['usertype'].'</option>';
      }
      // echo json_encode(array("data"=>$option));
      echo $option;
  }

  function adduserrole(){

      $modal_userroleid = $_POST['modal_userroleid'];
      $modal_userrole = $_POST['modal_userrole'];
      $modal_userroletype = $_POST['modal_userroletype'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("INSERT INTO user_role SET usertype='$modal_userroletype', userrole='$modal_userrole', useraccess='1,2,3', userstatus='active'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Added new user role ".$modal_userroletype;
      $audittype = "ADD";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function updateuserrole(){

      $modal_userroleid = $_POST['modal_userroleid'];
      $modal_userrole = $_POST['modal_userrole'];
      $modal_userroletype = $_POST['modal_userroletype'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("UPDATE user_role SET usertype='$modal_userroletype', userrole='$modal_userrole' WHERE id='$modal_userroleid'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update user role ".$modal_userroletype;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function deleteuserrole(){

      $id = $_POST['id'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("DELETE FROM user_role  WHERE id='$id'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Delete user role";
      $audittype = "Delete";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function loaduser(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM user_account WHERE id !='1' ORDER BY fullname ASC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) { 
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }
          $data = array();
          $data['action'] = '<button class="btn btn-sm btn-success" onclick="edituser('.$x['id'].',\''.$x['fullname'].'\',\''.$x['username'].'\',\''.$x['password'].'\',\''.$x['empstatus'].'\',\''.$x['usertype'].'\',\''.$x['userrole'].'\',\''.$x['approver'].'\')"><i class="fas fa-sm fa-edit"></i> Edit</button>';
          $data['employeeno'] = $x['employeeno'];
          $data['fullname'] = utf8_decode($x['fullname']);
          $data['username'] = utf8_decode($x['username']);
          $data['password'] = "******";
          $data['usertype'] = $x['usertype'];
          $data['active_status'] = $x['empstatus'];

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function loaduser_role(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM user_role");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) { 
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }
          $data = array();
          $data['action'] = '<button onclick="edituser_role('.$x['id'].',\''.$x['usertype'].'\',\''.$x['userrole'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-edit"></i> Edit</button>
          <button onclick="deleteuser_role('.$x['id'].')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';
          $data['user_role'] = $x['userrole'];
          $data['user_role_type'] = $x['usertype'];

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function updateuser(){

      $user_id = $_POST['user_id'];
      $fullname = $_POST['fullname'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $usertype = $_POST['usertype'];
      $active_status = $_POST['active_status'];
      $userrole = $_POST['userrole'];
      $approverr = $_POST['approverr'];

      $conn = $this->connect_mysql();
      $qry = $conn->prepare("UPDATE user_account SET fullname='$fullname', username='$username', password='$password', empstatus='$active_status', usertype='$usertype',userrole='$userrole',approver='$approverr' WHERE id='$user_id'");
      $qry->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update user account for ".$fullname;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

  }

}

$x = new crud();

if(isset($_GET['loadusertype'])){
  $x->loadusertype();
}

if(isset($_GET['adduserrole'])){
  $x->adduserrole();
}

if(isset($_GET['updateuserrole'])){
  $x->updateuserrole();
}

if(isset($_GET['deleteuserrole'])){
  $x->deleteuserrole();
}

if(isset($_GET['loaduser'])){
  $x->loaduser();
}

if(isset($_GET['loaduser_role'])){
  $x->loaduser_role();
}

if(isset($_GET['updateuser'])){
  $x->updateuser();
}

 ?>
