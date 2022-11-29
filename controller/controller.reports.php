<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  function demp_stat(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM employment_status ORDER BY employment_status ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Employment Status--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['employment_status'].'">'.$row['employment_status'].'</option>';}
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
  function d_jobcategory(){

      $conn=$this->connect_mysql();
      $sql = $conn->prepare("SELECT * FROM job_categories ORDER BY job_category ASC");
      $sql->execute();
      $option = '<option value="" disabled="" selected="">--Select Job category--</option>';
      while($row=$sql->fetch()){ $option.='<option value="'.$row['job_category'].'">'.$row['job_category'].'</option>';}
      echo $option;
  }

  function loademployeereport(){

    $type = $_GET['type'];
    $from = $_GET['from'];
    $to  = $_GET['to'];
    $conn = $this->connect_mysql();
    if($type=="all"){
    
      $query = $conn->prepare("SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id  ORDER BY a.lastname ASC");
    }else if($type=="bday"){
      
       $query = $conn->prepare("SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE EXTRACT(MONTH FROM c.dateofbirth) BETWEEN '$from' AND '$to' ORDER BY a.lastname ASC");
    }else if($type=="gender"){
        if($from=="All"){
            $query = $conn->prepare("SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id ORDER BY a.lastname ASC");
        }else{
            $query = $conn->prepare("SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE c.gender='$from' ORDER BY a.lastname ASC");
        }
       
    }else if($type=="employment"){
      
       $query = $conn->prepare("SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE a.employment_status='$from' ORDER BY a.lastname ASC");
    }else if($type=="division"){
      
       $query = $conn->prepare("SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE a.department='$from' ORDER BY a.lastname ASC");
    }else if($type=="job_category"){
      
       $query = $conn->prepare("SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE a.job_category='$from' ORDER BY a.lastname ASC");
    }else if($type=="age"){
      
       $query = $conn->prepare("SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id
        WHERE YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) BETWEEN '$from' AND '$to' ORDER BY a.lastname ASC");
    }else if($type=="evaluation"){
      
      $query = $conn->prepare("SELECT a.*,b.*,c.*,
           YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                            LEFT JOIN contractinfo b ON a.id=b.emp_id
                            LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id
       WHERE (YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5))) AND (YEAR(date_hired) = YEAR(DATE(NOW() - INTERVAL '$from' MONTH)) AND MONTH(date_hired) = MONTH(DATE(NOW() - INTERVAL '$from' MONTH)) AND DAY(date_hired) >= DAY(DATE(NOW() - INTERVAL '$from' MONTH))) ORDER BY a.lastname ASC");
   }else{
      
       $query = $conn->prepare("SELECT a.*,b.*,c.*,
            YEAR(CURRENT_TIMESTAMP) - YEAR(c.dateofbirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(c.dateofbirth, 5)) as age FROM tbl_employee a
                             LEFT JOIN contractinfo b ON a.id=b.emp_id
                             LEFT JOIN otherpersonalinfo c ON a.id=c.emp_id WHERE b.date_hired BETWEEN '$from' AND '$to' ORDER BY a.lastname ASC");
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
          $data['action'] = '<center>
          <button onclick="editemp('.$x['id'].')" class="inv-button-sm btn btn-xs btn-primary" style="font-size:10px"><i class="fa fa-eye"></i> View</button>
          <button onclick="deleteemp('.$x['id'].')" class="inv-button-sm btn btn-xs btn-danger" style="font-size:10px"><i class="fa fa-trash"></i> Delete</button>
          
          </center>
          ';
          $data['employeeno'] = $x['employeeno'];
          $data['lastname'] = utf8_decode($x['lastname']);
          $data['firstname'] = $x['firstname'];
          $data['middlename'] = $x['middlename'];
          $data['birthdate'] = $x['dateofbirth'];
          $from = new DateTime($x['dateofbirth']);
          $to   = new DateTime('today');
          $age = $from->diff($to)->y;

          if($age> 1000){
            $age = "";
          }

          $data['age'] = $age;
          $data['gender'] = $x['gender'];
          $data['employment_status'] = $x['employment_status'];
          $data['company'] = $x['company'];
          $data['job_title'] = $x['job_title'];
          $data['job_category'] = $x['job_category'];
        
        $return[] = $data;
      }
    
    echo json_encode(array('data'=>$return));
  }

  // public function monthsEvaluation(){
  //   $date_hired = new DateTime('2020-10-01');
  //   $target = new DateTime('2020-12-25');
  //   $interval = $date_hired->diff($target);
  //   echo $interval->format('%y years, %m month, %d days until Christmas.');
  //   // $date1 = '2022-07-28';
  //   // // $dateNow = '2010-02-20';
  //   // $d1 = strtotime(date1); 
  //   // $d2=new DateTime();                                  
  //   // $Months = $d2->diff($d1); 
  //   // $howeverManyMonths = (($Months->y) * 12) + ($Months->m);
  //   // // $days = ($d2 - $d1) / (60*60*24);

  //   // var_dump($howeverManyMonths, $days);
  // }


}

$x = new crud();

if(isset($_GET['demp_stat'])){
  $x->demp_stat();
}
if(isset($_GET['ddepartment'])){
  $x->ddepartment();
}
if(isset($_GET['d_jobcategory'])){
  $x->d_jobcategory();
}
if(isset($_GET['loademployeereport'])){
  $x->loademployeereport();
}
// if(isset($_GET['monthsEvaluation'])){
//   $x->monthsEvaluation();
// }

 ?>