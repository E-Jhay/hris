<?php 
session_start();

$usertype = $_SESSION['usertype'];
$empno = $_SESSION['employeeno'];
$approver = $_SESSION['approver'];
$userrole = $_SESSION['userrole'];
if(!isset($_SESSION['fullname'])){
  header("location:index.php");
}
$count = "";
require_once "header.php";
 ?>

<div class="sidenavigation">
  <?php 
  if($userrole == '1'){
    require_once "pim_tab.php";
  }else{
    require_once "ess_tab.php";
  }
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" href="#">My payslip</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_timesheets" class="div_content">
      <table class="table table-striped w-100" id="tbl_payslip">
        <thead>
          <th>File Name</th>
          <th>Payroll Period</th>
          <th>Process Date</th>
          <th class="text-center">Action</th>
        </thead>
        <tbody>
                
        </tbody>
      </table>
  </div>

</div>

<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">

</body>
<script src="services/payslip.js"></script>
</html>