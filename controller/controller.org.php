<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function load_geninfo(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT id, org_name, tax_id, numberof_emp, reg_number, cost_center, cost_center_detail, eeo_enable, contact_details, fax, email, address_st, brgy, city, zipcode, country, note FROM general_information WHERE id='1'");
      $sql->execute();
      $row = $sql->fetch();

      foreach ($row as $key => $input_arr) {
          $row[$key] = addslashes($input_arr);
          $row[$key] = utf8_encode($input_arr);
          }

      echo json_encode(array(
        "org_name"=>$row['org_name'],
        "tax_id"=>$row['tax_id'],
        "numberof_emp"=>$row['numberof_emp'],
        "reg_number"=>$row['reg_number'],
        "cost_center"=>$row['cost_center'],
        "cost_center_detail"=>$row['cost_center_detail'],
        "contact_details"=>$row['contact_details'],
        "fax"=>$row['fax'],
        "email"=>$row['email'],
        "address_st"=>$row['address_st'],
        "brgy"=>$row['brgy'],
        "city"=>$row['city'],
        "zipcode"=>$row['zipcode'],
        "country"=>$row['country'],
        "note"=>$row['note']
      ));
  }

  function addlocation(){
    $modal_id = $_POST['modal_id'];
    $modal_name = $_POST['modal_name'];
    $modal_city = $_POST['modal_city'];
    $modal_country = $_POST['modal_country'];
    $modal_phone = $_POST['modal_phone'];
    $modal_noofemployee = $_POST['modal_noofemployee'];

     $conn=$this->connect_mysql();
      $sql = $conn->prepare("INSERT INTO locations SET name='$modal_name', city='$modal_city', country='$modal_country', phone='$modal_phone', numberofemp='$modal_noofemployee', status='active'");
      $sql->execute();


      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Added new location ".$modal_name;
      $audittype = "ADD";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();


  }

  function deletelocation(){
    $id = $_POST['id'];

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("DELETE FROM locations WHERE id='$id'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Deleted a location.";
      $audittype = "Delete";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

  }

  function updatelocation(){

    $modal_id = $_POST['modal_id'];
    $modal_name = $_POST['modal_name'];
    $modal_city = $_POST['modal_city'];
    $modal_country = $_POST['modal_country'];
    $modal_phone = $_POST['modal_phone'];
    $modal_noofemployee = $_POST['modal_noofemployee'];

    $conn=$this->connect_mysql();
      $sql = $conn->prepare("UPDATE locations SET name='$modal_name', city='$modal_city', country='$modal_country', phone='$modal_phone', numberofemp='$modal_noofemployee' WHERE id='$modal_id'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update a location ".$modal_name;
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();

  }

  function updategeninfo(){

    $id = $_POST['id'];
    $org_name = $_POST['org_name'];
    $tax_id = $_POST['tax_id'];
    $numberof_emp = $_POST['numberof_emp'];
    $reg_number = $_POST['reg_number'];
    $cost_center = $_POST['cost_center'];
    $cost_center_detail = $_POST['cost_center_detail'];
    $contact_details = $_POST['contact_details'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];
    $address_st = $_POST['address_st'];
    $brgy = $_POST['brgy'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $country = $_POST['country'];
    $note = $_POST['note'];


      $conn=$this->connect_mysql();
      $sql = $conn->prepare("UPDATE general_information SET org_name='$org_name', tax_id='$tax_id', numberof_emp='$numberof_emp', reg_number='$reg_number', cost_center='$cost_center', cost_center_detail='$cost_center_detail', eeo_enable='no', contact_details='$contact_details', fax='$fax', email='$email', address_st='$address_st', brgy='$brgy', city='$city', zipcode='$zipcode', country='$country', note='$note' WHERE id='1'");
      $sql->execute();

      session_start();
      $useraction = $_SESSION['fullname'];
      $dateaction = date('Y-m-d');
      $auditaction = "Update General Info of the company";
      $audittype = "EDIT";
      $q = $conn->prepare("INSERT INTO audit_trail SET audit_date='$dateaction', end_user='$useraction', audit_action='$auditaction', action_type='$audittype'");
      $q->execute();


  }

  function load_locations(){
    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT * FROM locations");
    $query->execute();
    $row = $query->fetchAll();
    $return = array();
      foreach ($row as $x){

          foreach ($x as $key => $input_arr) {
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
          }

          $data = array();
          $data['action'] = '<center class="d-flex justify-content-around"><button onclick="edit_location('.$x['id'].',\''.$x['name'].'\',\''.$x['city'].'\',\''.$x['country'].'\',\''.$x['phone'].'\',\''.$x['numberofemp'].'\')" class="btn btn-sm btn-success"><i class="fas fa-sm fa-edit"></i> Edit</button>
          <button onclick="delete_location('.$x['id'].')" class="btn btn-sm btn-danger"><i class="fas fa-sm fa-trash-alt"></i> Delete</button></center>';
          $data['name'] = $x['name'];
          $data['city'] = $x['city'];
          $data['country'] = $x['country'];
          $data['phone'] = $x['phone'];
          $data['numberofemp'] = $x['numberofemp'];

        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

}

$x = new crud();

if(isset($_GET['load_geninfo'])){
  $x->load_geninfo();
}

if(isset($_GET['addlocation'])){
  $x->addlocation();
}

if(isset($_GET['deletelocation'])){
  $x->deletelocation();
}

if(isset($_GET['updatelocation'])){
  $x->updatelocation();
}

if(isset($_GET['updategeninfo'])){
  $x->updategeninfo();
}

if(isset($_GET['load_locations'])){
  $x->load_locations();
}

 ?>
