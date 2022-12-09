<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function delete_dept(){

      $dept_id = $_POST['id'];
      $conn = $this->connect_mysql();

      $squery = $conn->prepare("DELETE FROM department WHERE id='$dept_id'");
      $squery->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Delete department ";
      $audittype = "Delete";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

  }

  function add_dept(){
      
      $dept_text = $_POST['dept_text'];
      $conn = $this->connect_mysql();

      $squery = $conn->prepare("INSERT INTO department SET department='$dept_text', statuss='active'");
      $squery->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Added new department ".$dept_text;
      $audittype = "ADD";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function update_dept(){
      
      $dept_id = $_POST['dept_id'];
      $dept_text = $_POST['dept_text'];
      $conn = $this->connect_mysql();

      $squery = $conn->prepare("UPDATE department SET department='$dept_text' WHERE id='$dept_id'");
      $squery->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update department ".$dept_text;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

  }

  function load_department(){

    $conn= $this->connect_mysql();

    $query = $conn->prepare("SELECT * FROM department ORDER BY department ASC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $id = $x['id'];
          $data['department'] = $x['department'];
          $data['action'] = '<button onclick="update_dept('.$x['id'].',\''.$x['department'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-edit"></i> Update</button>

           <button onclick="delete_dept('.$x['id'].')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));

  }

}

$x = new crud();

if(isset($_GET['delete_dept'])){
  $x->delete_dept();
}

if(isset($_GET['add_dept'])){
  $x->add_dept();
}

if(isset($_GET['update_dept'])){
  $x->update_dept();
}

if(isset($_GET['load_department'])){
  $x->load_department();
}

 ?>

