<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function addnews(){

    $modal_newsid = $_POST['modal_newsid'];
    $modal_topic = $_POST['modal_topic'];
    $modal_date = $_POST['modal_date'];
    $modal_end_date = $_POST['modal_end_date'];

    $conn=$this->connect_mysql();
      $sql = $conn->prepare("INSERT INTO announce_news SET topic='$modal_topic', publish_date='$modal_date',end_date='$modal_end_date', ack_status='active'");
      $sql->execute();
  
  }

  function updatenews(){

    $modal_newsid = $_POST['modal_newsid'];
    $modal_topic = $_POST['modal_topic'];
    $modal_date = $_POST['modal_date'];
    $modal_end_date = $_POST['modal_end_date'];
    $modal_ack_status = $_POST['modal_ack_status'];

    $conn=$this->connect_mysql();
      $sql = $conn->prepare("UPDATE announce_news SET topic='$modal_topic', publish_date='$modal_date',end_date='$modal_end_date',ack_status='$modal_ack_status' WHERE id='$modal_newsid'");
      $sql->execute();
  
  }

  function deletenews(){

    $id = $_POST['id'];
    $file_name = $_POST['file_name'];

    $conn=$this->connect_mysql();
      $sql = $conn->prepare("DELETE FROM announce_news WHERE id='$id'");
      $sql->execute();

      $link_file = "../news/".$file_name;
      unlink($link_file);

  }

  function updatestatus(){
    $id = $_POST['id'];
    $stat = $_POST['stat'];
    if($stat=="active"){
      $stat = "inactive";
    }else{
      $stat = "active";
    }
    $conn = $this->connect_mysql();
    $sql = $conn->prepare("UPDATE announce_news SET ack_status=:ack_status WHERE id=:id");
    $sql->bindParam("ack_status",$stat);
    $sql->bindParam("id",$id);
    $sql->execute();
  }

  function load_news(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM announce_news");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $data['action'] = '<button onclick="dl_news(\''.$x['file_name'].'\')" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> View</button>
          <button onclick="delete_news('.$x['id'].',\''.$x['file_name'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button>';
          $data['topic'] = $x['topic'];
          $data['publish_date'] = date('F d, Y',strtotime($x['publish_date']));
          $data['end_date'] = date('F d, Y',strtotime($x['end_date']));

          if($x['ack_status']=="active"){
            $data['ack_status'] = '<label class="switch">
                  <input type="checkbox" onchange="activestatuschange('.$x['id'].',\''.$x['ack_status'].'\')" checked>
                  <span class="slider round"></span>
                </label><span style="color: black"> Active</span>';
          }else{
            $data['ack_status'] = '<label class="switch">
                  <input type="checkbox" onchange="activestatuschange('.$x['id'].',\''.$x['ack_status'].'\')">
                  <span class="slider round"></span>
                </label><span style="color: black"> Inactive</span>';
          }

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function newsfile(){

    if (($_FILES['news_file']['name']!="")){

      $modal_topic = $_POST['modal_topic'];
      $modal_date = $_POST['modal_date'];
      $modal_end_date = $_POST['modal_end_date'];

      // Where the file is going to be stored
       $target_dir = "../news/";
       $file = $_FILES['news_file']['name'];
       $path = pathinfo($file);
       $filename = $path['filename'];
       $ext = $path['extension'];
       $attachfile = $filename.".".$ext;
       $temp_name = $_FILES['news_file']['tmp_name'];
       $path_filename_ext = $target_dir.$filename.".".$ext;
      // Check if file already exists
       if (file_exists($path_filename_ext)) {
        echo "Sorry, file already exists.";
       }else{
        
        $file_upload = $target_dir.$attachfile;
        unlink($file_upload);

          move_uploaded_file($temp_name,$path_filename_ext);

          $conn=$this->connect_mysql();
          $sql = $conn->prepare("INSERT INTO announce_news SET topic='$modal_topic', publish_date='$modal_date', end_date='$modal_end_date', file_name='$attachfile', ack_status='active'");
          $sql->execute();

          session_start();
          $useraction = $_SESSION['fullname'];
          $dateaction = date('Y-m-d');
          $auditaction = "Added new announcement ".$modal_topic;
          $audittype = "ADD";
          $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
          $q->execute();

          header("location:../announcement.php");
          
       }
    }


  }

  function load_audit(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM audit_trail ORDER BY id DESC");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $data['audit_date'] = date('F d, Y',strtotime($x['audit_date']));
          $data['action_type'] = $x['action_type'];
          $data['audit_action'] = $x['audit_action'];
          $data['end_user'] = utf8_decode($x['end_user']);

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

}

$x = new crud();

if(isset($_GET['load_audit'])){
  $x->load_audit();
}
if(isset($_GET['addnews'])){
  $x->addnews();
}
if(isset($_GET['updatenews'])){
  $x->updatenews();
}
if(isset($_GET['deletenews'])){
  $x->deletenews();
}
if(isset($_GET['updatestatus'])){
  $x->updatestatus();
}
if(isset($_GET['load_news'])){
  $x->load_news();
}
if(isset($_GET['newsfile'])){
  $x->newsfile();
}

 ?>