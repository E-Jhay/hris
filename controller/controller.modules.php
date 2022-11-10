<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function view_announce(){
    $id = $_POST['id'];
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM announce_news WHERE id='$id'");
    $query->execute();
    $row = $query->fetch();
    echo json_encode(array(
      'topic'=>$row['topic'],
      'publish_date'=>date('F d, Y',strtotime($row['publish_date'])),
      'end_date'=>date('F d, Y',strtotime($row['end_date'])),
      'file_name'=>$row['file_name'],
      'ack_status'=>$row['ack_status']

    ));
  }

  public function getAnnouncements(){
    $datenow = date('Y-m-d');
    $conn = $this->connect_mysql();
    $stmt = $conn->prepare("SELECT * FROM announce_news WHERE publish_date <= '$datenow' AND end_date >= '$datenow' AND ack_status='active'");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
  }

  public function getBirthdaycelebrators(){
    $m = date('m');
    $conn = $this->connect_mysql();
    $stmt = $conn->prepare("SELECT a.imagepic,a.lastname,a.firstname,a.department,b.dateofbirth FROM tbl_employee a
                            LEFT JOIN otherpersonalinfo b ON a.id=b.emp_id WHERE MONTH(dateofbirth) = '$m' ORDER BY DAY(dateofbirth) ASC");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
  }

}

$x = new crud();

if(isset($_GET['view_announce'])){
  $x->view_announce();
}

 ?>
