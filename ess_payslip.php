<?php 
session_start();

$usertype = $_SESSION['usertype'];
$empno = $_SESSION['employeeno'];
$approver = $_SESSION['approver'];
if(!isset($_SESSION['fullname'])){
  header("location:index.php");
}
$count = "";
require_once "header.php";
 ?>

<div class="sidenavigation">
  <?php 
  require_once "ess_tab.php";
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
          <th>Action</th>
        </thead>
        <tbody>
                
        </tbody>
      </table>
  </div>

</div>

<input type="hidden" id="employeenum" value="<?php echo $empno ?>" name="">
<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">

</body>
<script src="services/payslip.js"></script>
</html>