<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function get_reimbal(){

      $employeeno = $_POST['employeeno'];
      $conn = $this->connect_mysql();
      $qry = $conn->prepare("SELECT reimbursement_bal FROM tbl_employee WHERE employeeno='$employeeno'");
      $qry->execute();
      $row = $qry->fetch();
      $reimbursement_bal = $row['reimbursement_bal'];
      echo json_encode(array("reimbursement_bal"=>$reimbursement_bal));

  }

  function delete_reimbursement(){
    $id = $_POST['id'];
    $file_name = $_POST['file_name'];
    $employeeno = $_POST['employeeno'];

    $conn = $this->connect_mysql();
    $query = $conn->prepare("DELETE FROM tbl_reimbursement WHERE id='$id'");
    $query->execute();

    $link_file = "../reimbursement/".$employeeno."/".$file_name;
    unlink($link_file);
 }

 function load_myreimburse(){

    $type = $_GET['type'];
    $employeeno = $_GET['employeeno'];
    $conn = $this->connect_mysql();
    if($type=="all"){
      $statuss = $_GET['statuss'];
      if($statuss==""){
        $query = $conn->prepare("SELECT a.*,b.lastname,b.firstname,b.reimbursement_bal FROM tbl_reimbursement a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno ORDER BY a.datee DESC");
      }else{
        $query = $conn->prepare("SELECT a.*,b.lastname,b.firstname,b.reimbursement_bal FROM tbl_reimbursement a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.statuss='$statuss' ORDER BY a.datee DESC");
      }
      
    }else if($type="personal"){
      $query = $conn->prepare("SELECT a.*,b.lastname,b.firstname,b.reimbursement_bal FROM tbl_reimbursement a
                               LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.employeeno='$employeeno' ORDER BY a.datee DESC");
    }
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }
          $data = array();
          
          
          // <button onclick="delete_file('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="inv-button-sm btn btn-xs btn-danger" style="font-size:10px"><i class="fa fa-trash"></i> Delete</button>
          $data['employee_name'] = utf8_decode($x['lastname'].', '.$x['firstname']);
          $data['description'] = $x['description'];
          $data['nature'] = $x['nature'];
          $data['amount'] = $x['amount'];
          $data['datee'] = $x['datee'];
          $data['statuss'] = $x['statuss'];

          if($type=="all"){

            $data['action'] = '<center>
            <button title="View details" onclick="view_file('.$x['id'].',\''.$x['employeeno'].'\',\''.$x['description'].'\',\''.$x['nature'].'\',\''.$x['datee'].'\',\''.$x['amount'].'\',\''.$x['file_name'].'\',\''.$x['remarks'].'\',\''.$x['orig_amount'].'\',\''.$x['statuss'].'\',\''.$x['lastname'].'\',\''.$x['firstname'].'\',\''.$x['reimbursement_bal'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i></button>
            <button title="View file" onclick="dl_file(\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-info"><i class="fas fa-sm fa-eye"></i> File</button>
            </center>';

          }else{

            if($x['statuss']=="Pending"){
              
            $data['action'] = '<center>
            <button title="View details" onclick="view_file_personal('.$x['id'].',\''.$x['employeeno'].'\',\''.$x['description'].'\',\''.$x['nature'].'\',\''.$x['datee'].'\',\''.$x['amount'].'\',\''.$x['file_name'].'\',\''.$x['remarks'].'\',\''.$x['orig_amount'].'\',\''.$x['statuss'].'\',\''.$x['lastname'].'\',\''.$x['firstname'].'\',\''.$x['reimbursement_bal'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i></button>
            <button title="View file" onclick="dl_file(\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-info"><i class="fas fa-sm fa-eye"></i> File</button>
            <button title="Delete" onclick="delete_file('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button>
            </center>';

            }else{

              $data['action'] = '<center>
              <button title="View details" onclick="view_file_personal('.$x['id'].',\''.$x['employeeno'].'\',\''.$x['description'].'\',\''.$x['nature'].'\',\''.$x['datee'].'\',\''.$x['amount'].'\',\''.$x['file_name'].'\',\''.$x['remarks'].'\',\''.$x['orig_amount'].'\',\''.$x['statuss'].'\',\''.$x['lastname'].'\',\''.$x['firstname'].'\',\''.$x['reimbursement_bal'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-eye"></i></button>
              <button title="View file" onclick="dl_file(\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-info"><i class="fas fa-sm fa-download"></i> Download File</button>
              <button title="Delete" disabled="" onclick="delete_file('.$x['id'].',\''.$x['file_name'].'\',\''.$x['employeeno'].'\')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i></button>
              </center>';

            }

            

          }

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  function readleave(){

      $employeeno = $_POST['employeeno'];

      $conn = $this->connect_mysql();
      $query = $conn->prepare("UPDATE leave_application SET readd='read' WHERE employeeno='$employeeno'");
      $query->execute();

  }

  function readpayslip(){

      $employeeno = $_POST['employeeno'];

      $conn = $this->connect_mysql();
      $query = $conn->prepare("UPDATE payslips SET stat='read' WHERE employeeno='$employeeno'");
      $query->execute();

  }

  function count_leaveapp(){

    $employeenoo = $_POST['employeenoo'];
    $conn = $this->connect_mysql();

    $sq = $conn->prepare("SELECT department FROM tbl_employee WHERE employeeno='$employeenoo'");
    $sq->execute();
    $rw = $sq->fetch();

    $dept = $rw['department'];

    $query = $conn->prepare("SELECT a.*,a.id as idd,b.* FROM leave_application a
                             LEFT JOIN tbl_employee b ON a.employeeno=b.employeeno WHERE a.status='Pending' ORDER BY a.id DESC");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function count_otapp(){

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM tbl_overtime WHERE statuss='Pending' ORDER BY id DESC");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function count_payslip(){

    $employeenoo = $_POST['employeenoo'];
    $conn = $this->connect_mysql();

    $query = $conn->prepare("SELECT * FROM payslips WHERE employeeno='$employeenoo' AND stat='posted'");
    $query->execute();
    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function count_reimbursement(){

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM tbl_reimbursement WHERE statuss='Pending'");
    $query->execute();

    $count = $query->rowCount();

    echo json_encode(array("count"=>$count));
  }

  function uploadreimbursement(){
    $reimbursement_bal = $_POST['reimbursement_bal'];
    if($reimbursement_bal <=0){
      echo json_encode(array('type' => 'error', 'message' => 'Insufficient balance'));
      exit;
    }else{
      if (($_FILES['empfile']['name']!="")){
        $description = $_POST['description'];
        $nature = $_POST['nature'];
        $amount = $_POST['amount'];
        // $empfile = $_POST['empfile'];
        $emp_no = $_POST['emp_no'];
        $datenow = date('Y-m-d');
        // Where the file is going to be stored
        $target_dir = "../reimbursement/".$emp_no."/";
        $file = $_FILES['empfile']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $today = date("Y-m-d-His");
        $attachfile = $filename."-".$today.".".$ext;
        $temp_name = $_FILES['empfile']['tmp_name'];
        $path_filename_ext = $target_dir.$attachfile;

        if (file_exists($path_filename_ext)) {
          echo json_encode(array("message"=>"Sorry, file already exists.", "type" => "error"));
          exit;
        }else{
          if(!is_dir("../reimbursement/".$emp_no."/")){
            mkdir("../reimbursement/".$emp_no."/", 0777, true);
          }
          if(move_uploaded_file($temp_name,$path_filename_ext)) {
            $conn=$this->connect_mysql();
            $sql = $conn->prepare("INSERT INTO tbl_reimbursement SET employeeno='$emp_no', description='$description', nature='$nature', datee='$datenow', amount='$amount', file_name='$attachfile', statuss='Pending', remarks='',orig_amount='$amount'");
            $sql->execute();
            echo json_encode(array('type' => 'success', 'message' => 'Reimbursement requested successfully'));
            exit;
          } else {
            echo json_encode(array('type' => 'error', 'message' => 'There\'s an error uploading your file'));
            exit;
          }
        }
      }
    }
  }

  public function getallreimburse()
  {
    $conn=$this->connect_mysql();
    $query = "SELECT lastname,firstname,reimbursement_bal FROM tbl_employee";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
  }


}

$x = new crud();

if(isset($_GET['get_reimbal'])){
  $x->get_reimbal();
}
if(isset($_GET['delete_reimbursement'])){
  $x->delete_reimbursement();
}
if(isset($_GET['load_myreimburse'])){
  $x->load_myreimburse();
}
if(isset($_GET['readleave'])){
  $x->readleave();
}
if(isset($_GET['readpayslip'])){
  $x->readpayslip();
}
if(isset($_GET['count_leaveapp'])){
  $x->count_leaveapp();
}
if(isset($_GET['count_otapp'])){
  $x->count_otapp();
}
if(isset($_GET['count_payslip'])){
  $x->count_payslip();
}
if(isset($_GET['count_reimbursement'])){
  $x->count_reimbursement();
}
if(isset($_GET['uploadreimbursement'])){
  $x->uploadreimbursement();
}

 ?>
