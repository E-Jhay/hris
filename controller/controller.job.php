<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function addjobcat(){

      $modal_jobcatid = $_POST['modal_jobcatid'];
      $modal_jobcatname = $_POST['modal_jobcatname'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("INSERT INTO job_categories SET job_category='$modal_jobcatname', status='active'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Added new Job Category ".$modal_jobcatname;
      $audittype = "ADD";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function updatejobcat(){

      $modal_jobcatid = $_POST['modal_jobcatid'];
      $modal_jobcatname = $_POST['modal_jobcatname'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("UPDATE job_categories SET job_category='$modal_jobcatname' WHERE id='$modal_jobcatid'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update the job category ".$modal_jobcatname;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function deletejobcat(){

      $id = $_POST['id'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("DELETE FROM job_categories WHERE id='$id'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Delete job category";
      $audittype = "Delete";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function addempstatus(){

      $modal_empstatusid = $_POST['modal_empstatusid'];
      $modal_empstatusname = $_POST['modal_empstatusname'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("INSERT INTO employment_status SET employment_status='$modal_empstatusname', status='active'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Added new employment status ".$modal_empstatusname;
      $audittype = "ADD";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

  }

  function deleteempstatus(){

      $id = $_POST['id'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("DELETE FROM employment_status WHERE id='$id'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Delete employment status";
      $audittype = "Delete";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function updateempstatus(){

      $modal_empstatusid = $_POST['modal_empstatusid'];
      $modal_empstatusname = $_POST['modal_empstatusname'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("UPDATE employment_status SET employment_status='$modal_empstatusname' WHERE id='$modal_empstatusid'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update employment status ";
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function addjob(){

    $modal_jobtitle = $_POST['modal_jobtitle'];
    $modal_jobdescription = $_POST['modal_jobdescription'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("INSERT INTO job_titles SET job_title='$modal_jobtitle',job_desc='$modal_jobdescription',job_status='active'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Added new job title ".$modal_jobtitle;
      $audittype = "ADD";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

  }

  function editjob(){

    $modal_jobid = $_POST['modal_jobid'];
    $modal_jobtitle = $_POST['modal_jobtitle'];
    $modal_jobdescription = $_POST['modal_jobdescription'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("UPDATE job_titles SET job_title='$modal_jobtitle',job_desc='$modal_jobdescription' WHERE id='$modal_jobid'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update job title ".$modal_jobtitle;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

  }

  function deletejob(){

    $id = $_POST['id'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("DELETE FROM job_titles WHERE id='$id'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Deleted job title.";
      $audittype = "Delete";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();
  }

  function loadjobtitle(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM job_titles ORDER BY job_title ASC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }
          $data = array();
          $data['action'] = '<button onclick="editjob_title('.$x['id'].',\''.$x['job_title'].'\',\''.$x['job_desc'].'\')" class="btn btn-sm btn-success" ><i class="fas fa-sm fa-edit"></i> Edit</button>
          <button onclick="deletejob_title('.$x['id'].')" class="btn btn-sm btn-danger" ><i class="fa fa-trash-alt"></i> Delete</button>';
          $data['job_title'] = $x['job_title'];
          $data['job_desc'] = $x['job_desc'];

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function loademployment_status(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM employment_status ORDER BY employment_status ASC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $data['action'] = '<button onclick="edit_empstatus('.$x['id'].',\''.$x['employment_status'].'\')" class="btn btn-sm btn-success" ><i class="fas fa-sm fa-edit"></i> Edit</button>
          <button onclick="delete_empstatus('.$x['id'].')" class="btn btn-sm btn-danger" ><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';
          $data['employment_status'] = $x['employment_status'];

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function loadjobcategory(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM job_categories");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $data['action'] = '<button onclick="edit_jobcategory('.$x['id'].',\''.$x['job_category'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-edit"></i> Edit</button>
          <button onclick="delete_jobcategory('.$x['id'].')" class="btn btn-sm btn-danger" ><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';
          $data['job_category'] = $x['job_category'];

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }


}

$x = new crud();

if(isset($_GET['addjobcat'])){
  $x->addjobcat();
}

if(isset($_GET['updatejobcat'])){
  $x->updatejobcat();
}

if(isset($_GET['deletejobcat'])){
  $x->deletejobcat();
}

if(isset($_GET['addempstatus'])){
  $x->addempstatus();
}

if(isset($_GET['deleteempstatus'])){
  $x->deleteempstatus();
}

if(isset($_GET['updateempstatus'])){
  $x->updateempstatus();
}

if(isset($_GET['addjob'])){
  $x->addjob();
}

if(isset($_GET['editjob'])){
  $x->editjob();
}

if(isset($_GET['deletejob'])){
  $x->deletejob();
}

if(isset($_GET['loadjobtitle'])){
  $x->loadjobtitle();
}

if(isset($_GET['loademployment_status'])){
  $x->loademployment_status();
}

if(isset($_GET['loadjobcategory'])){
  $x->loadjobcategory();
}

 ?>
