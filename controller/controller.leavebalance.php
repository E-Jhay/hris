<?php  
include 'controller.db.php';

class crud extends db_conn_mysql
{

  public function leave_credits_load(){
      
      $conn = $this->connect_mysql();

      // Select all regular employees
      $query = $conn->prepare("SELECT a.*,b.* FROM tbl_employee a
                              LEFT JOIN contractinfo b
                              ON a.id=b.emp_id ORDER BY a.id_number ASC");
      $query->execute();
      $row = $query->fetchAll();

      foreach ($row as $x){
        foreach ($x as $key => $input_arr) { 
          $x[$key] = addslashes($input_arr);
          $x[$key] = utf8_encode($input_arr);
        }

        $employee_no = $x['employeeno'];
        

        $q2 = $conn->prepare("SELECT * FROM leave_balance WHERE employee_no='$employee_no' AND leave_type='SL'");
        $q2->execute();
        $countsl = $q2->rowCount();

        $q3 = $conn->prepare("SELECT * FROM leave_balance WHERE employee_no='$employee_no' AND leave_type='VL'");
        $q3->execute();
        $countvl = $q3->rowCount();

        if($countsl <= 0){
          $q4 = $conn->prepare("INSERT INTO leave_balance SET employee_no='$employee_no',leave_type='SL',balance='0',earned='no',what_month='0', stat='', decem=''");
          $q4->execute();
        }

        if($countvl <= 0){
          $q4 = $conn->prepare("INSERT INTO leave_balance SET employee_no='$employee_no',leave_type='VL',balance='0',earned='no',what_month='0', stat='', decem=''");
          $q4->execute();
        }

        $query2 = $conn->prepare("SELECT what_month,balance FROM leave_balance WHERE employee_no='$employee_no' AND leave_type='SL'");
        $query2->execute();
        $row2 = $query2->fetch();
        if($row2['balance']=="" || $row2['balance'] < 0){
          $row2['balance'] = 0;
        }

        $query3 = $conn->prepare("SELECT what_month,balance FROM leave_balance WHERE employee_no='$employee_no' AND leave_type='VL'");
        $query3->execute();
        $row3 = $query3->fetch();
        if($row3['balance']=="" || $row3['balance'] < 0){
          $row3['balance'] = 0;
        }

        $hiredate = $x['date_hired'];
        $htime = strtotime($hiredate);

        $years = date('Y') - date('Y', $htime);

        if (date('m') < date('m', $htime)) {
            $years--;
            $months = date('n') + 12 - date('n', $htime);
        }
        elseif (date('m') == date('m', $htime))
        {
            if (date('d') < date('d', $htime))
            {
                $years--;
                $months = 11;    
            }
            else $months = 0;
        }
        else $months = date('n') - date('n', $htime);


        switch($years) {
          case 0:
            $earnedPoints = 0;
            break;
          case 1:
            if($row2['balance'] == 0 && $row3['balance'] == 0){
              if(date('n') == 1){
                $earnedPoints = 5;
              }
              else $earnedPoints = 0;
            } else $earnedPoints = 0;
            break;
          case 2:
            $earnedPoints = 0.5;
            break;
          case 3:
          case 4:
            $earnedPoints = 0.583;
            break;
          case 5:
          case 6:
          case 7:
            $earnedPoints = 0.75;
            break;
          case 8:
          case 9:
          case 10:
            $earnedPoints = 0.83;
            break;
          case 11:
          case 12:
          case 13:
          case 14:
          case 15:
            $earnedPoints = 1;
            break;
          default:
            $earnedPoints = 1.25;
            break;
        }
          $newsl = round($row2['balance'] + $earnedPoints,3);
          $newvl = round($row3['balance'] + $earnedPoints,3);

        $lastMonthUpdate =$row2['what_month'];
        $monthNow = date('m');
      //   $date_hired = $x['date_hired'];
      //   $date_today = date('Y-m-d');
      //   $date_today = "2020-07-27";
      //   $ed = date('d',strtotime($date_today));

      //   $emm = date('m', strtotime($x['date_hired']));
      //   $edd = date('d', strtotime($x['date_hired']));

      //   $yr = "";
      //   $stst = "";
      //   $years=  date('Y',strtotime($date_today)) - date('Y', strtotime($x['date_hired']));
      //   $months = date('m',strtotime($date_today)) - date('m', strtotime($x['date_hired']));
      //   $days = date('d',strtotime($date_today)) - date('d', strtotime($x['date_hired']));
      //   if($days < 0){
      //     $months -= 1;
      //   }

      //   if($months < 0){
      //       $months = 0;
      //       $years -=1;
      //       if($years==1){
      //         $yr = "more1year";
      //       }else if($years==2){
      //         $yr = "more2years";
      //       }else if($years==4){
      //         $yr = "more4years";
      //       }else if($years==7){
      //         $yr = "more7years";
      //       }else if($years==10){
      //         $yr = "more10years";
      //       }else if($years==15){
      //         $yr = "more15years";
      //       }
      //   }

      //     $epts = 0;
      //     if($years == 1){

      //       if($row2['balance'] == 0 && $row3['balance'] == 0){
      //         $epts = 5;
      //       }else if($yr=="more1year"){
      //         $epts = 0.5;
      //       }else{
      //         $epts = 0;
      //       }

      //     }else if($years == 2){
      //       $epts = 0.5;
      //       if($yr=="more2years"){
      //         $epts = 0.583;
      //       }
      //     }else if($years >=3 && $years <=4){
      //       $epts = 0.583;
      //       if($yr=="more4years"){
      //         $epts = 0.75;
      //       }
      //     }else if($years >=5 && $years <=7){
      //       $epts = 0.75;
      //       if($yr=="more7years"){
      //         $epts = 0.83;
      //       }
      //     }else if($years >=8 && $years <=10){
      //       $epts = 0.83;
      //       if($yr=="more10years"){
      //         $epts = 1;
      //       }
      //     }else if($years >=11 && $years <=15){
      //       $epts = 1;
      //       if($yr=="more15years"){
      //         $epts = 1.25;
      //       }
      //     }else if($years > 15){
      //       $epts = 1.25;
      //     }

      //     $earned_leave = $epts;
      //     $newsl = round($row2['balance'] + $earned_leave,3);
      //     $newvl = round($row3['balance'] + $earned_leave,3);

          if($lastMonthUpdate != $monthNow){
            if($years > 1) {
              $slQuery = $conn->prepare("UPDATE leave_balance SET balance='$newsl',earned='yes',what_month='$monthNow' WHERE employee_no='$employee_no' AND leave_type='SL' AND what_month !='$monthNow'");

              $vlQuery = $conn->prepare("UPDATE leave_balance SET balance='$newvl',earned='yes',what_month='$monthNow' WHERE employee_no='$employee_no' AND leave_type='VL' AND what_month !='$monthNow'");
            } else {
              $slQuery = $conn->prepare("UPDATE leave_balance SET balance='$newsl',earned='no',what_month='$monthNow' WHERE employee_no='$employee_no' AND leave_type='SL' AND what_month !='$monthNow'");

              $vlQuery = $conn->prepare("UPDATE leave_balance SET balance='$newvl',earned='no',what_month='$monthNow' WHERE employee_no='$employee_no' AND leave_type='VL' AND what_month !='$monthNow'");
            }

            $slQuery->execute();
            $vlQuery->execute();
            

              // $query23 = $conn->prepare("UPDATE leave_balance SET earned='no' WHERE employee_no='$employee_no' AND leave_type='SL' AND earned='yes' AND what_month !='$em'");
              // $query23->execute();

              // $query24 = $conn->prepare("UPDATE leave_balance SET earned='no' WHERE employee_no='$employee_no' AND leave_type='VL' AND earned='yes' AND what_month !='$em'");
              // $query24->execute();

          }
        //   $dec1 = 01;
        //   $dec = 12;
        //   if($ed >= $dec1 && $em == $dec){

        //       $query23 = $conn->prepare("UPDATE leave_balance SET balance='$newsl',earned='yes',what_month='$em' WHERE employee_no='$employee_no' AND leave_type='SL' AND earned='no' AND what_month !='$em'");
        //       $query23->execute();

        //       $query24 = $conn->prepare("UPDATE leave_balance SET balance='$newvl',earned='yes',what_month='$em' WHERE employee_no='$employee_no' AND leave_type='VL' AND earned='no' AND what_month !='$em'");
        //       $query24->execute();

        //  }

        //  if($edd >= 27 && $ed >= 27){   

        //       $query23 = $conn->prepare("UPDATE leave_balance SET balance='$newsl',earned='yes',what_month='$em' WHERE employee_no='$employee_no' AND leave_type='SL' AND earned='no' AND what_month !='$em'");
        //       $query23->execute();

        //       $query24 = $conn->prepare("UPDATE leave_balance SET balance='$newvl',earned='yes',what_month='$em' WHERE employee_no='$employee_no' AND leave_type='VL' AND earned='no' AND what_month !='$em'");
        //       $query24->execute();

        //  }

        //   if($edd <= $ed){

        //       $query23 = $conn->prepare("UPDATE leave_balance SET balance='$newsl',earned='yes',what_month='$em' WHERE employee_no='$employee_no' AND leave_type='SL' AND earned='no' AND what_month !='$em'");
        //       $query23->execute();

        //       $query24 = $conn->prepare("UPDATE leave_balance SET balance='$newvl',earned='yes',what_month='$em' WHERE employee_no='$employee_no' AND leave_type='VL' AND earned='no' AND what_month !='$em'");
        //       $query24->execute();

        //   }

      }

      // $edate = $emm.' '.$edd ;

      
      
      // echo json_encode(array("datee"=>$edate));
  
  }

  public function getleavebal()
  {
    $conn = $this->connect_mysql();
    $query = "SELECT a.*,b.* FROM tbl_employee a LEFT JOIN contractinfo b ON a.id=b.emp_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
  }

  public function getSLbal($employeeno)
  {

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT balance FROM leave_balance WHERE employee_no='$employeeno' AND leave_type='SL'");
    $query->execute();
    $row = $query->fetch();
    if($row['balance']==""){
      $row['balance'] = 0;
    }
    return $row['balance'];
  }

  public function getVLbal($employeeno)
  {

    $conn = $this->connect_mysql();
    $query = $conn->prepare("SELECT balance FROM leave_balance WHERE employee_no='$employeeno' AND leave_type='VL'");
    $query->execute();
    $row = $query->fetch();
    if($row['balance']==""){
      $row['balance'] = 0;
    }
    return $row['balance'];
  }


}

$x = new crud();

if(isset($_GET['leave_credits_load'])){
  $x->leave_credits_load();
}

?>
