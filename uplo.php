<?php 
session_start();

$usertype = $_SESSION['usertype'];
$empno = $_SESSION['employeeno'];
$approver = $_SESSION['approver'];


if(!isset($_SESSION['fullname'])){
  header("location:index.php");
}
require_once "header.php";
require_once "controller/controller.leave.php";
$leaves = new crud();
$count = $leaves->countLeaves($empno);
 ?>

<div class="sidenavigation">
  <?php 
  require_once "ess_tab.php";
   ?>
</div>

<div class="navtabs">
      
      <ul class="nav nav-tabs bb-none">
        <li class="nav-item">
          <a class="nav-link active" id="" href="#">Upload Payslip</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_timesheets" class="div_content">
    <button class="btn btn-sm btn-success" type="button" onclick="upload_pslip()"><i class="fas fa-sm fa-upload"></i> Upload Payslip</button><br><br>
    <table class="table table-striped w-100" id="tbl_payslip">
        <thead>
          <th>Name</th>
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

<div class="modal fade" id="userrole_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Payslip Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="controller/controller.upload.php?uploadpayslip" enctype="multipart/form-data">
          <div class="form-group">
            <label>Employee:</label>
            <select class="form-control" id="employeeddown" required="" name="employeeddown"></select>
          </div>

          <div class="form-group">
            <label>Process Date:</label>
            <input type="date" value="<?php echo date('Y-m-d') ?>" required class="form-control" id="processdate" name="processdate">
          </div>

          <div class="form-group">
            <label>Date From:</label>
            <input type="date" class="form-control" required="" id="datefrom" name="datefrom">
          </div>

          <div class="form-group">
            <label>Date To:</label>
            <input type="date" class="form-control" required="" id="dateto" name="dateto">
          </div>

          <div class="form-group d-none">
            <label>Employee id:</label>
            <input type="text" class="form-control" id="employeeid" name="employeeid" value="<?php echo $_GET['id'] ?>">
          </div>

          <div class="form-group d-none">
            <label>Employee no:</label>
            <input type="text" class="form-control" id="employeeno" name="employeeno">
          </div>

          <div class="form-group">
            <label>File:</label>
            <input type="file" class="form-control" required="" id="empfile" name="empfile">
          </div>
          
          <center>
            <button type="submit" class="btn btn-sm btn-success">Upload</button>
          </center>
        </form>

      </div>

    </div>
  </div>
</div>

<input type="hidden" id="employeenum" value="<?php echo $empno ?>" name="">
<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">

</body>
<script src="services/upload.js"></script>
</html>