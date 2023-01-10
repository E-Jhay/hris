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
          <a class="nav-link active" id="leave_tab" href="#" onclick="btnLeave()">Leave Notifications <span class="notif_span" id="leave_notif_count"></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="omnibus_tab" href="#" onclick="btnOmnibus()">Omnibus Notifications <span class="notif_span" id="omnibus_notif_count"></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="overtime_tab" href="#" onclick="btnOvertime()">Overtime Notifications <span class="notif_span" id="overtime_notif_count"></span></a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_leave" class="div_content">
      <table class="table table-striped w-100" id="tbl_notif_leave">
        <thead>
          <th>Message</th>
          <th>Date & Time</th>
        </thead>
        <tbody>
                
        </tbody>
      </table>
  </div>
  <div id="div_omnibus" class="div_content">
      <table class="table table-striped w-100" id="tbl_notif_omnibus">
        <thead>
          <th>Message</th>
          <th>Date & Time</th>
        </thead>
        <tbody>
                
        </tbody>
      </table>
  </div>
  <div id="div_overtime" class="div_content">
      <table class="table table-striped w-100" id="tbl_notif_overtime">
        <thead>
          <th>Message</th>
          <th>Date & Time</th>
        </thead>
        <tbody>
                
        </tbody>
      </table>
  </div>
 
</div>

<!-- <input type="hidden" id="employeenum" value="<?php echo $empno ?>" name=""> -->
<input type="hidden" id="currentUser" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">
</body>
<script src="services/notification.js"></script>
</html>