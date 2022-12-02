<?php 
session_start();

$usertype = $_SESSION['usertype'];
$empno = $_SESSION['employeeno'];
$approver = $_SESSION['approver'];
$department = $_SESSION['department'];
$userrole = $_SESSION['userrole'];
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
          <a class="nav-link active" id="personal_memo" href="#" onclick="btnPersonalMemo()">Personal Memorandum</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="inter_office_memo" href="#" onclick="btnInterOfficeMemo()">Inter Office Memorandum</a>
        </li>
      </ul>

</div>

<div class="navcontainer">

  <div id="div_memo" class="div_content">
      <table class="table table-striped w-100" id="tbl_memo">
        <thead>
          <th>Employee no</th>
          <th>Memo Name</th>
          <th>Date</th>
          <th>Remarks</th>
          <th class="text-center">Action</th>
        </thead>
        <tbody>
                
        </tbody>
      </table>
  </div>
  <div id="div_inter_office_memo" class="div_content">
      <table class="table table-striped w-100" id="tbl_inter_office_memo">
        <thead>
          <th>Department Name</th>
          <th>Memo Name</th>
          <th>Date</th>
          <th class="text-center">Action</th>
        </thead>
        <tbody>
          
        </tbody>
      </table>
  </div>

</div>

<div class="modal fade" id="acknowledge_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Overtime Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="acknowledge_form" enctype="multipart/form-data">
            <div class="form-group">
              <input type="hidden" id="memo_id" name="">
              <label for="exampleInputEmail1">Memo Name:</label>
              <input type="text" disabled class="form-control" id="memo_name"></input>
            </div>
            
            <div class="form-group">
              <label for="exampleInputEmail1">Date:</label>
              <input type="text" disabled class="form-control" id="memo_date"></input>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Remarks:</label>
              <input type="text" disabled class="form-control" id="remarks"></input>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Upload Explanation:</label>
              <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <center>
              <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">Submit</button>
            </center>
          </form>
      </div>

    </div>
  </div>
</div>

<input type="hidden" id="employeenum" value="<?php echo $empno ?>" name="">
<input type="hidden" id="employeeno" value="<?php echo $_SESSION['employeeno'] ?>" name="">
<input type="text" id="department" value="<?php echo $_SESSION['department'] ?>" name="">

</body>
<script src="services/essmemo.js"></script> 
</html>